<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home',[App\Http\Controllers\BooksController::class,'booksList']);
Route::get('/book-view/{slug}',[App\Http\Controllers\BooksController::class,'bookView']);

Route::post('/add-comment',[App\Http\Controllers\BooksController::class,'addComment']);
Route::post('/save-comment',[App\Http\Controllers\BooksController::class,'changeComment']);

Route::post('/search-book',[App\Http\Controllers\BooksController::class,'searchBook']);
Route::post('/search-comment',[App\Http\Controllers\BooksController::class,'searchComment']);
