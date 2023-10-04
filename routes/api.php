<?php

use App\Http\Controllers\Api\AccessTockensController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\DeviceTokenContoller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('categories',CategoriesController::class )->middleware('auth:sanctum');

Route::post('auth/tokens',[AccessTockensController::class,'store']);

Route::delete('auth/tokens',[AccessTockensController::class,'destroy'])->middleware('auth:sanctum');

Route::post('device/tokens',[DeviceTokenContoller::class ,'store'])
->middleware('auth:sanctum');
;
