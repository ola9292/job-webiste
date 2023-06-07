<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use \App\Models\Listing;
use \App\Models\User;

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


Route::get('/listing/create', [App\Http\Controllers\ListingController::class, 'create'])->middleware('auth');

Route::get('/', [App\Http\Controllers\ListingController::class, 'index']);

Route::post('/listing', [App\Http\Controllers\ListingController::class, 'store'])->middleware('auth');

Route::get('/listing/{id}/edit', [App\Http\Controllers\ListingController::class, 'edit'])->middleware('auth');

Route::put('/listing/{id}/update', [App\Http\Controllers\ListingController::class, 'update'])->middleware('auth');

Route::get('/listing/manage', [App\Http\Controllers\ListingController::class, 'manage']);

Route::get('/listing/{id}', [App\Http\Controllers\ListingController::class, 'show']);

Route::delete('/listing/{id}', [App\Http\Controllers\ListingController::class, 'destroy'])->middleware('auth');

//authenticate and users route
Route::get('/register', [App\Http\Controllers\UserController::class, 'create'])->middleware('guest');

//create a new user
Route::post('/users', [App\Http\Controllers\UserController::class, 'store']);

Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout'])->middleware('auth');

Route::get('/login', [App\Http\Controllers\UserController::class, 'login'])->name('login')->middleware('guest');

Route::post('/users/authenticate', [App\Http\Controllers\UserController::class, 'authenticate']);




Route::get('/search', function (Request $request) {
    // dd($request->name);
});

Route::get('/demo', [App\Http\Controllers\ListingController::class, 'demmoo']);