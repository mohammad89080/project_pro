<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HolidayController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/user',function (\Illuminate\Http\Request $request){
    return $request;
});
Route::post('/user',function (){
    return view('user');
});
Route::post('/user/{name}',function ($name){
    return $name;
});
Route::controller('posts',[\App\Models\Department::class])->group(function (){
    Route::get('post/create','create');
});
Route::resource('posts',[\App\Models\Department::class])->except([
    'create'
]);
