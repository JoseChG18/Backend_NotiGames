<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use App\Models\StatisticsGamesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Clase controladora de las estadisticas.
 * [Description StatisticController] en esta clase se procesa el CRUD de las estadisticas.
 */

class StatisticController extends Controller
{

    /**
     * Guardar datos en JSON.
     * @return response json con las estadisticas cargadas.
     */

    public function index()
    {
        $statistics = Statistic::all();

        return response()->json($statistics);
    }

    /**
     * Funcion para validar la creacion correcta las estadisticas.
     * 
     * Valida que la creacion de unas estadisticas sea correcta.
     * 
     * @param Request $request solicitud pagina.
     * @return response Devuelve si la estadistica fue creado correctamente en este caso (200 ok) en caso de error (dato error).
     */

    public function store(Request $request)
    {
        $statistic = Statistic::create([
            'name' => $request->name,
            'value' => $request->value
        ]);
        // Falta agregar fechas o si no las pondra a null, talvez necesite controller;
        DB::insert('insert into statistics_games_users (user_id, game_id, statistic_id,created_at,updated_at) values (?, ?,?,?,?)', [$request->idUser, $request->idGame, $statistic->id, date('Y-m-d H:i:s'),date('Y-m-d H:i:s')]);

        return response()->json(["Estadistica creada correctamente" , $statistic]);
    }

    /**
     * 
     * Funcion para mostrar las estadisticas.
     * 
     * Esta funcion muestra las estadisticas que existen.
     * 
     * @param mixed $id estadisticas que hay.
     * @return response las estadisticas que existen en la pagina.
     */

    public function show($id)
    {
        $statistic = Statistic::find($id);

        $statistic->user;
        $statistic->game;

        return response()->json($statistic);
    }

    /**
     * Funcion para actualizar Estadisticas.
     * 
     * Esta funcion actualiza las estadisticas.
     * 
     * @param Request $request solicitud
     * @param Post $post identificador de la estadistica.
     * @return response Devuelve en caso de todo correcto la estadistica actualizado (200 ok) de lo contrario error.
     */

    public function update(Request $request, Statistic $statistic)
    {
        $statistic->name = $request->name;
        $statistic->value = $request->value;
        $statistic->save();

        return response()->json(["Estadistica actualizada correctamente.", $statistic]);
    }

    /**
     * Funcion para borrar estadisticas.
     * 
     * Esta funcion elimina estadisticas.
     * 
     * @param Post $post identificador del POST.
     * @return response Eliminacion de la estadistica correctamente (200 ok).
     */

    public function destroy(Statistic $statistic)
    {
        $statistic->delete();

        return response()->json("Estadistica eliminada correctamente.");
    }
}
