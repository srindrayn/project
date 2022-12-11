<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'prodi'], function () use ($router) {
    $router->post('/add', ['uses' => 'ProdiController@addProdi']);
    $router->get('',      ['uses' => 'ProdiController@getAllProdi']);
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/register',  ['uses' => 'AuthController@registrasi']);
    $router->post('/login',     ['uses' => 'AuthController@login']);
});

$router->group(['prefix' => 'mahasiswa'], function () use ($router) {
    $router->post('/{nim}/matakuliah/{mkId}', ['middleware' => 'auth', 'uses' => 'MahasiswaController@addMatkul']);
    $router->put('/{nim}/matakuliah/{mkId}', ['middleware' => 'auth', 'uses' => 'MahasiswaController@deleteMatKul']);
    $router->get('',            ['uses' => 'MahasiswaController@getAllMahasiswa']);
    $router->get('/profile',    ['middleware' => 'auth', 'uses' => 'MahasiswaController@getMahasiswabyToken']);
    $router->get('/{nim}',      ['uses' => 'MahasiswaController@getbyNimm']);
});

$router->group(['prefix' => 'matakuliah'], function () use ($router) {
    $router->get('',      ['uses' => 'MataKuliahController@getMataKuliah']);
    $router->post('/add', ['uses' => 'MataKuliahController@createMataKuliah']);
});
