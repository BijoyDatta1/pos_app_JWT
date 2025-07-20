<?php

use App\Http\Controllers\UserAutintication;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/registation',[UserAutintication::class,'registation']);
Route::post('/login',[UserAutintication::class,'login']);
Route::post('/sendotp',[UserAutintication::class,'sendOtp']);
Route::post('/verifyotp',[UserAutintication::class,'verifyOtp']);
Route::post('/resetpassword',[UserAutintication::class,'resetPassword'])->middleware(TokenVerificationMiddleware::class);


