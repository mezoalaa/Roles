<?php

use App\Http\Controllers\invoice;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\invoiceController;

Route::get('/', function () {
    return redirect()->route('users.index');
});
Route::prefix('users')->name('users')->group(function(){
route::get('index',[UserController::class, 'index']);
});


Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
