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


Route::get('/api/regions', 'Api\RegionController@list'); // API pour récupèrer la liste des regions
Route::get('/api/region/{id}', 'Api\RegionController@show'); // API pour récupèrer le detail d'une region

Route::get('/api/ftthregions', 'Api\FtthRegionController@list'); // API pour récupèrer la liste des ftthrégions 
Route::get('/api/ftthregion/{id}', 'Api\FtthRegionController@show'); // API pour récupèrer une seule ftthrégion

// Route::get('/api/stattopregions', 'Api\StatRegionController@topshow'); // API pour récupèrer les plus fortes progressions des regions
Route::get('/api/stattopregions', 'Api\StatRegionController@list'); // API pour récupèrer les plus fortes progressions des regions


Route::get('/api/departement/{id}', 'Api\DepartementController@show');// API pour récupèrer un seul département
Route::get('/api/departements/region/{id}', 'Api\RegionController@showdepartements');// API pour récupèrer les départements d'une region

Route::get('/api/ftthdepartements', 'Api\FtthDepartementController@list');  // API pour récupèrer la liste des départements 
Route::get('/api/ftthdepartement/{id}', 'Api\FtthDepartementController@show'); // API pour récupèrer un seul département
Route::get('/api/ftthtopdepartements/region/{id}', 'Api\FtthRegionController@topshow'); // API pour récupèrer plus haut taux deployement dans 1 region

Route::get('/api/stattopdepartements/region/{id}', 'Api\StatDepartementController@show'); // API pour récupèrer les plus fortes progressions des départements d'une region
Route::get('/api/stattopdepartements', 'Api\StatDepartementController@list'); // API pour récupèrer les plus fortes progressions des départements


Route::get('/api/epci', 'Api\EpciController@list'); // API pour récupèrer la liste des epci 
Route::get('/api/epci/{id}', 'Api\EpciController@show'); // API pour récupèrer un seul epci
Route::get('/api/epci/departement/{id}', 'Api\DepartementController@showepci');// API pour récupèrer les epci d'un département


Route::get('/api/ftthtopepci/departement/{id}', 'Api\FtthDepartementController@topshowepci'); // API pour récupèrer plus haut taux deployement dans 1 departement

Route::get('/api/stattopepci/departement/{id}', 'Api\StatEpciController@show'); // API pour récupèrer les plus fortes progressions des epci d'un département


Route::get('/api/communes', 'Api\CommuneController@list'); // API pour récupèrer la liste des communes 
Route::get('/api/commune/{id}', 'Api\CommuneController@show'); // API pour récupèrer une seule commune

Route::get('/api/ftthcommunes', 'Api\FtthCommuneController@list'); // API pour récupèrer la liste des communes 
Route::get('/api/ftthcommune/{id}', 'Api\FtthCommuneController@show'); // API pour récupèrer une seule commune
Route::get('/api/ftthtopcommunes/departement/{id}', 'Api\FtthDepartementController@topshowcommunes'); // API pour récupèrer plus haut taux deployement dans 1 departement
Route::get('/api/ftthtopcommunes/epci/{id}', 'Api\FtthEpciController@topshowcommunes'); // API pour récupèrer plus haut taux deployement dans 1 departement

Route::get('/api/stattopcommunes/departement/{id}', 'Api\StatCommuneController@showdepartement'); // API pour récupèrer les plus fortes progressions des communes d'un département
Route::get('/api/stattopcommunes/epci/{id}', 'Api\StatCommuneController@showepci'); // API pour récupèrer les plus fortes progressions des communes d'un epci


Route::get('/api/arrondissements', 'Api\ArrondissementController@list'); // API pour récupèrer la liste des arrondissements 
Route::get('/api/arrondissement/{id}', 'Api\ArrondissementController@show'); // API pour récupèrer un seul 

Route::get('/api/fttharrondissements', 'Api\FtthArrondissementController@list'); // API pour récupèrer la liste des arrondissements 
Route::get('/api/fttharrondissement/{id}', 'Api\FtthArrondissementController@show'); // API pour récupèrer un seul
Route::get('/api/ftthtoparrondissements/commune/{id}', 'Api\FtthCommuneController@topshowarrondissements'); // API pour récupèrer plus haut taux deployement dans 1 commune

Route::get('/api/stattoparrondissements/commune/{id}', 'Api\StatArrondissementController@showarrondissement'); // API pour récupèrer les plus fortes progressions des arrondissements d'une commune




Auth::routes(); // routes ajoutées par Laravel pour l'authentification

Route::get('/', 'Front\IndexController@index')->name('index');
