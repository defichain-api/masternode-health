<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeValueColumnType extends Migration
{
	public function up()
	{
		Schema::table('server_stats', function (Blueprint $table) {
			$table->text('value')->change();
		});
	}

	public function down()
	{
		Schema::table('server_stats', function (Blueprint $table) {
			$table->string('value')->change();
		});
	}
}
