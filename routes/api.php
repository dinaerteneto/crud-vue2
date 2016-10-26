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


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
*/

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'product-category'], function()
{
	Route::post('/', 'ProductCategoryController@store'); //Create
	Route::get('show/{id}', 'ProductCategoryController@show'); //Read - get one
	Route::put('{id}', 'ProductCategoryController@update'); //Update
	Route::delete('{id}', 'ProductCategoryController@destroy'); //Delete
	Route::get('/get-allx', 'ProductCategoryController@getAll'); //get-all - paginated

	Route::get('/get-data', 'ProductCategoryController@getData');
});

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'product'], function()
{
	Route::post('/', 'ProductController@store'); //Create
	Route::get('{id}', 'ProductController@show'); //Read - get one
	Route::post('update/{id}', 'ProductController@update'); //Update
	Route::delete('{id}', 'ProductController@destroy'); //Delete
	Route::get('/', 'ProductController@getAll'); //get-all - paginated
});

Route::group(['middleware' => 'web'], function() {
	Route::post('/register', 'Auth\RegisterController@create');
	Route::post('/signin', 'Auth\LoginController@signin');
});
Route::group(['middleware' => 'jwt.auth'], function() {
	Route::get('/user', 'UserController@index');
});