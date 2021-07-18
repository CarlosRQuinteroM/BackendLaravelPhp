<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function index()
    {
        $users = auth()->user()->users;

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function show($id)
    {
        $user = auth()->user()->find($id);

        if (!$user && $id === $id) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $user->toArray()
        ], 400);
    }



    public function update(Request $request, User $user, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return $user;
        // return response()->json($user, status:200);
    }





    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
