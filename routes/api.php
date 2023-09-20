<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;


Route::get('/user', function(){
    return view('patients.index');
});

Route::post('/store', [PatientController::class, 'store'])->name('user.store');
Route::post('/availablity', [PatientController::class, 'availablity'])->name('availblity');