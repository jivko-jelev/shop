<?php

use App\Product;

Route::get('category/{category}', 'ProductController@index')->name('products.index');
Route::get('products/{permalink}', 'ProductController@show')->name('product.show');
Route::post('cart/{product}', 'CartController@store')->name('carts.store');
Route::get('cart', 'CartController@index')->name('carts.index');

Route::prefix('admin')
     ->middleware(['auth', 'admin'])
     ->group(function () {
         Route::get('', 'DashboardController@index')->name('dashboard');

         // Потребители
         Route::get('users', 'UserController@index')->name('users');
         Route::post('users/ajax', 'UserController@ajax')->name('users.ajax');
         Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
         Route::put('users/{user}/update', 'UserController@update')->name('users.update');
         Route::delete('users/{user}/delete', 'UserController@destroy')->name('users.destroy');

         // Категории
         Route::get('categories', 'CategoryController@index')->name('categories');
         Route::get('categories/create', 'CategoryController@create')->name('categories.create');
         Route::get('categories/{category}/edit', 'CategoryController@edit')->name('categories.edit');
         Route::post('categories', 'CategoryController@store')->name('categories.store');
         Route::post('categories/ajax', 'CategoryController@ajax')->name('categories.ajax');
         Route::put('categories/{category}/update', 'CategoryController@update')->name('categories.update');
         Route::delete('categories/{category}', 'CategoryController@destroy')->name('categories.destroy');
         Route::get('categories/{category}/properties', 'CategoryController@getProperties')
              ->name('categories.properties');

         Route::get('categories/{category}/full-edit', 'CategoryController@fullEdit')->name('categories.full.edit');

         // Продукти
         Route::get('products', 'ProductController@indexAdmin')->name('products.index.admin');
         Route::post('products/ajax', 'ProductController@ajax')->name('products.ajax');
         Route::get('products/create', 'ProductController@create')->name('products.create');
         Route::get('products/{product}', 'ProductController@show')->name('products.show');
         Route::post('products/store', 'ProductController@store')->name('products.store');
         Route::get('products/{product}/edit', 'ProductController@edit')->name('products.edit');
         Route::put('products/{product}', 'ProductController@update')->name('products.update');
         Route::delete('products/{product}', 'ProductController@destroy')->name('products.destroy');

         // Снимки
         Route::post('pictures/store', 'PictureController@store')->name('pictures.store');
         Route::post('thumbnails', 'ThumbnailController@index')->name('thumbnails.index');
         Route::delete('pictures/{picture}', 'PictureController@destroy')->name('pictures.destroy');

         Route::delete('properties/{properties}/destroy', 'PropertiesController@destroy')->name('properties.destroy');
         Route::delete('sub-properties/{subProperties}/destroy', 'SubPropertiesController@destroy')
              ->name('subproperties.destroy');

         Route::delete('subvariation/{subvariation}/destroy', 'SubVariationController@destroy')
              ->name('subvariation.destroy');
     });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('test', function () {
    $str   = 'окастря';
    $array = [];
    for ($i = 0; $i < mb_strlen($str); $i++) {
        $array[] = mb_substr($str, $i, 1);
    }


    function depth_picker($arr, $temp_string, &$collect)
    {
        if ($temp_string != "")
            $collect [] = $temp_string;

        for ($i = 0, $iMax = sizeof($arr); $i < $iMax; $i++) {
            $arrcopy = $arr;
            $elem    = array_splice($arrcopy, $i, 1);
            if (sizeof($arrcopy) > 0) {
                depth_picker($arrcopy, $temp_string . " " . $elem[0], $collect);
            } else {
                $collect [] = $temp_string . " " . $elem[0];
            }
        }
    }

    $collect = [];
    depth_picker($array, "", $collect);
    foreach ($collect as $key => $item) {
        if (mb_strlen($item) == 10 && mb_substr($item, 1, 1) == 'к' && mb_substr($item, 9, 1) == 'т') {
            echo $item . '<br>';
        }
    };

});