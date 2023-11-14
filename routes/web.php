<?php

use App\Http\Controllers\Department;
use App\Http\Controllers\ForceLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeaveController;

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
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

//    Route::livewire('/livewire/posts', \App\Livewire\CreatePost::class);

//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//    Route::get('test',function(){
//        return View::make('test');
//    });
    Route::get('/force-login/{user}',  [ForceLoginController::class,'login'])->name('force-login');
    Route::get('/user/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');
    Route::resource('/user', UserController::class)->middleware(['role:admin']);

<<<<<<< HEAD
    Route::resource('/user', UserController::class)->middleware(['role:admin']);
    Route::resource('/holiday', HolidayController::class);
    Route::resource('/leave-types', LeaveTypeController::class)->middleware(['role:admin']);;
    Route::resource('/leave', LeaveController::class);
=======
    Route::get('/holiday/holidays-this-month', [HolidayController::class,'holidaysThisMonthDisplay'])->name('holiday.holidaysThisMonthDisplay');
    Route::resource('/holiday', HolidayController::class);
    Route::get('/holiday/holidays-this-month', [HolidayController::class,'holidaysThisMonthDisplay'])->name('holiday.holidaysThisMonthDisplay');

    Route::resource('/department', Department::class);
>>>>>>> 74e9b20a5ce4d114c51ad262ecad6b7811302748
});

Route::get('/pass',function(){
    echo Hash::make(1);
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



