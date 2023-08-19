<?php

/**
 *	Develop by Rohim Wahyudin (adiva)
 *	Manfaat class ini
 *	-> Mempermudah penghitungan jarak antara 2 lokasi
 *	-> Mendapatkan hasil geolocation (detail lokasi)
 *	-> Generate gmaps link
 *	-> Generate embedded map untuk ditampilkan
 * 
 *	@static static Location make(string $latitude, string $longitude) untuk membuat instance
 *	@method double distance(Location $location) untuk menghitung jarak 2 lokasi dalam satuan meter
 *	@method double distanceInMeters(Location $location) untuk menghitung jarak 2 lokasi dalam satuan meter
 *	@method double distanceInKilometers(Location $location) untuk menghitung jarak 2 lokasi dalam satuan kilometer
 *	@method double distanceInMiles(Location $location) untuk menghitung jarak 2 lokasi dalam satuan mil
 * 	@method string gmapsLink() untuk mendapat url gmaps
 * 	@method string embeddedMap(int|string|null $width, int|string|null $height) untuk mendapat html map
 * 	@method array geocode() untuk mendapat detail lokasi
 * */

namespace App\MyClass;

class Location
{
	public $latitude;
	public $longitude;

	public $earthRadiusInMeters = 6371000;
	public $earthRadiusInKilometers = 6371;
	public $earthRadiusInMiles = 3958.8;

	private $geolocationAPIKey = null;
	private $geolocationAPIURL = 'https://maps.googleapis.com/maps/api/geocode/json';



	/**
	*	Constructor
	*	@param int/double $lat => Latitude
	*	@param int/double $long => Longitude
	*	@param string|null $apiKey => API Key For Using Google API
	*/
	public function __construct($lat, $long, $apiKey = null)
	{
		$this->latitude = $lat;
		$this->longitude = $long;

		if(!empty($apiKey)) {
			$this->geolocationAPIKey = $apiKey;
		}
	}


	/**
	*	Make instance
	*	@param int/double $lat => Latitude
	*	@param int/double $long => Longitude
	*	@param string $apiKey => API Key For Using Google API
	*	@return Coordinate instance
	*/
	public static function make($lat, $long, $apiKey = null)
	{
		return new self($lat, $long, $apiKey);
	}



	/**
	*	Counting distance with other coordinates
	*	@param Location $location => other instance
	*	@param int/double/null => $earthRadius
	*	@return double => distance in meters (if $earthDistance is null)
	*/
	public function distance(Location $location, $earthRadius = null)
	{
		if(empty($earthRadius)) $earthRadius = $this->earthRadiusInMeters;

		$latFrom = deg2rad($this->latitude);
		$lonFrom = deg2rad($this->longitude);
		$latTo = deg2rad($location->latitude);
		$lonTo = deg2rad($location->longitude);

		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;

		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		return $angle * $earthRadius;
	}


	/**
	*	Counting distance with other coordinates in meters
	*	@param Location $location => other instance
	*	@return double => distance in meters
	*/
	public function distanceInMeters(Location $location)
	{
		$distance = $this->distance($location, $this->earthRadiusInMeters);
		$distance = round($distance, 3);

		return $distance;
	}


	/**
	*	Counting distance with other coordinates in kilometers
	*	@param Location $location => other instance
	*	@return double => distance in kilometers
	*/
	public function distanceInKilometers(Location $location)
	{
		$distance = $this->distance($location, $this->earthRadiusInKilometers);
		$distance = round($distance, 3);

		return $distance;
	}


	/**
	*	Counting distance with other coordinates in miles
	*	@param Location $location => other instance
	*	@return double => distance in miles
	*/
	public function distanceInMiles(Location $location)
	{
		$distance = $this->distance($location, $this->earthRadiusInMiles);
		$distance = round($distance, 3);

		return $distance;
	}


	/**
	*	Make gmaps link
	*	@return string => gmaps link
	*/
	public function gmapsLink()
	{
		return "http://www.google.com/maps/place/{$this->latitude},{$this->longitude}";
	}



	/**
	 * 	GEOLOCATION
	 * */


	/**
	 * 	Location Type
	 *	@see list konversi lokasi google
	 * 	@return array
	 * */
	private static function locationType()
	{
		return [
			"street_number"					=> "streetNumber",
			"route"							=> "streetName",
			"administrative_area_level_4"	=> "village",
			"administrative_area_level_3"	=> "subdistrict",
			"administrative_area_level_2"	=> "city",
			"administrative_area_level_1"	=> "province",
			"country"						=> "country",
			"postal_code"					=> "postalCode",
		];
	}

	/**
	 * 	Request Geolocation
	 *	@see request data geolokasi / detail lokasi seperti nama jalan, kota, provinsi dll
	 * 	@return array
	 * */
	public function geocode()
	{
		try {
			$result = $this->sendRequest();
				
			return $this->parseGeocode($result);
		} catch (\Exception $e) {
			return $e->getMessage();
			return $this->defaultGeocode();
		}
	}

	/**
	 * 	Parse Request Geolocation
	 *	@see parsing hasil request
	 * 	@return array
	 * */
	private function parseGeocode($rawData)
	{
		$fullAddress = '';
		$detailAddress = '';
		$geometry = '';
		$placeId = '';
		$plusCode = '';

		$data = json_decode($rawData, true);
		$data = $data['results'][0];
		$components = $data['address_components'];
		$location = [];
		foreach($components as $d)
		{
			$locationType = self::locationType();
			$able = 1;
			foreach($locationType as $locKey => $locVal)
			{
				if($able == 1)
				{
					if(in_array($locKey, $d['types']))
					{
						$location[$locVal] = $d['long_name'];
						$able = 0;
					}
				}
			}
		}
			
		$fullAddress = $data['formatted_address'];
		$detailAddress = $location;
		$geometry = $data['geometry']['location'];
		$placeId = $data['place_id'];
		$plusCode = $data['plus_code'];

		$result = [
			'fullAddress'	=> $fullAddress,
			'detailAddress'	=> $detailAddress,
			'geometry'		=> $geometry,
			'placeId'		=> $placeId,
			'plusCode'		=> $plusCode,
		];

		return $result;
	}

	/**
	 * 	Default Geolocation
	 *	@see default jika request geolocation gagal
	 * 	@return array
	 * */
	private function defaultGeocode()
	{
		return [
			"fullAddress"	=> "Nama Jalan No. 0, Kelurahan, Kecamatan, Kota, Provinsi, Negara Kode Pos",
			"detailAddress"	=> [
				"streetNumber"	=> 'No Jalan',
				"streetName"	=> "Nama Jalan",
				"village"		=> "Kelurahan",
				"subdistrict"	=> "Kecamatan",
				"city"			=> "Kota",
				"province"		=> "Provinsi",
				"country"		=> "Negara",
				"postalCode"	=> "Kode Pos",
			],
			"geometry"	=> [
				'lat'	=> $this->latitude,
				'lng'	=> $this->longitude,
			],
			'placeId'	=> "ID",
			'plusCode'	=> [
				'compound_code'	=> "Code",
				'global_code'	=> "Code",
			],
		];
	}

	/**
	 * 	Proses Request
	 *	@see proses request ke api google
	 * 	@return array
	 * */
	private function sendRequest()
	{
		$params = "latlng={$this->latitude},{$this->longitude}&sensor=true&key=".$this->geolocationAPIKey;
		$ch = curl_init(); 
	    curl_setopt($ch, CURLOPT_URL, $this->geolocationAPIURL."?".$params);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	    $result = curl_exec($ch); 
	    curl_close($ch);      
	    return $result;
	}


	/**
	 * 	Membuat html map
	 *	@param string|int|null $width => $lebar
	 *	@param string|int|null $height => $tinggi
	 * 	@return string
	 * */
	public function embeddedMap($width = null, $height = null)
	{
		if(empty($width)) $width = '100%';
		if(empty($height)) $height = '300';

		$url = "https://maps.google.com/maps?q={$this->latitude},{$this->longitude}&hl=id&z=14&amp;output=embed";
		return "<iframe 
			width='{$width}' 
			height='{$height}' 
			frameborder='0' 
			scrolling='no' 
			marginheight='0' 
			marginwidth='0' 
			src='{$url}'>
		 </iframe>";
	}

	/**
	 * 	Alamat lengkap
	 * 	@return string
	 * */
	public function fullAddress()
	{
		if(!$this->geolocationAPIKey) return $this->defaultGeocode()['fullAddress'];
		return $this->geocode()['fullAddress'];
	}
}