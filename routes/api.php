<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


Route::get("/hello",function(){   // this is my first get request
    return "Hello World";
});

Route::post('/reverse-me',function(Request $request){  // this is my first post request
    $reverse = strrev($request->input('reverse_this'));
    return $reverse;
});

Route::get('posts',[PostController::class,'getAllPost']);          // show all posts
Route::post('add-post',[PostController::class,'addPost']);   // create post
Route::get('posts/{post}', [PostController::class, 'getSpecificPost']);   // show spesific post
Route::post('update-post', [PostController::class, 'updatePost']);   // Update post
Route::post('delete-post', [PostController::class, 'deletePost']);   // Delete post

// Route::apiResource('posts',PostController::class);   // if we used {post} for id 