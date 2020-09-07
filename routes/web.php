<?php

use Illuminate\Support\Facades\Route;

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

Route::get( '/', function () {
	return view( 'welcome' );
} );

Auth::routes();

Route::get( '/meals', 'MealController@index' )->name( 'home' );
Route::get( '/meals/add-meal/', 'MealController@addMeal' )->middleware( 'auth' );
Route::resource( 'meals', 'MealController' );
Route::resource( 'orders', 'OrderController' )->middleware( 'auth' );
Route::resource( 'users', 'UserController' )->middleware( 'auth' );

Route::post( '/meals/{meal_id}/add-order', 'MealController@addOrder' )->middleware( 'auth' );
Route::get( '/meals/{meal_id}/change-status', 'MealController@changeStatus' )->name( 'changestatus' )->middleware( 'auth' );
Route::get( '/meals/{meal_id}/overview', 'MealController@showOrderOverview' );

Route::get( '/code-login/{auth_code}', 'UserController@loginByCode' )->name( 'codelogin' );
