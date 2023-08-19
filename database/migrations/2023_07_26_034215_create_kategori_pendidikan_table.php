<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriPendidikanTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kategori_pendidikan', function (Blueprint $table) {
			$table->increments('id_kategori');
			$table->string('nama_kategori', 50);
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
		Schema::dropIfExists('kategori_pendidikan');
	}
}
