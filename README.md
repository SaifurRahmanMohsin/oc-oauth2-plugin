# [OAuth2 Plugin](https://github.com/SaifurRahmanMohsin/oc-oauth2-plugin) #
OAuth2 provider for Auth plugin of OctoberCMS

## Introduction ##

This plugin provides OAuth2 provider using Laravel Passport. This can be used as a standalone plugin as the routes are exposed directly than via the [Rest plugin](https://github.com/SaifurRahmanMohsin/oc-rest-plugin), however, it may be much more difficult to integrate that way as you will have to manually set the API nodes to use the appropriate middleware layer.

[Note: Right now this plugin is mainly been tailored for the Password grant for use in mobile apps. I tested the other grants and it works fine. However, I have not documented them yet.]

## Creating Clients ##

With this plugin installed, run `php artisan passport:client --password` to generate the password client.

## Configuration ##
You need to configure the API from the OctoberCMS backend in the Settings page (System > API Configuration).

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

## Limitation ##
* For now, this plugin is locked on to work with OctoberCMS's backend user model only. I extend it to all kinds of models in the near future.

## Coming Soon ##
* RainLab.User plugin support for better token management as well as support for using username than email for authentication.
* OAuth2 configuration tab in Settings to manage the tokens.
* Mobile plugin support to allow instance-level token issue, singleton tokens, and other cool features.