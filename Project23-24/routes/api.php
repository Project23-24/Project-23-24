<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\MedController;
use Illuminate\Support\Facades\Auth;


Route::middleware(['auth:sanctum', 'check.role:user'])->get('checktoken', function(){
    return Auth::user();
});

Route::controller(AuthenticationController::class)->group(function() {
    Route::post('register', 'register')->middleware('guest');
    Route::post('login', 'login')->middleware('guest');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});


Route::controller(MedController::class)->middleware('auth:sanctum')->group(function(){
    Route::middleware('check.role:admin,user')->group(function(){
        Route::get('all','all');
        Route::get('categories/{category:id}','categoryload');
        Route::get('/show/{med:Commercial_Name}','medshow');
    });

    Route::middleware('check.role:admin')->group(function(){
        Route::get('/make', 'createMed');
        Route::post('/make', 'createMed');
        Route::post('/edit/{med:cname}','add');
        Route::delete('/delete/{id}', 'delete');
    
    });
    
    Route::middleware('check.role:user')->group(function(){
        Route::post('/order','buy');
    });
});

