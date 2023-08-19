<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permohonan', function (Blueprint $table) {
			$table->increments('id_permohonan');
			$table->integer('no_pendaftaran');
			$table->string('nama_yayasan', 50);
			$table->string('nama_ketua_yayasan', 50);
			$table->string('no_telp', 15);
			$table->string('email', 50);
			$table->string('alamat', 255);
			$table->integer('id_pendidikan');
			$table->string('nama_pendidikan', 50);
			$table->string('nama_kepala_pendidikan', 50);
			$table->enum('status', [ 'Tertunda', 'Diterima', 'Ditolak' ]);
			$table->integer('id_user')->nullable();
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
		Schema::dropIfExists('permohonan');
	}
}
