<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauth2SessionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth2_sessions', function($table)
		{
		    $table->increments('id');
		    $table->string('client_id');
		    $table->string('redirect_uri');
		    $table->integer('type_id');
		    $table->enum('type', array('user', 'auto'));	
		    $table->string('code');
		    $table->string('access_token');
			$table->enum('stage', array('request', 'granted'));			
			$table->boolean('limited_access')->default(false);
			$table->string('scopes')->nullable();
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
		Schema::drop('oauth2_sessions');
	}

}
