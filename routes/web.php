<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Department;
use App\Http\Controllers\ForceLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SettingsController;

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



   Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
   Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//    Route::get('test',function(){
//        return View::make('test');
//    });
    Route::get('/force-login/{user}',  [ForceLoginController::class,'login'])->name('force-login');
    Route::get('/user/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');
    Route::resource('/user', UserController::class)->middleware(['role:admin']);



    Route::resource('/user', UserController::class)->middleware(['role:admin']);

    Route::get('/holiday/holidays-this-month', [HolidayController::class,'holidaysThisMonthDisplay'])->name('holiday.holidaysThisMonthDisplay');
    Route::resource('/holiday', HolidayController::class);

    Route::resource('/leave-types', LeaveTypeController::class)->middleware(['role:admin']);;


    Route::get('/leave/my', [LeaveController::class, 'index_my'])->name('leave.myApply');
    Route::get('/leave/leave-granted', [LeaveController::class, 'indexGranted'])->name('leave.leavesGranted');
    Route::get('/leave/leave-granted-my', [LeaveController::class, 'indexGranted_my'])->name('leave.leavesGrantedMy');
    Route::resource('/leave', LeaveController::class);


    Route::get('/leave/update_status/{id}/{status}', [LeaveController::class, 'update_status'])->middleware(['role:admin'])->name('update_leave_status');


//    Route::resource('/holiday', HolidayController::class);

    Route::resource('/department', Department::class)->middleware(['role:admin']);
//    Route::post('/toggle-time/{user}', [AttendanceController::class, 'toggleTime'])->name('toggle-time');

//        ---------------------------AttendanceController --------------------------

    Route::post('/finish-work', [AttendanceController::class, 'finishWork'])->name('finish.work');
    Route::post('/start-work', [AttendanceController::class, 'startWork'])->name('start.work');
    Route::post('/attendance/get-attendance', [AttendanceController::class, 'getAttendance'])->name('get-attendance');
    Route::get('/attendance/my', [AttendanceController::class, 'index_my'])->name('attendance.myreport');
    Route::get('/attendance/mysumary', [AttendanceController::class, 'report_my'])->name('attendance.mysumary');

    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');

    Route::resource('/attendance', AttendanceController::class);

    Route::get('/holiday/holidays-this-month', [HolidayController::class,'holidaysThisMonthDisplay'])->name('holiday.holidaysThisMonthDisplay');

    Route::resource('/Holiday', HolidayController::class);

    Route::resource('/settings', SettingsController::class)->middleware(['role:admin']);



});

Route::get('/pass',function(){
    echo Hash::make(1);
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
