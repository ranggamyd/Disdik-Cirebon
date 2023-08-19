<?php 

/**
 *	Develop by Rohim Wahyudin (adiva)
 *	Manfaat class ini
 *	-> Mendapatkan nama bulan & hari dalam bahasa indonesia
 *	-> Formating ke penanggalan indonesia
 *	-> Hitung selisih hari dari 2 tgl
 * 
 * 	@uses Carbon\Carbon from nesbot
 * 
 *	@static string monthName(string|int $param) untuk mendapat nama bulan dari nomor bulan/tgl
 * 	@static string dayName(string|int $param) untuk mendapat nama hari dari nomor bulan/tgl
 * 	@static string fullDate(string $date) untuk mendapat tanggal dalam bahasa indonesi
 * 	@static string fullDateWithDayName(string $date) untuk mendapat tanggal disertai nama hari dalam bahasa indonesia
 * 	@static string fullDateWithTime(string $date) untuk mendapat tanggal disertai waktu (jam:menit) dalam bahasa indonesia
 * 	@static string fullDateWithDayNameAndTime(string $date) untuk mendapat tanggal disertai hari dan waktu (jam:menit) dalam bahasa indonesia
 * 	@static string monthNameAndYear(string $date) untuk mendapat nama bulan dan tahun dalam bahasa indonesia
 * 	@static string diffInDays(string $date1, string $date2) untuk mendapat selisih hari dari 2 tgl
 * 	@static string amountOfDays(string $date1, string $date2) untuk mendapat jumlah hari dari 2 tgl
 * 	@static array dateInRange(string $start, string $end) untuk mendapat daftar tgl dari rentang 2 tgl
 * */


namespace App\MyClass;

class Date
{

	/**
	*	Mendapat nama bulan
	*	@param $param angka bulan / tgl
	* 	@example jika input 2021-09-09 => September
	* 	@example jika input 8 => Agustus
	* 	@example jika input null => (nama bulan pada saat itu)
	*/
	public static function monthName($param = null)
	{
		if(empty($param)) $param = (int) date('n');

		if(!is_numeric($param)) {
			if(str_contains($param, '-') || str_contains($param, '/')) {
				$param = date('n', strtotime($param));
			}
		}

		$param = (int) $param;
		while($param > 12) $param -= 12;

		return self::monthNameList($param);
	}


	/**
	*	Mendapat nama hari
	*	@param $param. example :
	*	@example jika input 2021-09-09 => 'Kamis'
	*	@example jika input 4 => 'Kamis'
	*	@example jika input null => (nama hari saat ini)
	*/
	public static function dayName($param = null)
	{
		if(empty($param)) $param = (int) date('N');

		if(!is_numeric($param)) {
			if(str_contains($param, '-') || str_contains($param, '/')) {
				$param = date('N', strtotime($param));
			}
		}

		$param = (int) $param;
		while($param > 7) $param -= 7;

		return self::dayNameList($param);
	}


	public static function fullDate($date = null)
	{
		if(empty($date)) $date = date('Y-m-d');

		$dateText = self::tt($date, 'j')." ".self::monthName($date)." ".self::tt($date, 'Y');

		return $dateText;
	}


	public static function fullDateWithDayName($date = null)
	{
		if(empty($date)) $date = date('Y-m-d');

		$dateText = self::dayName($date).", ";
		$dateText .= self::fullDate($date);

		return $dateText;
	}


	public static function fullDateWithTime($date = null)
	{
		if(empty($date)) $date = date('Y-m-d');

		$dateText = self::fullDate($date);
		$dateText .= " ".date('H:i', strtotime($date));

		return $dateText;
	}


	public static function fullDateWithDayNameAndTime($date = null)
	{
		if(empty($date)) $date = date('Y-m-d');

		$dateText = self::dayName($date).", ";
		$dateText .= self::fullDate($date);
		$dateText .= " ".date('H:i', strtotime($date));

		return $dateText;
	}


	public static function monthNameWithYear($date = null)
	{
		if(empty($date)) $date = date('Y-m-d');

		return self::monthName($date).' '.date('Y', strtotime($date));
	}


	public static function diffInDays($date1, $date2)
	{
		$date1 = self::toCarbon($date1);
		$date2 = self::toCarbon($date2);
		$diff = $date1->diffInDays($date2);

		return (int) $diff;
	}

	public static function amountOfDays($date1, $date2)
	{
		return self::diffInDays($date1, $date2) + 1;
	}


	public static function toCarbon($date)
	{
		return new \Carbon\Carbon($date);
	}


	public static function tt($date, $format = 'Y-m-d')
	{
		return date($format, strtotime($date));
	}

	private static function dayNameList($dayNumber)
	{
		$dayNameList = [ 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu', 'Minggu' ];

		return $dayNameList[(int) $dayNumber - 1];
	}

	private static function monthNameList($monthNumber)
	{
		$monthNameList = [ 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September','Oktober', 'November', 'Desember' ];

		return $monthNameList[(int) $monthNumber - 1];
	}


	public static function dateInRange($start, $end)
	{
		$results = [];
		$date = $start;

		while ($date <= $end) {
			$results[] = $date;
			$date = self::toCarbon($date);
			$date->addDays(1);
			$date = $date->format('Y-m-d');
		}

		return $results;
	}


}