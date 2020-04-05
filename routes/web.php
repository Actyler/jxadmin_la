<?php

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
use \Illuminate\Support\Facades\Route;
Route::prefix('/admin')->middleware(['web'])->group(function (){
    Route::get('/',"Admin\LayoutController@layout")->name('admin');
    Route::get('layout/login',"Auth\LoginController@showLoginForm")->name('admin.login');
    Route::post('layout/login',"Auth\LoginController@login");
    Route::get('layout/logout',"Auth\LoginController@logout");
    Route::get('layout/welcome',"Admin\LayoutController@welcome")->name('admin.welcome');

    Route::match(['get','post'],'menu/index','Admin\MenuController@index');
    Route::match(['get','post'],'menu/info','Admin\MenuController@info');
    Route::match(['get','post'],'menu/setStatus','Admin\MenuController@setStatus');
});
