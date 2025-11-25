<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;


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
Route::get('/admins-only', function(){
 
return 'Only admins can visit this page';
})->middleware('can:visitAdminPages');

//user related routes
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
Route::post('/register', [UserController:: class, 'register']);
Route::post('/login', [UserController:: class, 'login']);
Route::post('/logout', [UserController:: class, 'logout'])->middleware('port');
Route::get('/manage-avatar',[UserController::class,'showAvatarForm'])->middleware('port');
Route::post('/manage-avatar',[UserController::class,'storeAvatar'])->middleware('port');

//folloe related routs
Route::post('/create-follow/{user:username}',[FollowController::class,'createFollow'])->middleware('port');
Route::post('/remove-follow/{user:username}',[FollowController::class,'removeFollow'])->middleware('port');

// blog post routes
Route::get('/post/{post}', [PostController:: class, 'viewSinglePost' ] );
Route::get('/create-post', [PostController:: class, 'showCreateForm' ] )->middleware('port');
Route::post('/create-post', [PostController:: class, 'storeNewPost' ] )->middleware('port');
Route::delete('/post/{post}', [PostController:: class, 'delete' ] )->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController:: class, 'showEditForm' ] )->middleware('can:update,post');
Route::put('/post/{post}', [PostController:: class, 'actuallyUpdate' ] )->middleware('can:update,post');

//profile related  route
Route::get('/profile/{user:username}',[UserController::class, 'profile']);
Route::get('/profile/{user:username}/followers',[UserController::class, 'profileFollowers']);
Route::get('/profile/{user:username}/following',[UserController::class, 'profileFollowing']);