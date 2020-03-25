<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class M2020_03_23_184829913050_EntityAddViewModes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'view_modes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
            }
        );
        Schema::create(
            'view_modes_entities', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('view_mode_id');
                $table->foreign('view_mode_id')->references('id')->on('view_modes')->onDelete('cascade');
                $table->string('entity');
            }
        );
        Schema::table(
            'display_fields', function (Blueprint $table) {
                $table->unsignedInteger('view_mode_id')->after('displayer')->nullable();
                $table->foreign('view_mode_id')->references('id')->on('view_modes')->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
