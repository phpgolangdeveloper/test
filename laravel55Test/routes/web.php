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

$router->get('/', function () {
    return view('welcome');
});


$router->get('/test', function () {

//    $router->get('commodity/{commodityId}', 'More\v2\GoodsController@getCommodityInfoById');


});
