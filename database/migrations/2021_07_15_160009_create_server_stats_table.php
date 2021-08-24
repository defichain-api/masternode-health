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
            $table->uuid('api_key_id');
            $table->foreign('api_key_id')
                ->references('id')
                ->on('api_keys')
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
