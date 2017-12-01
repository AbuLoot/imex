<?php

Auth::routes();


// Joystick Administration
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

    Route::get('/', 'Joystick\AdminController@index');

    Route::resource('categories', 'Joystick\CategoryController');
    Route::resource('countries', 'Joystick\CountryController');
    Route::resource('companies', 'Joystick\CompanyController');
    Route::resource('cities', 'Joystick\CityController');
    Route::resource('news', 'Joystick\NewController');
    Route::resource('languages', 'Joystick\LanguageController');
    Route::resource('options', 'Joystick\OptionController');
    Route::resource('orders', 'Joystick\OrderController');
    Route::resource('pages', 'Joystick\PageController');
    Route::resource('products', 'Joystick\ProductController');
    Route::get('search-products', 'Joystick\ProductController@search');

    Route::resource('roles', 'Joystick\RoleController');
    Route::resource('users', 'Joystick\UserController');
    Route::resource('permissions', 'Joystick\PermissionController');

    Route::get('apps', 'Joystick\AppController@index');
    Route::get('apps/{id}', 'Joystick\AppController@show');
    Route::delete('apps/{id}', 'Joystick\AppController@destroy');
});


// Input
Route::get('search', 'InputController@search');

Route::get('search-ajax', 'InputController@searchAjax');

Route::post('filter-products', 'InputController@filterProducts');

Route::post('send-app', 'InputController@sendApp');


// Basket Actions
Route::get('add-to-basket/{id}', 'BasketController@addToBasket');

Route::get('clear-basket', 'BasketController@clearBasket');

Route::get('basket', 'BasketController@basket');

Route::get('basket/{id}', 'BasketController@destroy');

Route::post('store-order', 'BasketController@storeOrder');


// Favorite Actions
Route::get('toggle-favorite/{id}', 'FavoriteController@toggleFavorite');


Route::get('import', 'PageController@import');

// Pages
Route::get('/', 'PageController@index');

Route::get('brands', 'PageController@brands');

Route::get('catalog', 'PageController@catalog');

Route::get('catalog/{category}', 'PageController@categoryProducts');

Route::get('goods/{id}-{product}', 'PageController@product');

Route::get('catalog/brand/{company}', 'PageController@brandProducts');

Route::get('kontakty', 'PageController@contacts');

Route::get('{page}', 'PageController@page');
