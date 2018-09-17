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
Route::get('/api/departements', 'Api\DepartementController@list');  // API pour récupèrer la liste des départements 
Route::get('/api/departements/geojson', 'Api\DepartementController@geojson'); // API pour récupèrer le geojson des contours des départements
Route::get('/api/regions/geojson', 'Api\RegionController@geojson'); // API pour récupèrer le geojson des contours des régions
Route::get('/api/departements/{id}', 'Api\DepartementController@show');// API pour récupèrer un seul département
Route::get('/api/regions', 'Api\RegionController@list'); // API pour récupèrer la liste des regions
Route::get('/api/regions/{id}', 'Api\RegionController@show'); // API pour récupèrer le detail d'une region
Route::get('/api/ftthdepartements', 'Api\FtthDepartementController@list');  // API pour récupèrer la liste des départements 
Route::get('/api/ftthdepartements/{id}', 'Api\FtthDepartementController@show'); // API pour récupèrer un seul département
Route::get('/api/ftthregions', 'Api\FtthRegionController@list'); // API pour récupèrer la liste des ftthrégions 
Route::get('/api/ftthregions/{id}', 'Api\FtthRegionController@show'); // API pour récupèrer une seule région
Route::get('/api/communes', 'Api\CommuneController@list'); // API pour récupèrer la liste des communes 
Route::get('/api/communes/{id}', 'Api\CommuneController@show'); // API pour récupèrer une seule commune
Route::get('/api/ftthcommunes', 'Api\FtthCommuneController@list'); // API pour récupèrer la liste des communes 
Route::get('/api/ftthcommunes/{id}', 'Api\FtthCommuneController@show'); // API pour récupèrer une seule commune
Route::get('/api/arrondissements', 'Api\ArrondissementController@list'); // API pour récupèrer la liste des arrondissements 
Route::get('/api/arrondissements/{id}', 'Api\ArrondissementController@show'); // API pour récupèrer un seul arrondissement
Route::get('/api/fttharrondissements', 'Api\FtthArrondissementController@list'); // API pour récupèrer la liste des arrondissements 
Route::get('/api/fttharrondissements/{id}', 'Api\FtthArrondissementController@show'); // API pour récupèrer un seul arrondissement
Route::get('/api/epci', 'Api\EpciController@list'); // API pour récupèrer la liste des epci 
Route::get('/api/epci/{id}', 'Api\EpciController@show'); // API pour récupèrer un seul epci
Route::get('/api/ftthregions?trimestre=1&annee=2018', 'Api\ftthregions@request');
Route::get('/api/ftthtopregion/{id}', 'Api\FtthRegionController@topshow'); // API pour récupèrer plus haut taux deployement
Route::get('/api/stattopregion/{id}', 'Api\StatRegionController@topshow'); // API pour récupèrer plus haut taux deployement

Auth::routes(); // routes ajoutées par Laravel pour l'authentification

Route::get('/', 'Front\IndexController@index')->name('index');
