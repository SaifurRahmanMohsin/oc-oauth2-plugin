<?php namespace Mohsin\OAuth2\Behaviors;

use Laravel\Passport\HasApiTokens;

class ApiTokenable extends \October\Rain\Extension\ExtensionBase
{
    use HasApiTokens;
}
