<?php

use App\Http\Controllers\UserAutintication;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/loginpage',[UserAutintication::class,'loginPage']);
Route::get('/registationpage',[UserAutintication::class,'registationPage']);
Route::get('/sendotppage',[UserAutintication::class,'sendotpPage']);
Route::get('/verifyotppage',[UserAutintication::class,'verifyotpPage']);
Route::get('/resetpasswordpage',[UserAutintication::class,'resetpasswordPage']);
Route::get('/dashboard',[UserAutintication::class,'dashboard'])->middleware(TokenVerificationMiddleware::class);