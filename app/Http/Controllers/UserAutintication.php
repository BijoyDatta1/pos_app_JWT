<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
}
