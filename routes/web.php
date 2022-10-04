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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/', 'HomeController@index');
Route::post('SearchVelo', 'HomeController@SearchVelo');
Route::get('/home', 'Auth\RoleController@index');
Route::match(['get', 'post'],'Contact', 'HomeController@contact');

Route::get('/Admin', 'Admin\AdminController@index');
Route::match(['get', 'post'],'/Setting', 'Admin\AdminController@setting');
Route::match(['get', 'post'],'/Password', 'Admin\AdminController@password');
Route::resource('GestionContact', 'Admin\ContactController');
Route::resource('GestionVelo', 'Admin\VeloController');
Route::resource('GestionClient', 'Admin\ClientController');

Route::get('/Client', 'Client\ClientController@index');
Route::match(['get', 'post'],'/SettingClient', 'Client\ClientController@setting');
Route::match(['get', 'post'],'/PasswordClient', 'Client\ClientController@password');
Route::resource('ListDemande', 'Client\DemandeController');
Route::resource('ListVelo', 'Client\VeloController');