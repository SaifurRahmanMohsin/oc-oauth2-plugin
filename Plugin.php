<?php namespace Mohsin\OAuth2;

use App;
use Config;
use Backend;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

/**
 * OAuth2 Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'OAuth2',
            'description' => 'OAuth provider for Auth plugin',
            'author'      => 'Saifur Rahman Mohsin',
            'icon'        => 'icon-lock'
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('passport:install', 'Laravel\Passport\Console\InstallCommand');
    }
}
