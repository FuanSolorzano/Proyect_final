<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function login( Request $request){
        $rules = [
           
            'email' => 'required|string|email|max:100',
            'password' => 'required|string'
        ];
        $validator = Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'status' => false,
                'errors' => ['Unauthorized'],
            ],401); 
        }
        $user = User::where('email',$request->email)->first();
        return response()->json([
            'status' => true,
            'message' => 'User logged successfully',
            'data' => $user,
            'token' => $user->createToken('Api Token')->plainTextToken
        ],200);
    }
    public function logout(){
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
    
        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully'
        ], 200);
    }

}
