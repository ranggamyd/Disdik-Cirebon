<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanDetailTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permohonan_detail', function (Blueprint $table) {
			$table->increments('id_detail');
			$table->integer('id_permohonan');
			$table->integer('id_persyaratan');
			$table->string('response', 255);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('permohonan_detail');
	}
}
