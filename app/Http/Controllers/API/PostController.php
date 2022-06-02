<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Validator;
use Illuminate\Http\Request;

/**
 * Clase controladora de las publicaciones (POSTS).
 * [Description PostController] en esta clase se procesa el CRUD de las publicaciones (POSTS).
 */

class PostController extends Controller
{

    /**
     * Guardar datos en JSON.
     * @return response json con los POSTS cargados.
     */

    public function index()
    {
        $data = Post::all();
        
        return response()->json($data,200);
    }

    /**
     * Funcion para validar la creacion correcta el POST.
     * 
     * Valida que la creacion de un post sea correcta.
     * 
     * @param Request $request solicitud pagina.
     * @return response Devuelve si el post fue creado correctamente en este caso (200 ok) en caso de error (dato error).
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tittle' => 'required | string | max:255',
            'description' => 'required | string | max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $post = Post::create([
            'tittle' => $request->tittle,
            'description' => $request->description,
            'user_id' => $request->user,
            'game_id' => $request->game
        ]);

        return response()->json(["Post creado correctamente", $post]);
    }

    /**
     * 
     * Funcion para mostrar las publicaciones (POSTS).
     * 
     * Esta funcion muestra los POSTS que existen.
     * 
     * @param mixed $id POST que hay.
     * @return response los POSTS que existen en la pagina.
     */

    public function show($id)
    {
        $post = Post::find($id);

        $post->user;
        $post->game;
        $post->comments;

        return response()->json($post);
    }

    /**
     * Funcion para actualizar POSTS.
     * 
     * Esta funcion actualiza publicaciones (POSTS).
     * 
     * @param Request $request solicitud
     * @param Post $post identificador de la publicacion (POST).
     * @return response Devuelve en caso de todo correcto el post actualizado (200 ok) de lo contrario error.
     */

    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'tittle' => 'required | string | max:255',
            'description' => 'required | string | max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $post->tittle = $request->tittle;
        $post->description = $request->description;
        $post->game_id = $request->idGame;
        $post->save();

        return response()->json(["Post Actualizado correctamente.", $post]);
    }

    /**
     * Funcion para borrar publicaciones (POSTS).
     * 
     * Esta funcion elimina publicaciones (POSTS).
     * 
     * @param Post $post identificador del POST.
     * @return response Eliminacion del post correctamente (200 ok).
     */

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            "status" => 200,
            "message" => "Post eliminado Correctamente."
        ]);
    }
}
