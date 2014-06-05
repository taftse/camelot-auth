<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaml2CertificatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('saml2_certificates', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('entity_id');
            $table->string('type')->nullable();
            $table->text('data')->nullable();
            $table->boolean('default')->default(false);
            $table->string('fingerprint')->nullable();
            $table->string('subject')->nullable();
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
        Schema::drop('saml2_certificates');
	}

}
