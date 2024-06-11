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

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');
$router->post('/test', function () {
    die('Reached route');
});
//$router->post('/login', ['middleware' => 'cors', 'uses' => 'AuthController@login']);

//For test
$router->get('/protected', ['middleware' => 'auth', function () {
    return response()->json(['message' => 'This is a protected route']);
}]);

//Events
$router->post('/events', 'EventController@createEvent');
$router->put('/events/{eventId}', 'EventController@editEvent');
$router->delete('/events/{eventId}', 'EventController@deleteEvent');
$router->get('/events/{eventId}', 'EventController@getEvent');
$router->get('/events', 'EventController@listEvents');

//Guess
$router->post('/guesses', ['middleware' => 'auth', 'uses' => 'GuessController@createGuess']);
