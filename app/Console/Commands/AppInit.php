<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppInit extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'app:init';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Inisialisasi Aplikasi';

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
		$this->createAdminUser();
	}


	public function createAdminUser()
	{
		$this->line('Membuat user admin..');
		
		\Artisan::call('app:make_users');
		
		$this->info('[v] Berhasil');
	}
}
