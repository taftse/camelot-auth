<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaml2ServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('saml2_services', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('entity_id');
            $table->string('type');
            $table->string('binding');
            $table->string('location');
            $table->string('response_location')->nullable();
            $table->boolean('default')->default(false);
            $table->integer('index')->nullable();
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
        Schema::drop('saml2_services');
	}

}
