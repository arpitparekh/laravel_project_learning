<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Throwable;

class PostController extends Controller
{
    public function getAllPost(){
        return response()->json(['posts'=>Post::get()]);
    }

    public function addPost(Request $request){
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

    public function getSpecificPost($post_id){
        $post = Post::find($post_id);
        if (!$post) {
        return response()->json([
            'message'=>'Post Not Found',
            'status'=>'failure',
        ]);
    }
    return response()->json(['post' => $post]);
    }

    public function updatePost(Request $request){

        $post_id = $request->id;
        $post = Post::find($post_id);

        if (!$post) {
        return response()->json([
            'message' => 'No Post Found for Update',
            'status' => 'failure',
            ]);
        }

        $post->title = $request->input('title');
        $post->description = $request->input('description');

        $post->save();

        return response()->json([
            'message'=>'Post Updated',
            'status'=>'success',
            'data'=> $post
        ]);
    }

    public function deletePost(Request $request){

        $post_id = $request->id;
        $post = Post::find($post_id);
        
        if (!$post) {
        return response()->json([
            'message' => 'No Post Found for Delete',
            'status' => 'failure',
            ]);
        }
        $post->delete();

        return response()->json([
            'message'=>'Post Deleted',
            'status'=>'success',
        ]);

    }

    
}
