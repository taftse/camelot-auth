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
            $table->string('name')->nullable();
            $table->string('uid');
            $table->string('name_id_format')->nullable();
            $table->string('support_url')->nullable();
            $table->string('home_url')->nullable();
            $table->string('type')->nullable();
            $table->boolean('approved')->default(false);
            $table->boolean('active')->default(false);
            $table->string('description')->nullable();
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
