<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerStatsTable extends Migration
{
	public function up()
	{
        Schema::create('server_stats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('server_id');
            $table->foreign('server_id')
                ->references('id')
                ->on('servers')
                ->onDelete('cascade');
            $table->string('type')->index();
            $table->string('value');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::dropIfExists('server_stats');
	}
}
