<?php 

namespace App\MyClass;

class ApiValidation
{

	public static function registerMemberValidation($request)
	{
		$request->validate([
			'name'			=> 'required',
			'email'			=> 'required|unique:users,email|email',
			'phone_number'	=> 'required|unique:users,phone_number',
			'password'		=> 'required|min:8',
			'confirm_password'	=> 'required|same:password',
		], [
			'name.required'	=> 'Nama wajib diisi.',		
			'email.required'	=> 'Email wajib diisi.',		
			'email.email'	=> 'Harap menggunakan email yang valid.',		
			'email.unique'	=> 'Email tidak tersedia. Mohon untuk ganti.',		
			'phone_number.required'	=> 'Nomor telepon wajib diisi.',		
			'phone_number.unique'	=> 'Nomor telepon tidak tersedia. Mohon untuk ganti.',	
			'password.required'	=> 'Password wajib diisi.',	
			'password.min'	=> 'Password wajib berjumlah minimal 8 karakter.',	
			'confirm_password.required'	=> 'Konfirmasi password wajib diisi.',	
			'confirm_password.same'	=> 'Konfirmasi password wajib sama dengan password.',	
		]);
	}


	public static function verificationValidation($request)
	{
		$request->validate([
			'otp'	=> 'required|min:6',
		], [
			'otp.required'	=> 'Kode OTP wajib diisi',
			'otp.min'		=> 'Kode OTP berjumlah 6 digit angka'
		]);
	}


	public static function setMemberProfile($request)
	{
		$request->validate([
			'store_name'	=> 'required',
			'store_address'	=> 'required',
			'owner_name'	=> 'required',
			'owner_ktp_no'	=> 'required',
			'id_distributor'=> 'required',
		], [
			'store_name.required'	=> 'Nama toko wajib diisi.',		
			'store_address.required'	=> 'Alamat toko wajib diisi.',
			'owner_nama.required'	=> 'No pemilik wajib diisi.',
			'owner_ktp_no.required'	=> 'No KTP pemilik wajib diisi.',
			'id_distributor.required'	=> 'Distributor wajib diisi.',
		]);
	}


	public static function purchaseCreateValidation($request)
	{
		$request->validate([
			'id_member'			=> 'required|exists:members,id',
			'invoice_number'	=> 'required|unique:member_purchases,invoice_number',
			'purchased_date'		=> 'required',
			'received_date'		=> 'required',
		], [
			'invoice_number.required'	=> 'No faktur wajib diisi.',
			'invoice_number.unique'		=> 'No faktur sudah pernah diinput',
			'purchased_date.required'	=> 'Tgl pembelian wajib diisi.',
			'received_date.required'	=> 'Tgl terima wajib diisi.',
		]);
	}


	public static function purchaseAddItemValidation($request)
	{
		$request->validate([
			'id_member_purchase'	=> 'required|exists:member_purchases,id',
			'product_name'			=> 'required',
			'price'					=> 'required',
			'qty'					=> 'required'
		]);
	}


	public static function visibilityPhotoCreateValidation($request)
	{
		$request->validate([
			'id_member'		=> 'required|exists:members,id',
		]);
	}
}