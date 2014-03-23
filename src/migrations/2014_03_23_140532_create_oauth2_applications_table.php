<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauth2ApplicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth2_applications', function($table)
		{
		    $table->increments('id');
		    $table->string('name');
		    $table->string('client_id');
		    $table->string('client_secret');
		    $table->string('redirect_uri');
		    $table->boolean('auto_aprove')->default(false);
			$table->boolean('autonomouse')->default(false);
			$table->enum('status', array('development', 'pending','approved','rejected'));	
			$table->boolean('suspended')->default(false);
			$table->string('notes')->nullable();
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
		Schema::drop('oauth2_applications');
	}

}


