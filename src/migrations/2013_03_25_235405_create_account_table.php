<?php

use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account', function($table)
		{
		    $table->increments('id');
		    $table->string('first_name');
		    $table->string('last_name');
		    $table->string('email');
		    $table->boolean('email_verified')->default(false);
		    $table->string('address_1');
		    $table->string('address_2');
			$table->string('city');
		    $table->string('zip_code');
		    $table->string('state_code');
		    $table->string('country_iso',3);
		    $table->timestamp('dob');
		    $table->integer('phone');
		    $table->boolean('phone_verified')->default(false);
		    $table->enum('gender',array('male','female','other'));
		    $table->enum('status',array('pending','active','deactive','deleted'))->default('pending');
		    $table->timestamp('last_login');
		    $table->string('last_ip');
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
		Schema::drop('account');
	}

}
