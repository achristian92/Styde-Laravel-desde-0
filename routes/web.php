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

Route::get('/usuarios',function (){
   return 'Usuarios';
});
Route::get('/usuarios/{id}',function ($id){
    return "Detalle del usuario {$id}";
})->where('id','[0-9]+');

Route::get('/usuarios/nuevo',function (){
   return 'Crear nuevo Usuario';
});

Route::get('/saludo/{usuario}/{nickname?}',function ($usuario,$nickname = null){
    $name = ucfirst($usuario);
   if($nickname != null){
       $nick = ucfirst($nickname);
       return "Hola {$name} , tu apodo es {$nick}";
   }else{
       return "Hola {$name}";
   }
});