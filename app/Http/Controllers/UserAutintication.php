<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\SendOtpMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function sendOtp(Request $request){
        // return "hello";
        // die();
        $userValidation = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);
        if($userValidation->fails()){
            return response()->json([
                'status' => false,
                'message' => 'please provide valide email',
            ]);

        }

        $otp = rand(10000,99999);
        $user = User::where('email', $request->email)->first();

        if($user){
            //update otp
            User::where('email','=', $request->email)->update(['otp' => $otp]);

            //send otp
            Mail::to($user->email)->send(new SendOtpMail($otp));
            return response()->json([
                'status' => true,
                'message' => 'otp send successfully'
            ],201);
        }else{
            return response()->json([
                'status' => false,
                'message' => "Email Not found for Otp"
            ],401);
        }
    }

    public function verifyOtp(Request $request){
        
        $user = User::where('email','=',$request->email)->where('otp','=',$request->otp)->first();

        if($user){
            //update otp
            $user->update(['otp' => 0]);
            //createToken
            $token = JWTToken::createToken($user->email,10);
            return response()->json([
                'status' => true,
                'message' => 'otp verified successfully',
                'token' => $token
            ],201);

        }else{
            return response()->json([
                'status' => false,
                'message' => "Invalid otp"
            ],401);
        }

    }

    public function resetPassword(Request $request){
        try{
            $email = $request->header('email');
            User::where('email', '=' , $email)->update(['password', '=', $request->password]);
            return response()->json([
                'status' => true,
                'message' => 'password reset successfully'
            ],201);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'exception message' => $e->getMessage(),
                'message' => 'password reset failed'
            ],401);
        }
    }
}
