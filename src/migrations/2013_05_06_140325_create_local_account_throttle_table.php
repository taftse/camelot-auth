<?php

use Illuminate\Database\Migrations\Migration;

class CreatelocalAccountThrottleTable extends Migration {

	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('local_account_throttle', function($table)
		{
			$table->increments('id');
			$table->integer('account_id')->unsigned();
			$table->string('ip_address');
			$table->integer('attempts')->default(0);
			$table->boolean('suspended')->default(false);
			$table->timestamp('last_attempt_at')->nullable();
			$table->timestamp('suspended_at')->nullable();
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
	Schema::drop('throttle');
	}
}