<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\userRessource;
use App\Models\User;

class userController extends Controller
{
    public function index()
    {
        $users = User::all();
        return userRessource::collection($users);
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        return new userRessource($user);
    }

    public function show($id)
    {
        $user = User::find($id);
        return new userRessource($user);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return new userRessource($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
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
    public function search(Request $request)
    {
        $query = $request->query('query');

        $users = User::where('name', 'like', "%$query%")
                      ->orWhere('username', 'like', "%$query%")
                      ->get();

        return userRessource::collection($users);
    }

}


