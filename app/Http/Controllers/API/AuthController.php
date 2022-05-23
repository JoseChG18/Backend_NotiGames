<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required | max:255',
            'apellidos' => 'required | max:50',
            'telefono' => 'required | max:9',
            'ciudad' => 'required | max:70',
            'provincia' => 'required | max:70',
            'email' => 'required | email | max:255 | unique:users,email',
            'username' => 'required | max:50 | unique:users,username',
            'password' => 'required | min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errores' => $validator->messages(),
            ]);
        }else{
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

            $token = $user->createToken($user->email.'_Token')->plainTextToken;

            return response()
                ->json([
                    'status' => 200,
                    'message' => 'Registrado Correctamente.',
                    'data' => $user, 
                    'access_token' => $token, 
                    'token_type' => 'Bearer'
                ]);
        }
    }

    public function login(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'username' => 'required | max:50',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errores' => $validator->messages(),
            ]);
        }else{
            $user = User::where('username', $request->username)->first();
            
            if (!$user || !Hash::check($request->password,$user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => "Credenciales invalidas.",
                ]);
            }else{

                $token = $user->createToken($user->email.'_Token')->plainTextToken;
    
                return response()->json([
                    'status' => 200,
                    'message' => "Logeado correctamente.",
                    'data' => $user, 
                    'access_token' => $token, 
                    'token_type' => 'Bearer'
                ]);
            }
            
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Haz cerrado sesión correctamente y el token ha sido removido exitosamente.'
        ]);
    }
}
