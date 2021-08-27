<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisableThrottlingColumnApiKeysTable extends Migration
{
	public function up()
	{
		Schema::table('api_keys', function (Blueprint $table) {
			$table->boolean('throttle_disabled')->default(false)->after('is_active');
		});
	}

	public function down()
	{
		Schema::table('api_keys', function (Blueprint $table) {
			$table->dropColumn('throttle_disabled');
		});
	}
}
