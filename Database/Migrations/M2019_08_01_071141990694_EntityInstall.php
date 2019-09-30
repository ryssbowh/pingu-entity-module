<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class M2019_08_01_071141990694_EntityInstall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundle_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bundle');
            $table->boolean('deletable');
            $table->boolean('editable');
            $table->string('machineName');
            $table->morphs('instance');
            $table->integer('weight');
            $table->timestamps();
        });

        Schema::create('bundle_field_values', function (Blueprint $table) {
            $table->increments('id');
            $table->json('value')->nullable();
            $table->morphs('entity');
            $table->integer('field_id')->unsigned();
            $table->foreign('field_id')->references('id')->on('bundle_fields')->onDelete('cascade');
            $table->integer('revision_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::create('field_booleans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('helper');
            $table->boolean('default');
            $table->timestamps();
        });

        Schema::create('field_datetimes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('helper');
            $table->string('format');
            $table->string('default');
            $table->boolean('required');
            $table->timestamps();
        });

        Schema::create('field_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('helper');
            $table->string('default');
            $table->boolean('required');
            $table->timestamps();
        });

        Schema::create('field_integers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('helper');
            $table->string('default');
            $table->boolean('required');
            $table->timestamps();
        });

        Schema::create('field_floats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('helper');
            $table->integer('precision');
            $table->string('default');
            $table->timestamps();
        });

        Schema::create('field_texts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('helper');
            $table->string('default');
            $table->boolean('required');
            $table->timestamps();
        });

        Schema::create('field_text_longs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('helper');
            $table->string('default');
            $table->boolean('required');
            $table->timestamps();
        });

        Schema::create('field_urls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('helper');
            $table->string('default');
            $table->boolean('required');
            $table->timestamps();
        });

        Schema::create('field_slugs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('helper');
            $table->string('default');
            $table->string('from');
            $table->boolean('required');
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
        Schema::dropIfExists('bundle_fields_values');
        Schema::dropIfExists('bundle_fields');
        Schema::dropIfExists('field_urls');
        Schema::dropIfExists('field_texts');
        Schema::dropIfExists('field_text_longs');
        Schema::dropIfExists('field_integers');
        Schema::dropIfExists('field_floats');
        Schema::dropIfExists('field_emails');
        Schema::dropIfExists('field_datetimes');
        Schema::dropIfExists('field_booleans');
        Schema::dropIfExists('field_slugs');
    }
}
