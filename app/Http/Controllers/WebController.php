<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendidikan;
use App\Models\Permohonan;
use App\Models\PermohonanDetail;
use App\Models\Persyaratan;
use App\Models\Transaksi;
use App\Models\KotakSaran;
use App\Models\Promosi;
use DB;

class WebController extends Controller
{
	public function index()
	{
		return view('web.index', [
			'title' => 'Beranda'
		]);
	}


	public function pilihSatuanPendidikan()
	{
		return view('web.pilih_satuan_pendidikan', [
			'title' => 'Pilih Satuan Pendidikan'
		]);
	}


	public function buatPermohonan(Pendidikan $pendidikan)
	{
		if (auth()->guest() || auth()->user()->role != 'Pemohon') {
			return redirect('/login');
		}

		return view('web.buat_permohonan', [
			'title' 		=> 'Buat Permohonan',
			'pendidikan'	=> $pendidikan,
		]);
	}


	public function saveBuatPermohonan(Request $request, Pendidikan $pendidikan)
	{
		$no_pendaftaran = rand(10000000, 99999999);
		try {
			DB::beginTransaction();
			$permohonan = Permohonan::create(array_merge($request->all(), [
				'status' => 'Tertunda',
				'id_pendidikan' => $pendidikan->id_pendidikan,
				'no_pendaftaran' => $no_pendaftaran,
				'id_user' => auth()->user()->id_user,
			]));
			DB::commit();

			foreach ($request->persyaratan as $key => $value) {
				$persyaratan = Persyaratan::find($key);
				$response = '';
				if ($persyaratan->tipe_input == 'File upload') {
					$file = $request->file('persyaratan')[$key];
					$response = date('Ymdhis_') . $file->getClientOriginalName();
					$file->move('storage/uploads', $response);
				} else {
					$response = $value;
				}

				DB::beginTransaction();
				PermohonanDetail::create([
					'id_permohonan' => $permohonan->id_permohonan,
					'id_persyaratan' => $key,
					'response' => $response
				]);
				DB::commit();
			}

			return \Res::success(['no_pendaftaran' => $no_pendaftaran]);
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}


	public function cekPermohonan()
	{
		return view('web.cek_permohonan', [
			'title' 		=> 'Cek Status Permohonan Perizinan'
		]);
	}


	public function permohonan($noPendaftaran)
	{
		$permohonan = Permohonan::where('no_pendaftaran', $noPendaftaran)->first();

		if ($permohonan) {
			return view('web.permohonan', [
				'title' 		=> 'Detail Status Permohonan Perizinan',
				'permohonan'	=> $permohonan,
			]);
		}

		abort(404);
	}

	public function tentang()
	{
		return view('web.tentang', [
			'title' => 'Tentang Aplikasi'
		]);
	}
}
