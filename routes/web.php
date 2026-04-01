<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDetailController;

Route::get('/', [UserDetailController::class, 'index'])->name('users.index');
Route::get('/create', [UserDetailController::class, 'create'])->name('users.create');
Route::post('/store', [UserDetailController::class, 'store'])->name('users.store');
Route::get('/edit/{id}', [UserDetailController::class, 'edit'])->name('users.edit');
Route::post('/update/{id}', [UserDetailController::class, 'update'])->name('users.update');
Route::get('/delete/{id}', [UserDetailController::class, 'delete'])->name('users.delete');