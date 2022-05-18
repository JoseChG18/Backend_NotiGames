<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Validator;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(){

        $comment = Comment::all();
        return response()->json($comment);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'comment' => 'required | string | max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        
        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => $request->user,
            'post_id' => $request->post
        ]);

        return response()->json(["Comentario creado correctamente" , $comment]);
    }

    public function show($id){
        $comment = Comment::find($id);

        $comment->user;
        $comment->post;
        return response()->json($comment);
    }

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

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(["Comentario eliminado Correctamente."]);
    }
}