<?php

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
//$router->group(['middleware' => ['web']], function ($router) {
    $router->get('/', 'VoucherController@index');
    $router->get('/create',['as'=>'profile','uses'=> 'VoucherController@create']);
    $router->post('/save', 'VoucherController@save');
//});

