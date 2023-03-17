<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;



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
// auth Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Post Routes

Route::get('/getPosts', [PostController::class, 'getAllPosts']);
Route::get('/getPosts/{id}', [PostController::class, 'GetPostById']);
Route::post('/NewPost', [PostController::class, 'NewPost'])->middleware('auth.token');
Route::put('/UpdatePost/{id}', [PostController::class, 'updatePost'])->middleware('auth.token');
Route::delete('/deletePost/{id}', [PostController::class, 'deletePost'])->middleware('auth.token');


// Comments Routes

Route::get('/getComments', [CommentController::class, 'getAllComments']);
Route::get('/getComment/{id}', [CommentController::class, 'GetCommentById']);
Route::post('/NewComment', [CommentController::class, 'NewComment'])->middleware('auth.token');
Route::put('/UpdateComment/{id}', [CommentController::class, 'updateComment'])->middleware('auth.token');
Route::delete('/deleteComment/{id}', [CommentController::class, 'deleteComment'])->middleware('auth.token');