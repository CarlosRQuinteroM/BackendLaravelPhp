<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;

class partyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $resultado = Party::where('games_id', '=', $request->games_id)->get();
         if (!$resultado) {
             return response() ->json([
                 'success' => false,
                 'data' => 'No se ha encontrado ningun Party'], 400);
         } else {
             return response() ->json([
                 'success' => true,
                 'data' => $resultado,
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
            $this->validate($request, [
                'nombre' => 'required|min:3',
                'games_id' => 'required',
                   
            ]);
    
            $party = Party::create([
                'nombre' => $request->nombre,
                'games_id' => $request->games_id,
                'user_id'=> auth()->user()->id
            ]);
    
            if (!$party) {
                return response() ->json([
                    'success' => false,
                    'data' => 'La party no pudo ser creada.'], 400);
            } else {
                return response() ->json([
                    'success' => true,
                    'data' => $party->toArray(),
                ], 200);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\party  $party
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $parties = Party::all();

        if(!$parties){
            return response() ->json([
                'success' => false,
                'message' => 'ninguna Party',
            ], 400);
        }

        return response() ->json([
            'success' => true,
            'data' => $parties,
        ]);
    }
    public function showById(Request $request)
    {
        $resultado = Party::where('id', '=', $request->id)->get();
        if (!$resultado) {
            return response() ->json([
                'success' => false,
                'data' => ' ningun Party.'], 400);

        } elseif ($resultado->isEmpty()) {
            return response() ->json([
                'success' => false,
                'data' => 'ningun Party con esa id: ' . $request->id], 400);
        } else {
            return response() ->json([
                'success' => true,
                'data' => $resultado,
            ], 200);
        }
       
    }

    public function showByName(Request $request)
    {
        $resultado = Party::where('nombre', '=', $request->nombre)->get();
        if (!$resultado) {
            return response() ->json([
                'success' => false,
                'data' => ' ningun Party.'], 400);
        } elseif ($resultado->isEmpty()) {
            return response() ->json([
                'success' => false,
                'data' => 'No se ha encontrado ningun Game con ese título: ' . $request->nombre], 400);
        } else {
            return response() ->json([
                'success' => true,
                'data' => $resultado,
            ], 200);
        }
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if($user->id == 5){


            $resultado = Party::where('id', '=', $id);
            if (!$resultado) {
                return response() ->json([
                    'success' => false,
                    'data' => 'ningun Party.'], 400);
            } 

            $updated = $resultado->update([
                'nombre' => $request->input('nombre'),

            ]);
            if($updated){
                return response() ->json([
                    'success' => true,
                    'message' => 'La Party se ha cambiado el nombre a:' . $request->nombre,
                ]);
            } else {
                return response() ->json([
                    'success' => false,
                    'message' => 'La Party no se puede actualizar',
                ], 500);
            }
        
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'Necesitas ser administrador para realizar esta acción.',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(party $party)
    {
        $user = auth()->user();

        if($user->id == 5){

            $resultado = Party::where('id', '=', $id);
            if (!$resultado) {
                return response() ->json([
                    'success' => false,
                    'data' => 'No se ha encontrado ningun Party.'], 400);
            } 
            if ($resultado -> delete()) {
                return response() ->json([
                    'success' => true,
                    'message' => 'Party eliminada.'], 200);
            } else {
                return response() ->json([
                    'success' => false,
                    'message' => 'No se ha podido eliminar esa Party'
                ], 500);
            }
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'Necesitas ser administrador para realizar esta acción.',
            ], 400);
        }
    
    }
}
