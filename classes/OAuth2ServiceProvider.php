<?php namespace Mohsin\OAuth2\Classes;

use Auth;
use DateInterval;
use Illuminate\Auth\RequestGuard;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Guards\TokenGuard;
use League\OAuth2\Server\ResourceServer;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ImplicitGrant;
use League\OAuth2\Server\Grant\PasswordGrant;
use Laravel\Passport\Bridge\PersonalAccessGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;

class OAuth2ServiceProvider extends PassportServiceProvider
{
    public static function create()
    {
        // TODO: Move this to a web UI configurator.
        app()['config']['auth'] = [
            'defaults' => [
                'guard' => 'api',
                'passwords' => 'user'
            ],
            'providers' => [
                'user' => [
                    'driver' => 'eloquent',
                    'model' => \Backend\Models\User::class,
                ]
            ],
            'guards' => [
                'api' => [
                  'driver' => 'passport',
                  'provider' => 'user',
                ]
            ]
        ];

        $config = app()['config']['auth.guards']['api'];

        $clientRepo = app()->make(\Laravel\Passport\Bridge\ClientRepository::class);
        $accessTokenRepo = app()->make(\Laravel\Passport\Bridge\AccessTokenRepository::class);
        $scopeRepo = app()->make(\Laravel\Passport\Bridge\ScopeRepository::class);
        $serviceProvider = new static(app());

        $serviceProvider->register();
        return $serviceProvider->makeGuard(app()['config']['auth.guards']['api']);

        // return $server;
    }

    public static function handle($request, $next)
    {
        $guard = self::create();
        if ($guard->user($request)) {
            return $next($request);
        } else { // TODO: Hook into October's Logger and show the actual error rendered by TokenGuard
            return response()->json('Unauthorized', 401);
        }
    }

    /**
     * Make an instance of the token guard.
     *
     * @param  array  $config
     * @return \Illuminate\Auth\RequestGuard
     */
    protected function makeGuard(array $config)
    {
        return new RequestGuard(function ($request) use ($config) {
            return (new TokenGuard(
                $this->app->make(ResourceServer::class),
                new ApiUserProvider(),
                $this->app->make(TokenRepository::class),
                $this->app->make(ClientRepository::class),
                $this->app->make('encrypter')
            ))->user($request);
        }, $this->app['request']);
    }
}
