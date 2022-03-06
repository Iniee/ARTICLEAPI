<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::resource('/article', ArticleController::class);

//Public Routes
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/article', [ArticleController::class,'index']);
Route::get('/article/{id}', [ArticleController::class,'show']);
Route::get('/article/search/{name}', [ArticleController::class, 'search']);


//protected routes  
Route::group(['middleware' => ['auth:sanctum']],function () {
    Route::post('/article', [ArticleController::class, 'store']);
    Route::put('/article/{id}', [ArticleController::class, 'update']);
    Route::delete('/article/{id}', [ArticleController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);

}); 

Route::get('/user', function (Request $request ){
 return $request->user();
})->middleware('auth:api');
