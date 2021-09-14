<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
	public function up()
	{
		Schema::create('statistics', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->date('date')->index();
            $table->integer('api_key_count')->default(0);
            $table->integer('webhook_sent_count')->default(0);
            $table->integer('request_received_count')->default(0);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('statistics');
	}
}
