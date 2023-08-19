<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
	protected $table = 'permohonan';
	protected $fillable = [ 'no_pendaftaran', 'nama_yayasan', 'nama_ketua_yayasan', 'no_telp', 'email', 'alamat', 'id_pendidikan', 'nama_pendidikan', 'nama_kepala_pendidikan', 'status', 'id_user' ];
	protected $primaryKey = 'id_permohonan';


	/**
	 * 	Relationship methods
	 * */
	public function pendidikan()
	{
		return $this->belongsTo('App\Models\Pendidikan', 'id_pendidikan');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'id_user');
	}

	public function permohonanDetail()
	{
		return $this->hasMany('App\Models\PermohonanDetail', 'id_permohonan')
					->with([ 'persyaratan' ]);
	}



	/**
	 *  Static methods
	 * */
	public static function dataTable($request)
	{
		$data = self::select([ 'permohonan.*' ])
					->leftJoin('pendidikan', 'permohonan.id_pendidikan', '=', 'pendidikan.id_pendidikan')
					->with([ 'pendidikan' ]);

		if(!empty($request->status)) {
			$data = $data->where('status', $request->status);
		}

		if(auth()->user()->role == 'Pemohon') {
			$data = $data->where('id_user', auth()->user()->id_user);
		}

		return datatables()->eloquent($data)
			->addColumn('action', function ($data) {
				$action = '
					<a class="btn btn-primary" href="'.route('permohonan.detail', $data->id_permohonan).'">
						<i class="fas fa-search mr-1"></i> Detail
					</a>';
				return $action;
			})
			->addColumn('pemohon_action', function ($data) {
				$action = '
					<a class="btn btn-primary" href="'.route('permohonan_perizinan.detail', $data->id_permohonan).'">
						<i class="fas fa-search mr-1"></i> Detail
					</a>';
				return $action;
			})
			->addColumn('created_at', function($data){
				return $data->created_at->format('d M Y');
			})
			->rawColumns([ 'action', 'pemohon_action' ])
			->addIndexColumn()
			->make(true);
	}
}
