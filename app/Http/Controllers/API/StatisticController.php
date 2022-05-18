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

    public function create(Request $request)
    {
        $statistic = Statistic::create([
            'name' => $request->name,
            'value' => $request->value
        ]);

        // DB::insert('insert into statistics_games_users (user_id, game_id, statistic_id) values (?, ?,?)', $idUser,$idGame,$statistic->id);

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

        // DB::delete('delete statistics_games_users where user_id = ? AND game_id = ? AND statistic_id = ?', $idUser, $idGame, $idStat);

        return response()->json("Estadistica eliminada correctamente.");
    }
}
