<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/about', function () {
//     return view('pages.about');
// });

// Route::get('/user/{id}/{name}', function ($id,$name){
//     // return view('user');
//     return "this is user " .$name ." with id ".$id;
// });

// Route::get('/', 'App\Http\Controllers\PagesController@index');
Route::get('/', [PagesController::class, 'index']);
Route::get('/about', [PagesController::class,'about']);
Route::get('/services', [PagesController::class, 'services']);

Route::resource('posts', PostsController::class);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
