<?php namespace Mohsin\OAuth2\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOauthRefreshTokensTable extends Migration
{
    public function up()
    {
        Schema::create('oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('access_token_id', 100)->index();
            $table->boolean('revoked');
            $table->dateTime('expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('oauth_refresh_tokens');
    }
}
