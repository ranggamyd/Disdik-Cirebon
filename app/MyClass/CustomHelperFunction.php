<?php

/**
 *	Develop by Rohim Wahyudin (adiva)
 *	Helper function
 *	-> Mengambil setting
 * 	-> Menyimpan setting
 * 	-> Mengambil data employee untuk user karyawan
 * 	-> Mengambil data config
 * 
 *	@method any|null setting(string $key, any|null $default) untuk mengambil setting
 *	@method Setting saveSetting(string $key, any $default) untuk menyimpan setting
 * 	@method Employee employee() untuk mengambil setting untuk user karyawan
 * 	@method any|null appconfig(string $key, any|null $default) untuk mengambil config
 * */


	function setting($key, $default = null)
	{
		return \Setting::getValue($key, $default);
	}

	function saveSetting($key, $value)
	{
		return \Setting::setValue($key, $value);
	}

	function saveSettings($settings)
	{
		return \Setting::setValues($settings);
	}

	function user()
	{
		return auth()->user();
	}

	function location($lat, $long)
	{
		return \App\MyClass\Location::make($lat, $long);
	}

?>