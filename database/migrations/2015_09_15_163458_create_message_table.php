<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function (Blueprint $table) {
			$table->increments('id_message');
			$table->string('id_sender');
			$table->string('id_receiver');
			$table->string('message_body');


			/*$table->integer('conv_id')->unsigned();
			$table->foreign('conv_id')->references('conv_id')->on('conversations');*/


		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
