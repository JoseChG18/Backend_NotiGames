<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'apellidos' => 'required | string | max:50',
            'telefono' => 'required | numeric | max:9',
            'ciudad' => 'required | string | max:70',
            'provincia' => 'required | string | max:70',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required | string | max:50',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'ciudad' => $request->ciudad,
            'provincia' => $request->provincia,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);
    }
    public function login(Request $request)
    {   
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $user = User::where('username', $request['username'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Haz cerrado sesión correctamente y el token ha sido removido exitosamente.'
        ];
    }
}
