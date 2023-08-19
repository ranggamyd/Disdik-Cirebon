<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
	
	public function index()
	{
		if(auth()->user()->role == 'Admin') {
			return view('admin.dashboard', [
				'title'	=> 'Dashboard'
			]);
		} else {
			// return redirect('/');
			return view('pemohon.dashboard', [
				'title'	=> 'Dashboard'
			]);
		}
	}


	public function templateImport($filename)
	{
		try {
			$filepath = storage_path('docs/import_templates/'.$filename);
			return response()->download($filepath);
		} catch (\Exception $e) {
			return \Res::error($e);
		}
	}
}
