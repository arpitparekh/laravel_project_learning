<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;   // import for hashing a password
use Validator;

class UserController extends Controller
{
    public function register(Request $request){   // register user function
        
        $validator = Validator::make($request->all(), [    // this is for validation
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
        'tc' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first(), 'status' => 'failed'], 200);
        }

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

        User::create([                                  // use this insted of upper code
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),       // hash password
            'tc' => json_decode($request->input('tc')),
        ]);

        return response([
            'message' => 'User Registered Succesfully',
            'status' => 'success'
        ], 201);
    }
}
