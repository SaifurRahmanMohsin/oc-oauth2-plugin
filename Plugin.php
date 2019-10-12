<?php namespace Mohsin\OAuth2;

use App;
use Laravel\Passport\Passport;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;
use Backend\Models\User as BackendUser;
use Mohsin\OAuth2\Classes\OAuth2ServiceProvider;

/**
 * OAuth2 Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = ['Mohsin.Auth'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'OAuth2',
            'description' => 'OAuth2 Provider for Auth plugin',
            'author'      => 'Saifur Rahman Mohsin',
            'icon'        => 'icon-lock'
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('passport:install', 'Laravel\Passport\Console\InstallCommand');
    }

    public function boot()
    {
        BackendUser::extend(function ($model) {
            if (!$model->isClassExtendedWith('Mohsin.OAuth2.Behaviors.ApiTokenable')) {
                $model->implement[] = 'Mohsin.OAuth2.Behaviors.ApiTokenable';
            }
        });

        App::register('\Laravel\Passport\PassportServiceProvider');

        $facade = AliasLoader::getInstance();
        $facade->alias('Passport', '\Laravel\Passport\Passport');

        Passport::ignoreMigrations();
    }

    public function registerAuthMechanisms()
    {
        return [
            'oauth2' => [
              'name'     => 'OAuth 2',
              'callback' => function ($request, $next) {
                  return OAuth2ServiceProvider::handle($request, $next);
              }
            ]
        ];
    }
}
