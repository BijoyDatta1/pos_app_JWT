<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
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

//customer
Route::get('/customerpage', [CustomerController::class, 'customerPage'])->middleware(TokenVerificationMiddleware::class);
Route::get('/getallcustomer', [CustomerController::class, 'getall'])->middleware(TokenVerificationMiddleware::class);
Route::post('/customercreate', [CustomerController::class, 'customerCreate'])->middleware(TokenVerificationMiddleware::class);
Route::post('/customerupdate', [CustomerController::class, 'customerUpdate'])->middleware(TokenVerificationMiddleware::class);
Route::post('/customerdelete', [CustomerController::class, 'CustomerDelete'])->middleware(TokenVerificationMiddleware::class);
Route::post('/getcustomeritem', [CustomerController::class, 'getItem'])->middleware(TokenVerificationMiddleware::class);

//product
Route::get('/productpage', [ProductController::class, 'productPage'])->middleware(TokenVerificationMiddleware::class);
Route::get('/getallproduct', [ProductController::class, 'getall'])->middleware(TokenVerificationMiddleware::class);
Route::post('/createproduct', [ProductController::class, 'createProduct'])->middleware(TokenVerificationMiddleware::class);
Route::post('/updateproduct', [ProductController::class, 'updateProduct'])->middleware(TokenVerificationMiddleware::class);
Route::post('/deleteproduct', [ProductController::class, 'deleteProduct'])->middleware(TokenVerificationMiddleware::class);
Route::post('/getproductitem', [ProductController::class, 'getItem'])->middleware(TokenVerificationMiddleware::class);
