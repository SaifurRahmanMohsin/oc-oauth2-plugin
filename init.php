<?php namespace Mohsin\OAuth2;

use App;
use Laravel\Passport\Passport;
use Illuminate\Foundation\AliasLoader;

$alias = AliasLoader::getInstance();
$alias->alias('Passport', '\Laravel\Passport\Passport');

App::singleton('app', function () {
    return $this->app;
});
App::singleton('auth', function ($app) {
    return new \Illuminate\Auth\AuthManager($app);
});
App::register('\Laravel\Passport\PassportServiceProvider');

Passport::ignoreMigrations();
