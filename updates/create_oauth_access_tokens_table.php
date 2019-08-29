<?php namespace Mohsin\OAuth2\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOauthAccessTokensTable extends Migration
{
    public function up()
    {
        Schema::create('oauth_access_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->integer('user_id')->index()->nullable();
            $table->integer('client_id');
            $table->string('name')->nullable();
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->timestamps();
            $table->dateTime('expires_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::drop('oauth_access_tokens');
    }
}
