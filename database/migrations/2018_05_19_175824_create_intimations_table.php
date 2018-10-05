<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntimationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intimations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('machine_name');
            $table->integer('dept_id');
            $table->dateTime('breakdown_time');
            $table->dateTime('reporting_time');
            $table->longText('nature');
            $table->integer('added_by');
            $table->dateTime('work_start')->nullable();
            $table->dateTime('machine_handover')->nullable();
            $table->integer('totalbreakdown')->nullable();
            $table->string('attended_by')->nullable();
            $table->longText('details')->nullable();
            $table->string('spare_filledby')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('intimations');
    }
}
