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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {

        
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');


        Route::get('movies', 'MoviesController@index');
        Route::get('movies/{id}', 'MoviesController@show');
        Route::post('movies', 'MoviesController@store');
        Route::put('movies/{id}', 'MoviesController@update');        
        Route::delete('movies/{id}', 'MoviesController@delete');

    });
});
