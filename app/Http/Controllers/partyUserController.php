<?php

namespace App\Http\Controllers;

use App\Models\PartyUser;
use Illuminate\Http\Request;

class partyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = auth()->user();

        if ($user->id == 5) {

            $partyuser = PartyUser::all();

            return response()->json([
                'success' => true,
                'data' => $partyuser,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso de administrador para realizar esta acción.',
            ], 400);
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

        $this->validate($request, [
            'party_id' => 'required',
        ]);

        $checkUserInParty = PartyUser::where('party_id', '=', $request->party_id)->where('user_id', '=', $user->id)->get();

        if ($checkUserInParty->isEmpty()) {
            $partyuser = PartyUser::create([
                'user_id' => $user->id,
                'party_id' => $request->party_id,
            ]);


            if ($partyuser) {

                return response()->json([
                    'success' => true,
                    'data' => $partyuser->toArray()
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo agregar el usuario a la party',
                ], 500);
            }
        } else {
            return response()->json([
                'success' => true,
                'message' => "Ya estas en esa party."
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartyUser  $PartyUser
     * @return \Illuminate\Http\Response
     */
    public function showByUser()
    {
        $user = auth()->user();

        $partyuser = PartyUser::where('user_id', '=', $user->id)->get();

        if ($user->id) {

            return response()->json([
                'success' => true,
                'data' => $partyuser,
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso.',
            ], 400);
        }
    }

    public function showByParty(Request $request)
    {
        $user = auth()->user();

        $partyuser = PartyUser::where('party_id', '=',  $request->party_id)->get();


        if ($user->id) {

            return response()->json([
                'success' => true,
                'data' => $partyuser,
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso de administrador para realizar esta acción.',
            ], 400);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartyUser  $PartyUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartyUser $PartyUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartyUser  $PartyUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($party_id)
    {
        
        $user = auth()->user();
        
        // chequea si ya esta en la party
        $checkUserInParty = PartyUser::where('party_id', '=', $party_id)->where('user_id', '=', $user->id)->get();


        if($checkUserInParty->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => "No estás en esa party"
            ], 400); 
        }else {
            try{
                $resultado = PartyUser::selectRaw('id')
                ->where('party_id', '=', $party_id)
                ->where('user_id', '=', $user->id)->delete();

                return response()->json([
                    'success' => true,
                    'messate' => "Has salido de la party"
                ], 200); 

            }catch(QueryException $err){
                return response()->json([
                    'success' => false,
                    'data' => $err
                ], 400); 
            }
        }
    
    }
}
