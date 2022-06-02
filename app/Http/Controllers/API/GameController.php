<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Validator;
use Illuminate\Http\Request;

/**
 * Clase controladora de los juegos.
 * [Description GameController] en esta clase se procesa el CRUD de los juegos.
 */

class GameController extends Controller
{

    /**
     * Guardar datos en JSON.
     * @return response json con los juegos cargados.
     */

    public function index(){

        $games = Game::all();
        return response()->json($games);
    }

    /**
     * Funcion para validar la creacion correcta el juego.
     * 
     * Valida que la creacion de un juego sea correcta.
     * 
     * @param Request $request solicitud pagina.
     * @return response Devuelve si el juego fue creado correctamente en este caso (200 ok) en caso de error (dato error).
     */

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

    /**
     * 
     * Funcion para mostrar los juegos.
     * 
     * Esta funcion muestra los juegos que existen.
     * 
     * @param mixed $id juegos que hay.
     * @return response los juegos que existen en la pagina para cada usuario.
     */

    public function show($id){
        $game = Game::find($id);

        $game->users;
        $game->statistics;
        return response()->json($game);
    }

    /**
     * Funcion para actualizar juegos.
     * 
     * Esta funcion comprueba si el juego se puede actualizar.
     * 
     * @param Request $request solicitud.
     * @param Game $game identificador del juego.
     * @return response Si el juego se valida correctamente (200 ok) se puede actualizar, si no error.
     */

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

    /**
     * Funcion para borrar juegos.
     * 
     * Esta funcion elimina juegos.
     * 
     * @param Game $game identificador del juego.
     * @return response Eliminacion del juego.
     */

    public function destroy(Game $game)
    {
        $game->delete();

        return response()->json(["Juego eliminado Correctamente."]);
    }
}
