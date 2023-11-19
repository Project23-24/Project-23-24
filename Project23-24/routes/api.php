<?php

use App\Http\Controllers\MedController;
use App\Models\Medicine;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(MedController::class)->group(function () {
    Route::get('/make', 'createMed');
    Route::get('showall','all');
    Route::get('categories/{category::name}','categoryload');
    Route::post('/make', 'createMed');
    Route::get('/show/{med:Commercial_Name}','medshow');
    Route::post('/edit/{med:Commercial_Name}','buy');
    Route::post('/edit/{med:Commercial_Name}','add');
}); 