<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        return response()->json(['posts'=>Post::get()]);
    }

    public function store(Request $request){
        $post = new Post;
        $post->title = $request->title;
        $post->description = $request->description;

        $post->save();

        return response()->json([
            'message'=>'Post Created',
            'status'=>'success',
            'data'=> $post
        ]);
    }
}
