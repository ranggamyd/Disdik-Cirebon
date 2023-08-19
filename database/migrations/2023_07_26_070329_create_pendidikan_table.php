<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendidikanTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pendidikan', function (Blueprint $table) {
			$table->increments('id_pendidikan');
			$table->string('nama_pendidikan', 50);
			$table->string('singkatan', 10);
			$table->integer('id_kategori');
			$table->string('deskripsi', 255);
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
		Schema::dropIfExists('pendidikan');
	}
}
