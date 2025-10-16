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
Route::post('/logout', [UserController:: class, 'logout'])->middleware('port');

// blog post routes
Route::get('/post/{post}', [PostController:: class, 'viewSinglePost' ] );
Route::get('/create-post', [PostController:: class, 'showCreateForm' ] )->middleware('port');
Route::post('/create-post', [PostController:: class, 'storeNewPost' ] )->middleware('port');
Route::delete('/post/{post}', [PostController:: class, 'delete' ] )->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController:: class, 'showEditForm' ] )->middleware('can:update,post');
Route::put('/post/{post}', [PostController:: class, 'actuallyUpdate' ] )->middleware('can:update,post');
//profile related  route
Route::get('/profile/{user:username}',[UserController::class, 'profile']);