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

// RUTAS DE PRUEBA
Route::get('/', function () {
    return view('welcome');
    //echo "<h1>Hola Mundo</h1>";
});


/*
GET: Conseguir datos
POST: Guardar datos
PUT: Actualizar datos
DELETE: Eliminar datos
*/

Route::get('/hola', function(){
    //return view('welcome');
    echo "<h1>Hola Mundo</h1>";
});

Route::get('/pruebas/{nombre?}', function($nombre=null){
    $texto = '<h2>Texto de una ruta</>';
    $texto .= 'Nombre: '.$nombre;
    return  view('pruebas', array(
        'texto' => $texto
    ));
});

Route::get('animales', 'PruebasController@index');
Route::get('test-orm', 'PruebasController@testOrm');

//RUTAS DEL API

    /*
    GET: Conseguir datos o recursos
    POST: Guardar datos o recursos o hacer logica desde un formulario
    PUT: Actualizar datos o recursos
    DELETE: Eliminar datos o recursos
    */

    //Rutas de prueba
    Route::get('/usuario/pruebas','UserController@pruebas');
    Route::get('/categoria/pruebas','CategoryController@pruebas');
    Route::get('/entrada/pruebas','PostController@pruebas');

// Rutas del controlador de usuarios
Route::post('/api/register', 'UserController@register');
Route::post('/api/login', 'UserController@login');
