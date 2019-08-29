<?php

Route::group([
    'prefix' => 'oauth',
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function ($router) {
    $passportRouter = new Mohsin\OAuth2\Classes\RouteRegistrar($router);
    $passportRouter->all();
});
