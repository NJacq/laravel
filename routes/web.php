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

Route::get('/', function () {
    return view('welcome');
});

// pour l'API
Route::get('/api/departements', 'Api\DepartementController@list'); // API pour récupèrer un seul département
Route::get('/api/departements/geojson', 'Api\DepartementController@geojson'); // API pour récupèrer le geojson des contours de départements
Route::get('/api/departements/{id}', 'Api\DepartementController@show'); // API pour récupèrer la liste des départements
Route::get('/api/regions', 'Api\RegionController@list'); // API pour récupèrer la liste des regions
Route::get('/api/regions/{id}', 'Api\RegionController@show'); // API pour récupèrer le detail d'une region

Auth::routes(); // routes ajoutées par Laravel pour l'authentification

Route::get('/', 'Front\IndexController@index')->name('index');
