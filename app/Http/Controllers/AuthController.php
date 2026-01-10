<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login (Request $request){
        if (!Auth::attempt($request->only("email","password"))){
            return response()->json([
                'message'=>'worng email or password'
            ],401);
        }
        $user = User::where ('email',$request->email)->first();
        $token= $user->createToken('token')->plaintextToken;
        return response()->json([
            'message'=>"login successful",
            'your token is'=>$token,
        ],201);
    }



    public function register(Request $request){
        $request->validate([
            'name'=>['required'],
            'email'=>['required'],
            'password'=>['required','min:8'],
            
        ]);
        $user = user::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        return response()->json([
            'message'=>'you are register successful',
            'user'=>$user,
        ],201);
    }
}
