<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('user_id');
			$table->string('user_name');
			$table->string('user_mail');
			$table->string('user_phone');
			$table->string('user_image');
			$table->boolean('is_connected');
			$table->boolean('is_verified');
			$table->rememberToken();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
