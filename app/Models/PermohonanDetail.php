<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanDetail extends Model
{
	protected $table = 'permohonan_detail';
	protected $fillable = [ 'id_permohonan', 'id_persyaratan', 'response' ];
	protected $primaryKey = 'id_detail';


	/**
	 * 	Relationship methods
	 * */
	public function permohonan()
	{
		return $this->belongsTo('App\Models\Permohonan', 'id_permohonan');
	}

	public function persyaratan()
	{
		return $this->belongsTo('App\Models\Persyaratan', 'id_persyaratan');
	}


	/**
	 * 	Helper methods
	 * */
	public function namaPersyaratan()
	{
		return $this->persyaratan->nama_persyaratan ?? '-';
	}

	public function response()
	{
		if($this->persyaratan->tipe_input == 'File upload') {
			return '<a href="'.url('storage/uploads/'.$this->response).'" download> Klik Disini </a>';
		} else {
			return $this->response;
		}
	}
}
