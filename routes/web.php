<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;

Route::get('/',[PagesController::class,'index']);
Route::get('/blog',[PostsController::class,'index']);
Route::get('/blog/create',[PostsController::class,'create']);
Route::post('/blog',[PostsController::class,'store']);
Route::get('/blog/{slug}',[PostsController::class,'show']);
Route::get('/blog/{slug}/edit',[PostsController::class,'edit']);
Route::post('/blog/{slug}/edit',[PostsController::class,'update']);
Route::get('/blog/{slug}/delete',[PostsController::class,'destroy']);
Auth::routes();
Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

