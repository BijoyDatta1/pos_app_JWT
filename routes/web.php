<?php

use App\Http\Controllers\CategoryController;
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

Route::post('/registation', [UserAutintication::class, 'registation']);
Route::post('/login', [UserAutintication::class, 'login']);
Route::post('/sendotp', [UserAutintication::class, 'sendOtp']);
Route::post('/verifyotp', [UserAutintication::class, 'verifyOtp']);
Route::post('/resetpassword', [UserAutintication::class, 'resetPassword'])->middleware(TokenVerificationMiddleware::class);
Route::get('/logout', [UserAutintication::class, 'logout'])->middleware(TokenVerificationMiddleware::class);
Route::get('/profilePage', [UserAutintication::class, 'profilePage'])->middleware(TokenVerificationMiddleware::class);
Route::get('/getProfileValue', [UserAutintication::class, 'getProfileValue'])->middleware(TokenVerificationMiddleware::class);
Route::post('/updateProfile', [UserAutintication::class, 'updateProfile'])->middleware(TokenVerificationMiddleware::class);

Route::get('/loginpage', [UserAutintication::class, 'loginPage']);
Route::get('/registationpage', [UserAutintication::class, 'registationPage']);
Route::get('/sendotppage', [UserAutintication::class, 'sendotpPage']);
Route::get('/verifyotppage', [UserAutintication::class, 'verifyotpPage']);
Route::get('/resetpasswordpage', [UserAutintication::class, 'resetpasswordPage'])->middleware(TokenVerificationMiddleware::class);;
Route::get('/dashboard', [UserAutintication::class, 'dashboard'])->middleware(TokenVerificationMiddleware::class);

//category
Route::get('/categorypage', [CategoryController::class, 'categoryPage'])->middleware(TokenVerificationMiddleware::class);
Route::get('/getallcategory', [CategoryController::class, 'getall'])->middleware(TokenVerificationMiddleware::class);
Route::post('/categorycreate', [CategoryController::class, 'categoryCreate'])->middleware(TokenVerificationMiddleware::class);
Route::post('/categoryupdate', [CategoryController::class, 'categoryUpdate'])->middleware(TokenVerificationMiddleware::class);
Route::post('/categorydelete', [CategoryController::class, 'CategoryDelete'])->middleware(TokenVerificationMiddleware::class);
Route::post('/getcategoryitem', [CategoryController::class, 'getItem'])->middleware(TokenVerificationMiddleware::class);
