<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Validator;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){

        $posts = Post::all();
        return response()->json($posts);
    }

    public function store(Request $request){
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

        return response()->json(["Post creado correctamente" , $post]);
    }

    public function show($id){
        $post = Post::find($id);

        $post->user;
        $post->game;
        $post->comments;

        return response()->json($post);
    }

    public function update(Request $request, Post $post){
        $validator = Validator::make($request->all(), [
            'tittle' => 'required | string | max:255',
            'description' => 'required | string | max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $post->tittle = $request->tittle;
        $post->description = $request->description;
        $post->save();

        return response()->json(["Post Actualizado correctamente.", $post]);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(["Post eliminado Correctamente."]);
    }
}