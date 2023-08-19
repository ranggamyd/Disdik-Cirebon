<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use DB;

class PermohonanController extends Controller
{
	public function index(Request $request)
	{
		if($request->ajax()) {
			return Permohonan::dataTable($request);
		}

		return view('admin.permohonan.index', [
			'title'         => 'Permohonan',
			'breadcrumbs'   => [
				[
					'title' => 'Permohonan',
					'link'  => route('permohonan')
				]
			]
		]);
	}


	public function detail(Permohonan $permohonan)
	{
		return view('admin.permohonan.detail', [
			'title'         => 'Detail Permohonan',
			'permohonan'	=> $permohonan,
			'breadcrumbs'   => [
				[
					'title' => 'Permohonan',
					'link'  => route('permohonan')
				],
				[
					'title' => 'Detail Permohonan',
					'link'  => route('permohonan.detail', $permohonan->id_permohonan)
				]
			]
		]);
	}


	public function konfirmasiPermohonan(Permohonan $permohonan)
	{
		return view('admin.permohonan.konfirmasi_permohonan', [
			'title'         => 'Konfirmasi Permohonan',
			'permohonan'	=> $permohonan,
			'breadcrumbs'   => [
				[
					'title' => 'Permohonan',
					'link'  => route('permohonan')
				],
				[
					'title' => 'Konfirmasi Permohonan',
					'link'  => route('permohonan.konfirmasi_permohonan', $permohonan->id_permohonan)
				]
			]
		]);
	}


	public function simpanKonfirmasiPermohonan(Request $request, Permohonan $permohonan)
	{
		DB::beginTransaction();

		try {
			$permohonan->update([
				'status'	=> 'Diterima',
				'id_admin'	=> auth()->user()->id
			]);
			$file = $request->file('surat_keputusan');
			$filename = $file->getClientOriginalName();
			$file->move(storage_path('app/public/uploads'), $filename);
			$path = storage_path('app/public/uploads/'.$filename);
			$catatanEmail = $request->catatan_email;

			\Mail::to($permohonan->email)->send(new \App\Mail\KonfirmasiPermohonanMail($permohonan, $catatanEmail, $path));

			DB::commit();

			return \Res::update();
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}
}
