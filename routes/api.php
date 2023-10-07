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

Route::get('posts',[PostController::class,'index']);
Route::post('create-post',[PostController::class,'store']);