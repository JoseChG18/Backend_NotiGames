<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    public function index(){

        $users = User::all();
        
        return response()->json($users);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required | string | max:50',
            'surname' => 'required | string | max:50',
            'email' => 'required | email | max:50',
            'username' => 'required | string | max:50',
            'password'=> 'required | string | min:8',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
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
        return response()->json([new UserResource($user)]);
    }

    public function update(Request $request, User $user){

        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:50',
            'surname' => 'required | string | max:50',
            'email' => 'required | email | max:50',
            'username' => 'required | string | max:50',
            'password'=> 'required | string | min:8',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user->name = $request->name;
        $user->surname = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->save();

        return response()->json(["Usuario actualizado correctamente" , $user]);
    }

    public function destroy(User $user){
        $user->delete();

        return response()->json(["Usuario eliminado Correctamente."]);
    }
}
