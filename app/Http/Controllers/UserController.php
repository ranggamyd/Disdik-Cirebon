<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MyClass\Validations;
use App\Models\Admin;
use DB;

class UserController extends Controller
{
	
	public function index(Request $request)
	{
		if($request->ajax()) {
			return Admin::dataTable($request);
		}

		return view('admin.user.index', [
			'title'			=> 'User',
			'breadcrumbs'	=> [
				[
					'title'	=> 'User',
					'link'	=> route('user')
				]
			]
		]);
	}


	public function create()
	{
		return view('admin.user.create', [
			'title'			=> 'Tambah User',
			'breadcrumbs'	=> [
				[
					'title'	=> 'User',
					'link'	=> route('user')
				],
				[
					'title'	=> 'Tambah User',
					'link'	=> route('user.create')
				]
			]
		]);
	}


	public function store(Request $request)
	{
		DB::beginTransaction();

		try {
			Admin::createAdmin($request->all());
			DB::commit();

			return \Res::save();
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}


	public function edit(Admin $admin)
	{
		return view('admin.user.edit', [
			'title'			=> 'Edit User',
			'admin'			=> $admin,
			'breadcrumbs'	=> [
				[
					'title'	=> 'User',
					'link'	=> route('user')
				],
				[
					'title'	=> 'Edit User',
					'link'	=> route('user.edit', $admin->id_admin)
				]
			]
		]);
	}


	public function update(Request $request, Admin $admin)
	{
		DB::beginTransaction();

		try {
			$admin->updateAdmin($request);
			DB::commit();

			return \Res::update();
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}


	public function destroy(Admin $admin)
	{
		DB::beginTransaction();

		try {
			$admin->deleteAdmin();
			DB::commit();

			return \Res::delete();
		} catch (\Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}
}
