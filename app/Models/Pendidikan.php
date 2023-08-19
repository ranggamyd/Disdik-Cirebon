<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
	protected $table = 'pendidikan';
	protected $fillable = [ 'id_pendidikan', 'nama_pendidikan', 'singkatan', 'id_kategori', 'deskripsi' ];
	protected $primaryKey = 'id_pendidikan';


	/**
	 *  Relationship methods
	 * */
	public function kategoriPendidikan()
	{
		return $this->belongsTo('App\Models\KategoriPendidikan', 'id_kategori');
	}

	public function persyaratan()
    {
        return $this->hasMany('App\Models\Persyaratan', 'id_pendidikan');
    }



	/**
	 *  CRUD methods
	 * */
	public static function createPendidikan(array $request)
	{
		return self::create($request);
	}

	public function updatePendidikan(array $request)
	{
		$this->update($request);
		return $this;
	}

	public function deletePendidikan()
	{
		return $this->delete();
	}


	/**
	 *  Static methods
	 * */
	public static function dataTable($request)
	{
		$data = self::select([ 'pendidikan.*' ])
					->with([ 'kategoriPendidikan' ]);

		return datatables()->eloquent($data)
			->addColumn('action', function ($data) {
				$action = '
					<div class="dropdown">
						<button class="btn btn-primary px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Pilih Aksi
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="'.route('pendidikan.edit', $data->id_kategori).'">
								<i class="fas fa-pencil-alt mr-1"></i> Edit
							</a>
							<a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus?" data-delete-href="'.route('pendidikan.destroy', $data->id_kategori).'">
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
