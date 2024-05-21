<?php

namespace App\Http\Controllers;
use App\Http\Requests\loginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\mail\PasswordResetEmail;
use Illuminate\Support\Facades\Mail;

class loginController extends Controller
{
    public function login(loginRequest $request)
    {
          $loginUserData = $request->validate();
        
            $user = User::where('email', $loginUserData['email'])->first();
        
            if (!$user) {
                return response()->json([
                    'message' => 'Invalid email address',
                ], 401);
            }
        
            if (!Hash::check($loginUserData['password'], $user->password)) {
                return response()->json([
                    'message' => 'Invalid password',
                ], 401);
            }
        
            // Handle user type differentiation
            $userType = $user->type; // Assuming 'type' field exists in the User model
            $responseData = [];
        
            switch ($userType) {
                case 0 :
                    $responseData['access_token'] = $user->createToken($user->name . '-AuthToken')->plainTextToken;
                    $responseData['message'] = 'Welcome, administrator!';
                    redirect() ;
                    break;
                case 1 :
                    $responseData['access_token'] = $user->createToken($user->name . '-AuthToken')->plainTextToken;
                    $responseData['message'] = 'Welcome, editor!';
                    redirect() ;
                    break;
                case 2 :
                    $responseData['access_token'] = $user->createToken($user->name . '-AuthToken')->plainTextToken;
                    $responseData['message'] = 'Welcome, user!';
                    redirect() ;
                    break;
                default:
                    return response()->json([
                        'message' => 'Invalid user type',
                    ], 401);
            }
        
            return response()->json($responseData);
        }
        
    public function logout(User $user){
        $user->token()->revoke();
        return response()->json([
            'message' => __('auth.logout_success')
        ]);
    }
    public function forgetPassword(loginRequest $request)
    {
        // Validate request data
        $loginUserData = $request->validate();
    
        $user = User::whereEmail($loginUserData['email'])->first();
    
        // Check if user exists
        if (!$user) {
            return response()->json([
                'essage' => __('auth.invalid_credentials')
            ], 401);
        }
    
        // Generate a secure password reset token
        $token = bin2hex(random_bytes(32));
    
        // Create a password reset record in the database
        $passwordReset = PasswordResetEmail::create([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);
    
        // Send a password reset email to the user
        $this->sendPasswordResetEmail($user, $token);
    
        // Return a success response
        return response()->json([
            'message' => __('auth.password_reset_link_sent')
        ], 200);
    }
    
    private function sendPasswordResetEmail($user, $token)
    {
        // Prepare email content
        $emailData = [
            'user' => $user,
            'token' => $token,
            'url' => route('password.reset', ['token' => $token]),
        ];
    
        // Send email using appropriate mailer service
        // (Replace with your preferred email sending mechanism)
        Mail::to($user->email)->send(new PasswordResetEmail($user, $token, $emailData['url']));
    }
}




