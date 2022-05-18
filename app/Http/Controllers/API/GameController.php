<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Validator;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(){

        $games = Game::all();
        return response()->json($games);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        
        $game = Game::create([
            'name' => $request->name
        ]);

        return response()->json(["Juego creado correctamente" , $game]);
    }

    public function show($id){
        $game = Game::find($id);

        $game->users;
        $game->statistics;
        return response()->json($game);
    }

    public function update(Request $request, Game $game){
        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $game->name = $request->name;
        $game->save();

        return response()->json(["Juego Actualizado correctamente.", $game]);
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return response()->json(["Juego eliminado Correctamente."]);
    }
}
