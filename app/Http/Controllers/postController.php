<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $post = Post::all();

        if ($user->id == 5) {

            return response()->json([
                'success' => true,
                'data' => $post,
            ], 200);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para realizar esta acción.',
            ], 400);
        }
    }


    public function show($id)
    {
        $user = auth()->user();

        $post = Post::all();

        if ($user->id == 5) {

            return response()->json([
                'success' => true,
                'data' => $post,
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para realizar esta acción.',
            ], 400);
        }
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'party_id' => 'required',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->party_id = $request->party_id;

        if (auth()->user()->posts()->save($post))
            return response()->json([
                'success' => true,
                'data' => $post->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post not added'
            ], 500);
    }

    public function showByUserId(Request $request)
    {
        $user = auth()->user();

        if ($user->id == $request->user_id) {

            $post = Post::where('user_id', '=', $request->user_id)->get();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró mensaje con esa id',
                ], 400);
            } elseif ($post->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró mensaje con esa id',
                ], 400);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => $post,
                ], 200);
            }
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Necesitas ser el usuario creador.',
            ], 400);
        }
    }


    public function showByPartyId(Request $request)
    {
        $user = auth()->user();


        // chequea si ya esta en la party
        $checkUserInParty = Post::where('party_id', '=', $request->party_id)->where('user_id', '=', $user->id)->get();

        if ($checkUserInParty->isEmpty()) {

            return response()->json([
                'success' => false,
                'message' => 'El usuario no esta en esa party',
            ], 400);
        } else {

            $post = Post::where('party_id', '=', $request->party_id)->get();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se ha encontrado ningun mensaje',
                ], 400);
            } elseif ($post->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se ha encontrado ningun mensaje',
                ], 400);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => $post,
                ], 200);
            }
        }
    }








    public function update(Request $request, $id)
    {
        $post = auth()->user()->posts()->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }

        $updated = $post->fill($request->all())->save();

        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post can not be updated'
            ], 500);
    }

    public function destroy($id)
    {
        $post = auth()->user()->posts()->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }

        if ($post->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post can not be deleted'
            ], 500);
        }
    }
}
