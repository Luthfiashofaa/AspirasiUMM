<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Auth\Middleware\Authenticate; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route; 

Route::get('/profile', function (Request $request) { 
return $request->user(); 
})->middleware(Authenticate::using('sanctum')); 

//posts 
Route::apiResource('/get-user', App\Http\Controllers\Api\UserController::class); 
Route::apiResource('/comment', App\Http\Controllers\Api\CommentController::class);
Route::apiResource('/complaint', App\Http\Controllers\Api\ComplaintController::class);
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {

    Route::post('/login', [AuthController::class, 'login']);

});