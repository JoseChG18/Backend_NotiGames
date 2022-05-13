<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);

        $user->statistics;
        $user->games->unique();
        
        if (is_null($user)) {
            return response()->json('Datos no encontrados', 404); 
        }
        return response()->json([new UserResource($user)]);
    }
}
