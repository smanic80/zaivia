<?php
/**
 * Created by PhpStorm.
 * User: KDM
 * Date: 11.03.2018
 * Time: 20:55
 */

class listing_base {
	public static $posttype_card = "contact-card";
	public static $posttype_banner = "banner";

	public static $listing_tablename    = "listings";
	public static $features_tablename   = "listing_features";
	public static $files_tablename      = "listing_file";   /* type 1-image, 2-blueprint, 3-rent, 4-profile    */
	public static $openhouse_tablename  = "listing_openhouse";
	public static $rent_tablename       = "listing_rent";
	public static $contact_tablename    = "listing_contact";
	public static $geo_tablename        = "listing_geo";


	public static $provinces = [
		"BC" => "British Columbia",
		"ON" => "Ontario",
		"NF" => "Newfoundland",
		"NS" => "Nova Scotia",
		"PE" => "Prince Edward Island",
		"NB" => "New Brunswick",
		"QC" => "Quebec",
		"MB" => "Manitoba",
		"SK" => "Saskatchewan",
		"AB" => "Alberta",
		"NT" => "Northwest Territories",
		"NU" => "Nunavut",
		"YT" => "Yukon Territory"
	];

	public static $time = [
		480=>"8:00",
		510=>"8:30",
		540=>"9:00",
		570=>"9:30",
		600=>"10:00",
		630=>"10:30",
		660=>"11:00",
		690=>"11:30",
		720=>"12:00",
		750=>"12:30",
		780=>"13:00",
		810=>"13:30",
		840=>"14:00",
		870=>"14:30",
		900=>"15:00",
		930=>"15:30",
		960=>"16:00",
		990=>"16:30",
		1020=>"17:00",
		1050=>"17:30",
		1080=>"18:00",
		1110=>"18:30",
		1140=>"19:00",
		1170=>"19:30",
		1200=>"20:00",
	];

	public static function formatDate($date) {
		if(!$date || is_array($date)) return "";

		if(is_numeric($date)) return date("M j, Y ", $date);

		$d = new DateTime($date);
		return $d->format("M j, Y ");
	}
	public static function formatMoney($var, $dec = 0) {
		return "$" . number_format((float)$var, $dec);
	}

	public static function formatPhone($var) {
		$var = preg_replace("/[^\d]/","",$var);
		$length = strlen($var);
		if($length == 10) {
			$var = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $var);
		}

		return $var;
	}

	protected static function getGeoRadiusSql($centerLat, $centerLng, $radius=0){
		$sql = '( ( 6971 * acos( cos( radians(' . $centerLat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $centerLng . ') ) + sin( radians(' . $centerLat . ') ) * sin(radians(lat)) ) )';
		if($radius)  $sql .= ' < ' . intval($radius);
		$sql .= ')';
		return $sql;
	}

	protected static function getCityCoords($city){
		if(!$city) return false;

		$cleanCity = sanitize_key($city);

		$geo = get_transient("geo_".$cleanCity);
		if(!$geo) {
			$geo = file_get_contents('http://geogratis.gc.ca/services/geoname/en/geonames.json?concise=CITY,TOWN&sort-field=name&q='.urlencode($city));
			$geo = @json_decode($geo, true);

			if($geo) {
				if(count($geo['items'])) {
					$geo = ['lat'=> $geo['items'][0]['latitude'], 'lng' => $geo['items'][0]['longitude'] ];
					set_transient("geo_".$cleanCity, $geo, 24 * HOUR_IN_SECONDS * 30 * 30);
				} else {
					$geo = null;
				}
			}

		}

		return $geo;
	}

	public function maintenance(){
		//unpublish expired banners
		$args = [
			'post_type' => self::$posttype_banner,
			'post_status' => 'publish',
			'nopaging' => true,
		];
		$items = get_posts($args);
		foreach($items as $item) {

		}


		//unpromote expired card and listing items - clear flag and date field


		//send email with serach results
	}

}