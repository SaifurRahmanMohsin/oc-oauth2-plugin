<?php namespace Mohsin\OAuth2\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOauthAuthCodesTable extends Migration
{
    public function up()
    {
        Schema::create('oauth_auth_codes', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->integer('user_id');
            $table->integer('client_id');
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->dateTime('expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('oauth_auth_codes');
    }
}
