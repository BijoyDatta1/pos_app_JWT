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


    public function dashboard(){
        return view('pages.dashboard.dashboard-page');
    }

    public function loginPage(){
        return view('pages.auth.login-page');
    }
    public function registationPage(){
        return view('pages.auth.registration-page');
    }
    public function sendotpPage(){
        return view('pages.auth.send-otp-page');
    }
    public function verifyotpPage(){
        return view('pages.auth.verify-otp-page');
    }
    public function resetpasswordPage(){
        return view('pages.auth.reset-pass-page');
    }

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
                'status' => 'failed',
                'message' => $userValidation->errors(),
            ]);
        }

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => $request->password,
            'mobile' => $request->mobile
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user
        ], 200);

    }

    public function login(Request $request){
        $userValidation = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        if($userValidation->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $userValidation->errors()
            ]);
        }

        $user = User::where('email', $request->email)->where('password', $request->password)->first();

        if($user){
            $token = JWTToken::createToken($user->email);
            return response()->json([
                'status' => 'success',
                'message' => 'login successfully',
            ],200)->cookie('token',$token,60);
        }else{
            return response()->json([
                'status' => 'failed',
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
                'status' => 'faield',
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
                'status' => 'success',
                'message' => 'otp send successfully'
            ],200);
        }else{
            return response()->json([
                'status' => 'faield',
                'message' => "Email Not found for Otp"
            ]);
        }
    }

    public function verifyOtp(Request $request){

        $email = session('email');
        
        $user = User::where('email','=',$email)->where('otp','=',$request->otp)->first();

        if($user){
            //update otp
            $user->update(['otp' => 0]);
            //createToken
            $token = JWTToken::createToken($user->email,10);
            return response()->json([
                'status' => 'success',
                'message' => 'otp verified successfully',
            ],200)->cookie('token',$token,10);

        }else{
            return response()->json([
                'status' => 'failed',
                'message' => "Invalid otp"
            ]);
        }

    }

    public function resetPassword(Request $request){
        try{
            $email = $request->header('email');
            User::where('email', '=' , $email)->update(['password'=> $request->password]);
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

