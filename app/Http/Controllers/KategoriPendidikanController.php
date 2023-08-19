<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriPendidikan;
use DB;

class KategoriPendidikanController extends Controller
{
	public function index(Request $request)
	{
		if($request->ajax()) {
			return KategoriPendidikan::dataTable($request);
		}

		return view('admin.kategori_pendidikan.index', [
			'title'         => 'Kategori Pendidikan',
			'breadcrumbs'   => [
				[
					'title' => 'Kategori Pendidikan',
					'link'  => route('kategori_pendidikan')
				]
			]
		]);
	}


	public function create()
	{
		return view('admin.kategori_pendidikan.create', [
			'title'         => 'Tambah Kategori Pendidikan',
			'breadcrumbs'   => [
				[
					'title' => 'Kategori Pendidikan',
					'link'  => route('kategori_pendidikan')
				],
				[
					'title' => 'Tambah Kategori Pendidikan',
					'link'  => route('kategori_pendidikan.create')
				]
			]
		]);
	}


	public function store(Request $request)
	{
		DB::beginTransaction();

		try {
			KategoriPendidikan::createKategoriPendidikan($request->all());
			DB::commit();

			return \Res::save();
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}


	public function edit(KategoriPendidikan $kategoriPendidikan)
	{
		return view('admin.kategori_pendidikan.edit', [
			'title'         => 'Edit Kategori Pendidikan',
			'kategoriPendidikan'         => $kategoriPendidikan,
			'breadcrumbs'   => [
				[
					'title' => 'Kategori Pendidikan',
					'link'  => route('kategori_pendidikan')
				],
				[
					'title' => 'Edit Kategori Pendidikan',
					'link'  => route('kategori_pendidikan.edit', $kategoriPendidikan->id_kategori)
				]
			]
		]);
	}


	public function update(Request $request, KategoriPendidikan $kategoriPendidikan)
	{
		DB::beginTransaction();

		try {
			$kategoriPendidikan->updateKategoriPendidikan($request->all());
			DB::commit();

			return \Res::update();
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}


	public function destroy(KategoriPendidikan $kategoriPendidikan)
	{
		DB::beginTransaction();

		try {
			$kategoriPendidikan->deleteKategoriPendidikan();
			DB::commit();

			return \Res::delete();
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}
}
