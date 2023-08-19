<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersyaratanTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('persyaratan', function (Blueprint $table) {
			$table->increments('id_persyaratan');
			$table->string('nama_persyaratan', 50);
			$table->integer('id_pendidikan');
			$table->enum('tipe_input', [ 'File upload', 'Text input', 'Multiple choise' ]);
			$table->boolean('is_required');
			$table->text('opsi_multiple')->nullable();
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
		Schema::dropIfExists('persyaratan');
	}
}
