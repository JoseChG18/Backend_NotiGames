<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Validator;
use Illuminate\Http\Request;

/**
 * Clase controladora de los comentarios.
 * 
 * [Description CommentController] Esta clase controla la gestion de los comentarios que tiene cada publicacion (POST) de la pagina.
 */

class CommentController extends Controller
{
    /**
     * Guardar datos en JSON.
     * @return response json con los comentarios cargados.
     */

    public function index(){

        $comment = Comment::all();
        return response()->json($comment);
    }

    /**
     * Funcion para validar la creacion correcta el comentario.
     * 
     * Valida que la creacion de un comentario sea correcta.
     * 
     * @param Request $request solicitud pagina.
     * @return response Devuelve si el comentario fue creado correctamente en este caso (200 ok) en caso de error (dato error).
     */

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'comment' => 'required | string | max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "errores" => $validator->errors(),
            ]);
        }
        
        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => $request->user_id,
            'post_id' => $request->post_id
        ]);

        return response()->json([
            "status"=> 200,
            "message" => "Comentario creado correctamente" ,
            "data" => $comment
        ]);
    }

    /**
     * 
     * Funcion para mostrar los comentarios.
     * 
     * Esta funcion muestra los comentarios de una publicacion (POST).
     * 
     * @param mixed $id comentarios de esa publicacion (POST).
     * @return response el comentario de esta publicacion (POST).
     */

    public function show($id){
        $comment = Comment::find($id);

        $comment->user;
        $comment->post;
        return response()->json($comment);
    }

    /**
     * Funcion para actualizar comentarios.
     * 
     * Esta funcion se encarga de validar el poder actualizar un comentario en la pagina web.
     * 
     * @param Request $request solicitud.
     * @param Comment $comment identificador del comentario.
     * 
     * @return response En caso de que todo sea correcto actualiza el comentario de lo contrario error.
     */

    public function update(Request $request, Comment $comment){
        $validator = Validator::make($request->all(), [
            'comment' => 'required | string | max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(["Comentario Actualizado correctamente.", $comment]);
    }

    /**
     * Funcion para borrar un comentario.
     * 
     * Esta funcion borra comentarios de la pagina web.
     * 
     * @param Comment $comment identificador del comentario.
     * @return response en caso de correcto borra el mensaje (200 ok).
     */

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            "status" => 200,
            "message" => "Comentario eliminado Correctamente."
        ]);
    }
}
