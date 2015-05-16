<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('local_accounts', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->string('username');
            $table->string('password_hash');
            $table->string('password_hint')->nullable();
            $table->string('security_question')->nullable();
            $table->string('security_answer')->nullable();
            $table->softDeletes();
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
		Schema::drop('local_accounts');
	}

}
