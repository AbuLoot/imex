<?php

Auth::routes();

Route::get('import', 'PageController@import');

Route::get('goods', function() {
    $barcodes = '13p 18p 21d 2s 3s 4k 5t 7n 10k 14a 19d 22p 2x 3t 4l 6d 7p 10m 14m 1a 23p 2z 3x 4m 6e 7s 10n 14n 1b 24p 2т 3z 4n 6j 8j 10p 14p 1d 25p 37k 40k 4s 6k 8k 11k 14с 1j 26d 38k 41k 4t 6l 8m 11m 15n 1k 26p 39k 42k 4x 6m 8n 11p 15с 1l 27p 3a 43k 53k 6n 8p 12a 16d 1m 2a 3b 44k 5a 6p 8s 12k 16n 1n 2b 3d 45k 5d 6s 9d 12m 16p 1p 2d 3j 47k 5j 6t 9j 12n 16с 1s 2j 3k 48k 5k 7d 9k 12p 17d 1t 2k 3l 4a 5l 7e 9m 13a 17p 1x 2m 3m 4b 5m 7j 9n 13m 17с 1z 2n 3n 4d 5n 7k 9p 13n 18d 20d 2p 3p 4j 5s';
    $array = explode(' ', $barcodes);
    $items = [];

    foreach ($array as $key => $item) {
        $items[$item] = $item;
    }

    $products = \App\Product::orderBy('created_at')->get();
    // dd($array);

    foreach ($products as $product) {

        $ar = mb_strtolower($product->barcode);
        // echo $ar.'-<br>';
        unset($items[$ar]);

    }

    dd($items);

    // "2s" => "2s"
    // "3s" => "3s"
    // "2x" => "2x"
    // "3x" => "3x"
    // "2т" => "2т"
    // "10p" => "10p"
    // "14p" => "14p"
    // "4s" => "4s"
    // "1k" => "1k"
    // "4x" => "4x"
    // "1p" => "1p"
    // "3j" => "3j"
    // "1s" => "1s"
    // "2j" => "2j"
    // "2p" => "2p"
    // "3p" => "3p"

});

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


// Pages
Route::get('/', 'PageController@index');

Route::get('brands', 'PageController@brands');

Route::get('catalog', 'PageController@catalog');

Route::get('catalog/{category}', 'PageController@categoryProducts');

Route::get('goods/{id}-{product}', 'PageController@product');

Route::get('catalog/brand/{company}', 'PageController@brandProducts');

Route::get('kontakty', 'PageController@contacts');

Route::get('{page}', 'PageController@page');
