<?php

use Illuminate\Database\Migrations\Migration;

class CreateLocalAccountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('local_account', function($table)
		{
			$table->increments('id');
			$table->integer('account_id')->unsigned();
			$table->string('username');
			$table->string('password_hash');
			$table->string('password_hint')->nullable();
			$table->string('security_question')->nullable();
			$table->string('security_answer')->nullable();
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
		Schema::drop('local_account');
	}

}