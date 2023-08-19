<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPendidikan extends Model
{
	protected $table = 'kategori_pendidikan';
	protected $fillable = [ 'nama_kategori', 'deskripsi' ];
	protected $primaryKey = 'id_kategori';



	/**
	 * 	Relationship methods
	 * */
	public function pendidikan()
	{
		return $this->hasMany('App\Models\Pendidikan', 'id_kategori');
	}




	/**
	 *  CRUD methods
	 * */
	public static function createKategoriPendidikan(array $request)
	{
		return self::create($request);
	}

	public function updateKategoriPendidikan(array $request)
	{
		$this->update($request);
		return $this;
	}

	public function deleteKategoriPendidikan()
	{
		return $this->delete();
	}


	/**
	 *  Static methods
	 * */
	public static function dataTable($request)
	{
		$data = self::select([ 'kategori_pendidikan.*' ]);

		return datatables()->eloquent($data)
			->addColumn('action', function ($data) {
				$action = '
					<div class="dropdown">
						<button class="btn btn-primary px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Pilih Aksi
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="'.route('kategori_pendidikan.edit', $data->id_kategori).'">
								<i class="fas fa-pencil-alt mr-1"></i> Edit
							</a>
							<a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus?" data-delete-href="'.route('kategori_pendidikan.destroy', $data->id_kategori).'">
								<i class="fas fa-trash mr-1"></i> Hapus
							</a>
						</div>
					</div>';
				return $action;
			})
			->rawColumns([ 'action' ])
			->addIndexColumn()
			->make(true);
	}
}
