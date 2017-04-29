<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticTimesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('statistic_times', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('statistic_id');
            $table->bigInteger('total')->nullable()->default(0);
            $table->dateTime('started_at');
            $table->dateTime('finished_at')->nullable();

            $table->foreign('statistic_id')
                ->references('id')->on('statistics')
                ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('statistic_times');
	}

}
