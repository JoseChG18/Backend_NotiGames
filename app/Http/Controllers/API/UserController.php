<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(){

        $users = User::all();
        
        return response()->json($users);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'nombre' => 'required | string | max:50',
            'apellidos' => 'required | string | max:50',
            'telefono' => 'required | numeric | max:9',
            'ciudad' => 'required | string | max:70',
            'provincia' => 'required | string | max:70',
            'email' => 'required | email | max:50',
            'username' => 'required | string | max:50',
            'password'=> 'required | string | min:8',
        ]);

        if($validator->fails()){
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
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);

        return response()->json(["Usuario creado correctamente" , $user]);
    }
    
    public function show($id)
    {
        $user = User::find($id);

        $user->statistics;
        $user->games;
        
        if (is_null($user)) {
            return response()->json('Datos no encontrados', 404); 
        }
        return response()->json(new UserResource($user));
    }

    public function update(Request $request, User $user){

        $validator = Validator::make($request->all(), [
            'nombre' => 'required | string | max:50',
            'apellidos' => 'required | string | max:50',
            'telefono' => 'required | numeric | max:9',
            'ciudad' => 'required | string | max:70',
            'provincia' => 'required | string | max:70',
            'email' => 'required | email | max:50',
            'username' => 'required | string | max:50',
            'password'=> 'required | string | min:8',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->ciudad = $request->ciudad;
        $user->provincia = $request->provincia;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(["Usuario actualizado correctamente" , $user]);
    }

    public function destroy(User $user){
        $user->delete();

        return response()->json(["Usuario eliminado Correctamente."]);
    }
}
