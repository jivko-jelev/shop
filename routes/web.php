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


Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/users', 'UserController@index')->name('users');
        Route::get('/users/ajax', 'UserController@ajax')->name('users.ajax');
        Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
        Route::put('/users/{user}/update', 'UserController@update')->name('users.update');
        Route::get('/users/test', 'UserController@test')->name('test');
    });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
