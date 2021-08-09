<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiKeyTable extends Migration
{
	public function up()
	{
		Schema::create('api_keys', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->integer('throttle')->default(60);
			$table->boolean('is_active')->default(true);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('api_keys');
	}
}
