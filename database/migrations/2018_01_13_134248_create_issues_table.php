<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
            $table->integer('tool_id');
            $table->integer('dept_id');
			 $table->integer('tool_qty');
            $table->integer('shift_id');
            $table->integer('wrk_station_id');
            $table->integer('intimation_id');	
            $table->date('issue_date');	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}
