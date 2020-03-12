<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::get("import-excel", "API\ServiceProviderController@import");
Route::post('register', "API\UserController@register");
Route::get('credentials', "API\CredentialsController@getClientDetails");
Route::group(['prefix' => 'auth'], function () {
    Route::get('signup/activate/{token}', 'API\UserController@signupActivate');
    Route::post('create', 'API\PasswordResetController@create');
    Route::get('find/{token}', 'API\PasswordResetController@find');
    Route::post('reset', 'API\PasswordResetController@reset');
});

Route::middleware('auth:api')->group(function () {
    Route::get('categoryItems', 'API\CategoryItemController@getByQuery');
    Route::resource('categoryItem', 'API\CategoryItemController');
    Route::post('wishes/create', 'API\WishController@store');
    Route::post('wishes/near-to-me', 'API\WishController@listNearestWishes');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});