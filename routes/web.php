<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('dashboard');
//});
Auth::routes();
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth' ]], function()
{
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
//    Route::get('/', function()
//    {
//        return view('dashboard');
//    });
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

//    Route::livewire('/livewire/posts', \App\Livewire\CreatePost::class);

//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//    Route::get('test',function(){
//        return View::make('test');
//    });

    Route::resource('/user', UserController::class);
});

Route::get('/pass',function(){
    echo Hash::make(1);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



