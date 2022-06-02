<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


/**
 * Clase Validacion en la pagina web.
 * [Description AuthController] Proporciona las comprobaciones y validaciones pertinentes que se realizan a la hora de registrarse, realizar login o cerrar sesion.
 */

class AuthController extends Controller
{
    /**
     * Funcion para validar el registro de un usuario en la pagina web.
     * 
     * Esta funcion valida cuando un usuario introduce los datos en el formulario si son correctos.
     * 
     * @param Request $request solicitud.
     * @return response devuelve el acceso o no dependiendo de si el registro se realizo correctamente (200 ok en caso de correcto).
     */
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

    /**
     * Funcion para validar login usuario en la pagina.
     * 
     * Esta funcion nos valida al usuario que intenta entrar con una cuenta a la pagina web.
     * 
     * @param Request $request solicitud.
     * @return response devuelve si el login fue validado correctamente, en el caso de que si redirige a Home.
     */

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

    /**
     * Fucion para validar el cierre de la sesion del usuario.
     * 
     * Esta funcion reliza el cierre el usuario con su token para evitar robos de cuenta y suplantaciones de identidad.
     * @return response devuelve una solicitud conforme has cerrado sesion.
     */

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Haz cerrado sesión correctamente y el token ha sido removido exitosamente.'
        ]);
    }
}
