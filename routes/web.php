<?php

use Illuminate\Support\Facades\Route;


/**7 @var \Laravel\Lumen\Routing\Router $router */

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
$router->get('/', function () {
    return 'success';
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('user', 'UserRegistrationController@getUserByEmail');
    $router->post('/user/registration', 'UserRegistrationController@registration');
    $router->get('/user/registared-user-list', 'UserRegistrationController@registaredUserList');
});
