<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReference extends Migration
{
	public function up()
	{
		Schema::table('webhooks', function (Blueprint $table) {
			$table->string('reference')->after('url')->nullable();
		});
	}

	public function down()
	{
		Schema::table('webhooks', function (Blueprint $table) {
			$table->dropColumn('reference');
		});
	}
}
