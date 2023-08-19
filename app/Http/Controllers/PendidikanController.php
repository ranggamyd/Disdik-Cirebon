<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendidikan;
use DB;

class PendidikanController extends Controller
{
	public function index(Request $request)
	{
		if($request->ajax()) {
			return Pendidikan::dataTable($request);
		}

		return view('admin.pendidikan.index', [
			'title'         => 'Pendidikan',
			'breadcrumbs'   => [
				[
					'title' => 'Pendidikan',
					'link'  => route('pendidikan')
				]
			]
		]);
	}


	public function create()
	{
		return view('admin.pendidikan.create', [
			'title'         => 'Tambah Pendidikan',
			'breadcrumbs'   => [
				[
					'title' => 'Pendidikan',
					'link'  => route('pendidikan')
				],
				[
					'title' => 'Tambah Pendidikan',
					'link'  => route('pendidikan.create')
				]
			]
		]);
	}


	public function store(Request $request)
	{
		DB::beginTransaction();

		try {
			Pendidikan::createPendidikan($request->all());
			DB::commit();

			return \Res::save();
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}


	public function edit(Pendidikan $pendidikan)
	{
		return view('admin.pendidikan.edit', [
			'title'			=> 'Edit Pendidikan',
			'pendidikan'	=> $pendidikan,
			'breadcrumbs'   => [
				[
					'title' => 'Pendidikan',
					'link'  => route('pendidikan')
				],
				[
					'title' => 'Edit Pendidikan',
					'link'  => route('pendidikan.edit', $pendidikan->id_pendidikan)
				]
			]
		]);
	}


	public function update(Request $request, Pendidikan $pendidikan)
	{
		DB::beginTransaction();

		try {
			$pendidikan->updatePendidikan($request->all());
			DB::commit();

			return \Res::update();
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}


	public function destroy(Pendidikan $pendidikan)
	{
		DB::beginTransaction();

		try {
			$pendidikan->deletePendidikan();
			DB::commit();

			return \Res::delete();
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}
}
