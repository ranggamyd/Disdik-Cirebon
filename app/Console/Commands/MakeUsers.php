<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeUsers extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'app:make_users';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Membuat user bawaan';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		$user = User::where('role', User::ROLE_SUPER_ADMIN)->first();
		if(!$user) {
			User::create([
				'name'		=> 'Super Admin',
				'username'	=> 'super',
				'password'	=> \Hash::make('pass'),
				'role'		=> User::ROLE_SUPER_ADMIN,
			]);
		}

		$user = User::where('role', User::ROLE_ADMIN)->first();
		if(!$user) {
			User::create([
				'name'		=> 'Admin',
				'username'	=> 'admin',
				'password'	=> \Hash::make('pass'),
				'role'		=> User::ROLE_ADMIN,
			]);
		}

		// $user = User::where('role', User::ROLE_WARGA)->first();
		// if(!$user) {
		// 	User::create([
		// 		'name'		=> 'Warga',
		// 		'username'	=> 'warga',
		// 		'password'	=> \Hash::make('pass'),
		// 		'role'		=> User::ROLE_WARGA,
		// 	]);
		// }
	}
}
