<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use App\Models\StatisticsGamesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{

    public function index()
    {
        $statistics = Statistic::all();

        return response()->json($statistics);
    }

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

    public function show($id)
    {
        $statistic = Statistic::find($id);

        $statistic->user;
        $statistic->game;

        return response()->json($statistic);
    }

    public function update(Request $request, Statistic $statistic)
    {
        $statistic->name = $request->name;
        $statistic->value = $request->value;
        $statistic->save();

        return response()->json(["Estadistica actualizada correctamente.", $statistic]);
    }

    public function destroy(Statistic $statistic)
    {
        $statistic->delete();

        return response()->json("Estadistica eliminada correctamente.");
    }
}
