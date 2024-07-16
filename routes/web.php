<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest:mahasiswa'])->group(function (){

    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login',[AuthController::class,'login']);
});

Route::middleware(['auth:mahasiswa'])->group(function(){
    Route::get('/dashboard',[dashboardController::class,'index']);
    Route::get('/logout',[AuthController::class,'logout']);

    Route::get('/presensi/create',[PresensiController::class,'create']);
    Route::post('/presensi/store',[PresensiController::class,'store']);

    Route::get('/editprofile',[PresensiController::class,'editProfile']);
    Route::post('/presensi/{nim}/updateprofile',[PresensiController::class,'updateprofile']);

    Route::get('/presensi/history',[PresensiController::class,'history']);
    Route::post('/gethistory',[PresensiController::class,'gethistory']);

    Route::get('/presensi/izin',[PresensiController::class,'izin']);
    Route::get('/presensi/makeizin',[PresensiController::class,'makeizin']);
    Route::post('/presensi/storeizin',[PresensiController::class,'storeizin']);
});

Route::middleware(['guest:user'])->group(function (){

    Route::get('/admin', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/loginadmin',[AuthController::class,'loginadmin']);
 
});


Route::middleware(['auth:user'])->group(function(){
    Route::get('/admin/admindashboard',[dashboardController::class,'admindashboard']);
    Route::get('/adminlogout',[AuthController::class,'adminlogout']);

    Route::get('/mahasiswa',[MahasiswaController::class,'index'])->name('mahasiswa.index');
    Route::post('/mahasiswa/store',[MahasiswaController::class,'store'])->name('mahasiswa.index');
    Route::post('/mahasiswa/edit',[MahasiswaController::class,'edit']);
    Route::post('/mahasiswa/{nim}/update',[MahasiswaController::class,'update']);
    Route::delete('/mahasiswa/{nim}/delete', [MahasiswaController::class, 'destroy']);

    Route::get('/presensi/konfirizin',[PresensiController::class,'izinkonfir']);
    Route::post('/presensi/approveizin',[PresensiController::class,'approveizin']);
    Route::get('/presensi/{id}/batalapprove',[PresensiController::class,'batalizin']);
    Route::get('/presensi/monitoring',[PresensiController::class,'monitoring']);
    Route::post('/getpresensi',[PresensiController::class,'getpresensi']);

});



