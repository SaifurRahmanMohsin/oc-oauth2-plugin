# [OAuth2-Plugin](https://github.com/SaifurRahmanMohsin/oc-oauth2-plugin) #
OAuth2 Provider for Auth plugin of October CMS

## Introduction ##

This plugin provides OAuth2 provider using Laravel Passport. It is designed to be compatible with a future plugin that is WIP but I have pushed it early since it works fine as a standalone plugin. What this means is that in the future, you will see some breaking changes to this plugin--however, since I have planned to maintain the API signatures of the plugin (see under API heading) you can go ahead and use it with a level of confidence.

[Note: Right now this plugin is mainly been tailored for the Password grant for use in mobile apps. I tested the other grants and it works fine, however I have not documented them yet.]

## Creating Clients ##

With this plugin installed, run `php artisan passport:client` to generate the client

## Configuration ##
You need to create a config file auth.php in your config folder for configuration that looks something like this:

```
<?php

return [
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Backend\Models\User::class,
        ]
    ],
    'guards' => [
        'api' => [
            'driver' => 'session',
            'provider' => 'users',
        ]
    ],
];
```

By default, the API provider will check for the `email` field in order to authenticate the request. If you want to override this, then in your provider's model class define a **findForPassport** method with a single **$username parameter** and return an Eloquent record. In the above configuration, I am using OctoberCMS' Backend user class so you would have to override it using the extension methods only.

## API Details ##
### Password Grant API ###
##### POST /oauth/token #####

**Resource URL:** [/oauth/token](/oauth/token) [![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/7c9553f763791c82c5c7)

| Parameters | Description
------------- | -------------
grant_type  | The grant type -- Can be password, refresh_token, personal_access, implicit, authorization_code, client_credentials
client_id  | The client ID which matches the ID value in the oauth_clients table
client_secret  | The client secret which is shown when you create the client.
username  | The username of the user requesting the token.
password  | The password of the user requesting the token.

For the refresh_token, set the grant_type as **refresh_token** and send the token without other user credentials. If you have doubts on the API, [read this article](https://alexbilbie.com/guide-to-oauth-2-grants) which is accurate to the API that is supported by this plugin.

## Coming Soon ##
* RainLab.User plugin support for better token management as well as support for using username than email for authentication.
* Settings page to manage configuration.
* RESTful plugin support for better API management
* Mobile plugin support to allow instance-level token issue, singleton tokens, and other cool features.