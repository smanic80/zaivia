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
	public static $posttype_discount = "cart_discount";

	public static $listing_tablename    = "listings";
	public static $features_tablename   = "listing_features";
	public static $files_tablename      = "listing_file";   /* type 1-image, 2-blueprint, 3-rent, 4-profile    */
	public static $openhouse_tablename  = "listing_openhouse";
	public static $rent_tablename       = "listing_rent";
	public static $contact_tablename    = "listing_contact";
	public static $geo_tablename        = "listing_geo";
	public static $search_tablename     = "listing_saved_search";

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

	public static function validateCoupon($couponCode, $userId) {
		$coupon = get_page_by_title($couponCode, ARRAY_A, self::$posttype_discount);
		if(!$coupon) {
			return __("Promo Code not found");
		}

		$couponId = $coupon['ID'];

		$valid_untill = get_field("coupon_valid_untill", $couponId);
		if($valid_untill && strtotime($valid_untill) <= time()) {
			return __("Promo Code expired");
		}

		$usage_total = (int)get_field("coupon_usage_total", $couponId);
		if($usage_total && ($usage_total - (int)get_post_meta("used", $couponId, true)) <= 0) {
			return __("Number of usage this Promo Code exeeded");
		}

		$usage_per_user = (int)get_field("coupon_usage_per_user", $couponId);
		if($usage_per_user && ($usage_per_user - (int)get_post_meta("used_".$userId, $couponId, true)) <= 0) {
			return __("Number of usage this Promo Code by you exeeded");
		}

		return $couponId;
	}

	public static function setCoupon($entityId, $entityType, $couponId=null){
		if($entityType === "business") {
			delete_post_meta($entityId, "used_coupon");
			if($couponId) {
				return add_post_meta($entityId, "used_coupon", $couponId);
			}

			return true;
		} else {
			global $wpdb;
			$listing_tablename = $wpdb->prefix . self::$listing_tablename;
			return $wpdb->update( $listing_tablename, ["used_coupon"=>$couponId], ["listing_id"=>$entityType], ["%d"], ["%d"]);
		}
	}

	public static function applyCoupon($couponId, $sum){
		$coupon_amount = $couponId ? get_field("coupon_amount", $couponId) : 0;
		$coupon_type = $couponId ? get_field("coupon_type", $couponId): 0;

		if($coupon_type === 'percent') {
			$coupon_amount = ($sum * $coupon_amount / 100);
		}
		$sum -= $coupon_amount;

		return ["sum"=>$sum, "coupon_amount"=>$coupon_amount, "coupon_name"=>acf_get_post_title($couponId)];
	}

	public static function getUserItem($entityId, $type){
		$userId = get_current_user_id();

		if($type === 'listing') {
			$item = ZaiviaListings::getListings( $entityId, $userId );
		} else {
			$postType = get_post_type($entityId);
			$item = ZaiviaBusiness::getEntities($postType, $entityId, $userId);
		}

		return $item;
	}

	public static function maintenance(){
		global $wpdb;

		$search_tablename = $wpdb->prefix . self::$search_tablename;
		$now = time();
		$disabled_cards = $disabled_banners = [];
		//get expired banners and cards
		$args = [
			'post_type' => [self::$posttype_card, self::$posttype_banner],
			'post_status' => 'publish',
			'nopaging' => true,
			'meta_query' => [
				[
					'key' => 'date_renewal',
					'value' => $now,
					'meta_compare' => '<='
				],
			],
		];
		$items = get_posts($args);
		foreach($items as $item) {
			$itemId = $item->ID;
			$type = get_post_type($itemId);

			if($type === ZaiviaBusiness::$posttype_banner) {
				//unpublish expired banners
				delete_post_meta($itemId, "date_renewal");
				wp_update_post(['ID'=>$itemId, 'post_status'=>'draft']);

				$disabled_banners[] = $itemId;
			} else {
				$keys = ["card_sponsor_date", "card_url_show_date", "card_featured_date"];
				$dates = ZaiviaBusiness::calculateEndDate($itemId, 0, $keys);

				//remove expireied features from cards
				foreach ( $dates as $key => $date ) {
					if ( $date <= $now ) {
						delete_post_meta( $itemId, $key );
					} else {
						update_post_meta( $itemId, $key, $date );
					}
				}

				$disabled_cards[] = $itemId;
			}
		}
		echo '<pre>';
		print_r([
			"disabled banners"=>implode(", ", $disabled_banners),
			"disabled cards"=>implode(", ", $disabled_cards)
		]);
		die;
		//send email with serach results
		/*$sql = "select * from {$search_tablename}";
		$searches = $wpdb->get_results( $sql, ARRAY_A);
		foreach($searches as $search) {
			$search = json_decode($search["search_request"]);
			$listings = ZaiviaListings::searchListings($search);
			foreach($listings as $listing) {

			}
		}*/
	}


}
