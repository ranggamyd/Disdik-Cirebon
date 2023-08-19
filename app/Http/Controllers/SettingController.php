<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Setting;
use Res;

class SettingController extends Controller
{

	/**
	 * 	Change Password
	 * */
	public function changePasswordIndex(Request $request)
	{
		return view('admin.setting.change_password', [
			'title'            => 'Ganti Password',
			'breadcrumbs'    => [
				[
					'title'    => 'Setting',
					'link'    => '#',
				],
				[
					'title'    => 'Ganti Password',
					'link'    => route('setting.change_password'),
				]
			]
		]);
	}

	public function changePasswordSave(Request $request)
	{
		$request->validate([
			'old_password'		=> 'required',
			'new_password'		=> 'required',
			'confirm_password'	=> 'required|same:new_password'
		], [
			'confirm_password.same'	=> 'Wajib sama dengan password baru'
		]);
		DB::beginTransaction();

		try {
			if (!user()->comparePassword($request->old_password)) {
				return Res::invalid([
					'message'    => 'Password lama salah',
					'errors'    => [
						'old_password'    => 'Password lama salah'
					]
				]);
			}
			user()->changePassword($request->new_password);
			DB::commit();

			return Res::save();
		} catch (\Exception $e) {
			DB::rollback();

			return Res::error($e);
		}
	}
}
