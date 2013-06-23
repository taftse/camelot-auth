<?php

use Illuminate\Database\Migrations\Migration;

class CreateOauthUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_users', function($table)
		{
		    $table->increments('id');
		    $table->integer('account_id');
		    $table->string('provider');
		    $table->string('user_id');
		    $table->string('username');
		    $table->string('token')->nullable();
			$table->string('token_verifier')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_users');
	}

}
