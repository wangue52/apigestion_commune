<?php

namespace App\Http\Controllers;


use App\Http\Requests\registerRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class registerController extends Controller
{
    public function register(registerRequest $request , User $user)
    {
        $userData = $request->validated();
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $this->uploadAvatar($request , $user->id);
            $userData['avatar'] = $avatarPath;
        }
        $userData['password'] = Hash::make($userData['password']);

        $user = User::create($userData);

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ], 201);
       
    }
    public function uploadAvatar(Request $request, $id)
    {
        $user = User::find($id);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('uploads/avatars'), $avatarName);

            $user->update(['avatar' => $avatarName]);

            return response()->json(['message' => 'Avatar uploaded successfully']);
        } else {
            return response()->json(['error' => 'No file provided'], 400);
        }
    }
}
