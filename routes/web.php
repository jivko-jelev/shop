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
//$a=\App\Product::where('created_at','>','01-11-2019')->get();
//dd($a);

Route::prefix('admin')
     ->middleware(['auth', 'admin'])
     ->group(function () {
         Route::get('', function () {
             return view('admin.dashboard', ['title' => 'Табло']);
         })->name('dashboard');

         // Потребители
         Route::get('users', 'UserController@index')->name('users');
         Route::post('users/ajax', 'UserController@ajax')->name('users.ajax');
         Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
         Route::put('users/{user}/update', 'UserController@update')->name('users.update');
         Route::delete('users/{user}/delete', 'UserController@destroy')->name('users.destroy');

         // Категории
         Route::get('categories', 'CategoryController@index')->name('categories');
         Route::get('categories/{category}/edit', 'CategoryController@edit')->name('categories.edit');
         Route::post('categories', 'CategoryController@store')->name('categories.store');
         Route::post('categories/ajax', 'CategoryController@ajax')->name('categories.ajax');
         Route::put('categories/{category}/update', 'CategoryController@update')->name('categories.update');
         Route::delete('categories/{category}', 'CategoryController@destroy')->name('categories.destroy');

         // Продукти
         Route::get('products', 'ProductController@index')->name('products.index');
         Route::post('products/ajax', 'ProductController@ajax')->name('products.ajax');
         Route::get('products/create', 'ProductController@create')->name('products.create');
         Route::post('products/store', 'ProductController@store')->name('products.store');
         Route::get('products/{product}/edit', 'ProductController@edit')->name('products.edit');
         Route::put('products/{product}', 'ProductController@update')->name('products.update');
         Route::delete('products/{product}', 'ProductController@destroy')->name('products.destroy');
     });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
