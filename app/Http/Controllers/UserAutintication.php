<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;

class UserAutintication extends Controller
{
    //
    public function registation(Request $request){
        $userValidation = Validator::make($request->all(),[
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'mobile' => 'required',
        ]);

        if($userValidation->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $userValidation->errors()
            ], 401);
        }

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => $request->password,
            'mobile' => $request->mobile
        ]);
        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'user' => $user
        ], 201);

    }

    public function login(Request $request){
        $userValidation = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($userValidation->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $userValidation->errors()
            ],401);
        }

        $user = User::where('email', $request->email)->where('password', $request->password)->first();

        if($user){
            $token = JWTToken::createToken($user->email);
            return response()->json([
                'status' => true,
                'message' => 'login successfully',
                'token' => $token
            ],201);
        }else{
            return response()->json([
                'status' => false,
                'message' => "Email and Password Not match"
            ]);
        }
    }
}
