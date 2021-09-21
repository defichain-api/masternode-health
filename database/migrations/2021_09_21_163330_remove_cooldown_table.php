<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RemoveCooldownTable extends Migration
{
	public function up()
	{
        Schema::dropIfExists('kurozora_cooldowns');
	}
}
