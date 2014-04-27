<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaml2EntitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('saml2_entities', function($table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('uid');
            $table->string('name_id_format');
            $table->string('support_url');
            $table->string('home_url');
            $table->string('type');
            $table->boolean('approved')->default(false);
            $table->boolean('active')->default(false);
            $table->string('description');
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
        Schema::drop('saml2_entities');
	}

}
