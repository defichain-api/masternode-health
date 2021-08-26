<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebhooksTable extends Migration
{
	public function up()
	{
		Schema::create('webhooks', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->uuid('api_key_id');
            $table->foreign('api_key_id')
                ->references('id')
                ->on('api_keys')
                ->onDelete('cascade');
			$table->integer('max_tries')->default(3);
			$table->integer('timeout_in_seconds')->default(3);
			$table->string('url');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('webhooks');
	}
}
