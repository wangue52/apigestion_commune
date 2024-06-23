<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use App\Http\Requests\userRequest;
use App\Http\Resources\userRessource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\mail\PasswordResetEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
class registerController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|', // Enforce minimum password length
            'type' => 'required|in:agent,receveur,maire',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
          };
          if ($request->hasFile('avatar')) {
            $profilePicturePath = $request->file('avatar')->store('app/public/uploads');
            $profilePicturePath = str_replace('public/', '', $profilePicturePath);
            } else {
            $profilePicturePath = null;
            };
        // Create a new user instance with validated data
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => $request->type === 'agent' ? 'agent' : ($request->type === 'receveur' ? 'receveur': 'receveur'),
            'phone' => $request->phone,
            'address' => $request->address,
             'avatar' => $profilePicturePath,
        ]);

         $matricule=$this->generateMatricule($user->id) ;
         $user->matricule=$matricule ;
         $user->update(['matricule' =>$matricule]);
        $token = $user->createToken('auth_token')->plainTextToken;
       return response()->json([
        'data'          => $user,
         'access_token'  => $token,
         'token_type'    => 'Bearer',
         'profil' => $profilePicturePath,
     ]);
    }

    public function generateMatricule($id)
    {
        $store = User::findOrfail($id);
        $prefix = substr($store->name, 0, 3);
        $count = User::whereYear('created_at', date('Y'))->count() + 1;
        $matricule = $prefix . date('y') . str_pad($count, 3, '0', STR_PAD_LEFT);

        return $matricule;
    }
    public function login(Request $request)
{
    $request->validate([
    'email' => 'required|string|email',
    'password' => 'required|string'
    ]);

    $credentials = request(['email','password']);
    if(!Auth::attempt($credentials))
    {
    return response()->json([
        'message' => 'Unauthorized'
    ],401);
    }

    $user = $request->user();
    $tokenResult = $user->createToken('Personal Access Token');
    $token = $tokenResult->plainTextToken;

    return response()->json([
    'accessToken' =>$token,
    'token_type' => 'Bearer',
    'type' =>$user->type ,
    ]);
}
public function user(Request $request)
{
    return response()->json($request->user());
}
public function logout(Request $request)
{
    $request->user()->tokens()->delete();

    return response()->json([
    'message' => 'Successfully logged out'
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

        Mail::to($user->email)->send(new PasswordResetEmail($user, $token, $emailData['url']));
    }




}






