<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendidikan;
use App\Models\Permohonan;
use App\Models\Persyaratan;
use App\Models\PermohonanDetail;
use DB;

class PermohonanPerizinanController extends Controller
{
	public function index(Request $request)
	{
		if($request->ajax()) {
			return Permohonan::dataTable($request);
		}

		return view('pemohon.permohonan_perizinan.index', [
			'title'         => 'Permohonan',
			'breadcrumbs'   => [
				[
					'title' => 'Permohonan',
					'link'  => route('permohonan_perizinan')
				]
			]
		]);
	}


	public function create(Request $request)
	{
		$pendidikan = Pendidikan::find($request->id_pendidikan);

		if($pendidikan) {
			return view('pemohon.permohonan_perizinan.create', [
				'title'         => 'Buat Permohonan',
				'pendidikan'	=> $pendidikan,
				'breadcrumbs'   => [
					[
						'title' => 'Permohonan',
						'link'  => route('permohonan_perizinan')
					],
					[
						'title' => 'Buat Permohonan',
						'link'  => route('permohonan_perizinan.create')
					]
				]
			]);
		}
	}


	public function store(Request $request)
	{
		try {
			DB::beginTransaction();
			$permohonan = Permohonan::create(array_merge($request->all(), [
				'status' => 'Tertunda',
				'id_pendidikan' => $request->id_pendidikan,
				'no_pendaftaran' => rand(10000000,99999999),
				'id_user' => auth()->user()->id_user,
			]));
			DB::commit();

			foreach($request->persyaratan as $key => $value)
			{
				$persyaratan = Persyaratan::find($key);
				$response = '';
				if($persyaratan->tipe_input == 'File upload') {
					$file = $request->file('persyaratan')[$key];
					$response = date('Ymdhis_').$file->getClientOriginalName();
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

			return \Res::success();
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}


	public function detail(Permohonan $permohonan)
	{
		return view('pemohon.permohonan_perizinan.detail', [
			'title'         => 'Detail Permohonan',
			'permohonan'    => $permohonan,
			'breadcrumbs'   => [
				[
					'title' => 'Permohonan',
					'link'  => route('permohonan_perizinan')
				],
				[
					'title' => 'Detail Permohonan',
					'link'  => route('permohonan_perizinan.detail', $permohonan->id_permohonan)
				]
			]
		]);
	}
}
