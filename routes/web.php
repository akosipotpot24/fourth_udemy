<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;


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

Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');

Route::post('/register', [UserController:: class, 'register']);
Route::post('/login', [UserController:: class, 'login']);
Route::post('/logout', [UserController:: class, 'logout']);

// blog post routes
Route::get('/post/{post}', [PostController:: class, 'viewSinglePost' ] );
Route::get('/create-post', [PostController:: class, 'showCreateForm' ] )->middleware('port');
Route::post('/create-post', [PostController:: class, 'storeNewPost' ] );

//profile related  route
Route::get('/profile/{pizza:username}',[UserController::class, 'profile']);