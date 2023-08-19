<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

class LoginController extends Controller
{
	public function index()
	{
		return view('auth.login');
	}

	public function login(Request $request)
	{
		$username = $request->username;
		$password = $request->password;

		$user = User::where('username', $username)
					->where('password', $password)
					->first();

		if(!$user) {
			$user = User::where('email', $username)
						->where('password', $password)
						->first();
		}

		if($user) {
			auth()->loginUsingId($user->id_user);

			return \Res::success();
		} else {
			return \Res::error([
				'message'	=> 'Username/Email atau Password Salah'
			]);
		}
	}

	public function register()
	{
		return view('auth.register');
	}

	public function saveRegister(Request $request)
	{
		$request->validate([
			'username'	=> 'required|unique:user,username',
		], [
			'username.unique' => 'Username tidak tersedia'
		]);

		$request->validate([
			'email'		=> 'required|unique:user,email',
		], [
			'email.unique' => 'Email tidak tersedia'
		]);

		try {
			DB::beginTransaction();
			User::createUser([
				'nama'		=> $request->nama,
				'username'	=> $request->username,
				'email'		=> $request->email,
				'password'	=> $request->password,
				'role' 		=> 'Pemohon'
			]);
			DB::commit();

			return \Res::success();
		} catch (Exception $e) {
			DB::rollback();

			return \Res::error($e);
		}
	}

	public function logout()
	{
		if(auth()->check()) {
			auth()->logout();
		}

		return redirect('/');
	}
}
