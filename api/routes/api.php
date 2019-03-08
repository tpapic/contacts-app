<?php

use Dingo\Api\Routing\Router;
use App\Api\V1\Controllers\UserController;
use App\Api\V1\Controllers\ContactController;
use App\Api\V1\Controllers\AuthController;
use App\Api\V1\Controllers\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use App\Exceptions\GeneralExceptionHandler;

/** Register custom exception handling */
new GeneralExceptionHandler();

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {

    $api->get('ping', function () {
        try {
            App\User::first();
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'reason' => 'error'
            ]);
        }

        return response()->json([
            'success' => true,
            'reason' => 'pong'
        ]);
    });

    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('registration',  AuthController::class . '@registration');
        $api->post('login', AuthController::class . '@login');
        $api->post('logout', AuthController::class .'@logout');
    });

    /* Protected routes */
    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);

        $api->get('auth/me', AuthController::class . '@me');

        /* User */
        $api->group(['prefix' => 'users'], function () use ($api) {
            $api->get('/', UserController::class . '@index');
            $api->post('/', UserController::class . '@store');
        });

        /* Contacts */
        $api->resource('contacts', ContactController::class);
        

    });

});
