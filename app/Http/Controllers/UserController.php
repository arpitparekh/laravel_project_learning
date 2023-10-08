<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;   // import for hashing a password

class UserController extends Controller
{
    public function register(Request $request){   // register user function
        
        $request->validate([              // this is for validation
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'tc' => 'required',
        ]);

        if(User::where('email',$request->input('email'))->first()){
            return response([
                'message' => 'Email already registered',
                'status' => 'failed'
            ],200);
        }

        // $user = new User();
        // $user->name = $request->input('name');
        // $user->email = $request->input('email');
        // $user->password = Hash::make($request->input('password'));
        // $user->tc = $request->input('tc');

        // $user->save();

        $user = User::create([                                  // use this insted of upper code
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),       // hash password
            'tc' => json_decode($request->input('tc')),
        ]);

        return response()->json([
            'message' => 'User Registered Succesfully',
            'status' => 'success'
        ], 201);
    }
}
