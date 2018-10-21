<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('tool_id');
			$table->integer('tool_qty');
            $table->integer('dept_id');
            $table->integer('shift_id');
            $table->integer('wrk_station_id');
            $table->integer('line_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('remarks')->nullable();	
            $table->date('return_date');	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returns');
    }
}
