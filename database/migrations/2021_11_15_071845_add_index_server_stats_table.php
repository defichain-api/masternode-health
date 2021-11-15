<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexServerStatsTable extends Migration
{
	public function up()
	{
		Schema::table('server_stats', function (Blueprint $table) {
			$table->index('created_at');
			$table->index('updated_at');
		});
	}

	public function down()
	{
		Schema::table('server_stats', function (Blueprint $table) {
			$table->dropIndex('server_stats_created_at_index');
			$table->dropIndex('server_stats_updated_at_index');
		});
	}
}
