<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class gameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function title(Request $request)
    {
        $game = Game::where('title', $request->title)->get();
        if (!$game) {
            return response()->json([
                'success' => false,
                'message' => 'Game not found'
            ], 400);
        } else {
            return response()->json([
                'success' => true,
                'data' => $game
            ], 200);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->id == 5) {
            $this->validate($request, [
                // 'user_id' => 'required',
                'title' => 'required',
                'imagen' => 'required',
            ]);
        }
        
        
        $game = Game::create([
            // 'user_id' => $user->id,
            'title' => $request->title,
            'imagen' => $request->imagen,
        ]);
        

        if (!$game ) {
            return response()->json([
                'success' => false,
                'data' => 'Game not created'
            ], 400);
        } else {
            return response()->json([
                'success' => true,
                'data' => $game,
            ], 200);
        }
    }

    public function getGameById(Request $request, $id)
    {
        $game = Game::where('id', $id)->get();
        return response()->json([
            'success' => true,
            'data' => $game,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        $games = Game::all();

        if (!$games) {
            return response()->json([
                'success' => false,
                'message' => 'No games found'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $games
        ], 200);
    }

    public function allGames(Request $request)
    {
        if ($request->isJson()) { 
            return Game::all();
        } else {
            return response()->json(['error' => 'No acceptable'], status: 406);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, Game $game, $id)
    {
        $game = Game::findOrFail($id);
        $game->update($request->all());
        return $game;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::findOrFail($id);

        $game->delete();
    }
}
