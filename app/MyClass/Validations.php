<?php 

namespace App\MyClass;

class Validations
{

	public static function validationUser($request, $userID = null)
	{
		$validation  = [
			'name'				=> 'required',
			'username'				=> 'required|unique:users,username',
		];

		if(!empty($userID)) $validation['username'] = $validation['username'].','.$userID;

		if(empty($userID)) $validation['password'] = 'required|min:4';
		if(empty($userID)) $validation['confirm_password'] = 'required|same:password';

		$request->validate($validation, [
			'name.required'		=> 'Nama wajib diisi',
			'username.required'	=> 'Username wajib diisi',
			'username.unique'		=> 'Username tidak tersedia. Mohon gunakan username lain',
			'password.required'	=> 'Password wajib diisi',
			'password.min'		=> 'Password wajib berisi minimal 4 karakter',
			'confirm_password.required'	=> 'Konfirmasi password wajib diisi',
			'confirm_password.same'	=> 'Konfirmasi password wajib sama dengan password yang diisi',
		]);
	}
}