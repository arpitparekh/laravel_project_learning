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

        $user = User::create([                                  // use this insted of upper code
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),       // hash password
            'tc' => json_decode($request->input('tc')),                  // with json decode u can write true or false
        ]);

        // do not need token for registration
        // $token = $user->createToken($request->email)->plainTextToken;    // generate token on the basis of email address

        return response([
            'message' => 'User Registered Succesfully',
            'status' => 'success',
            // 'token'=>$token
        ], 201);
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first(), 'status' => 'failed'], 200);
        }

        $user = User::where('email', $request->input('email'))->first();
        
        if($user && Hash::check($request->input('password'),$user->password)){

            $token = $user->createToken($request->email)->plainTextToken;

            return response([
                'message' => 'User Login Succesfully',
                'sttus' => 'success',
                    'token'=>$token
            ], 201);
        }

        return response([
            'message' => 'The provided creadentials are wrong',
            'status' => 'failed'
        ], 200);

    }

    public function logout(){
        $user = auth()->user();

        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return response([
            'message' => 'User Logout Successfully',
            'status' => 'success'
        ], 201);


    }


}
