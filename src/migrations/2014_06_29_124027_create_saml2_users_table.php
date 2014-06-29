<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaml2UsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('saml2_users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('account_id');
            $table->string('entity_id');
            $table->string('persistent_id');
            $table->timestamps();
            $table->softDeletes();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('saml2_users');
	}

}
