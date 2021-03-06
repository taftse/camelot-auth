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
		    $table->string('first_name')->nullable();
		    $table->string('last_name')->nullable();
		    $table->string('email');
		    $table->boolean('email_verified')->default(false);
		    $table->string('address_1')->nullable();
		    $table->string('address_2')->nullable();
			$table->string('city')->nullable();
		    $table->string('zip_code')->nullable();
		    $table->string('state_code')->nullable();
		    $table->string('country_iso',3)->nullable();
		    $table->timestamp('dob')->nullable();
		    $table->integer('phone')->nullable();
		    $table->boolean('phone_verified')->default(false);
		    $table->enum('gender',array('male','female','other'));
		    $table->enum('status',array('pending','active','deactive','deleted'))->default('pending');
		    $table->timestamp('last_login')->nullable();
		    $table->string('last_ip')->nullable();
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
