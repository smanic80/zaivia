<?php

class ZaiviaListings {
	public static $listing_tablename    = "listings";
	public static $features_tablename   = "listing_features";
	public static $files_tablename      = "listing_file";
	public static $openhouse_tablename  = "listing_openhouse";

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

	public static function save($data) {
		global $wpdb;

		$listing_tablename = $wpdb->prefix . self::$listing_tablename;
		$openhouse_tablename = $wpdb->prefix . self::$openhouse_tablename;

		$preparedData = [
			'MLSNumber' => $data['MLSNumber'],
			'sale_rent' => $data['sale_rent'],
			'sale_by' => $data['sale_by'],

			'address' => $data['address'],
			'unit_number' => $data['unit_number'],
			'city' => $data['city'],
			'province' => $data['province'],
			'zip' => $data['zip'],
			'neighbourhood' => $data['neighbourhood'],
			'lat' => $data['lat'],
			'lng' => $data['lng'],

			'price' => $data['price'],
			'property_type' => $data['property_type'],
			'house_type' => $data['house_type'],
			'square_footage' => $data['square_footage'],
			'bedrooms' => $data['bedrooms'],
			'bathrooms' => $data['bathrooms'],

			'roof_type' => $data['roof_type'],
			'exterior_type' => $data['exterior_type'],
			'parking' => $data['parking'],
			'driveway' => $data['driveway'],
			'size_x' => $data['size_x'],
			'size_y' => $data['size_y'],
			'size_units' => $data['size_units'],

			'year_built' => $data['year_built'],
			'annual_taxes' => $data['annual_taxes'],
			'condo_fees' => $data['condo_fees'],
			'partial_rent' => implode(";", $data['partial_rent']),

			'room_features' => serialize($data['room_features']),
			'description' => $data['description'],

			'featured' => $data['featured'],
			'premium' => $data['premium'],
			'url' => $data['url'],
			'bump_up' => $data['bump_up'],

			'status' => $data['status'],
		];

		$dataFormat = [
			'%s', '%d', '%d',
			'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
			'%f', '%s', '%s', '%f', '%d', '%d',
			'%s', '%s', '%s', '%s', '%s', '%s', '%d',
			'%d', '%f', '%f', '%s',
			'%s', '%s',
			'%d', '%d', '%s', '%d',
			'%s', '%d', '%d'
		];

		if((int)$data['listing_id']) {
			$listing_id = (int)$data['listing_id'];

			if(!self::isOwner(get_current_user_id(), $listing_id)) {
				return 'This is not yours!';
			}

			if(isset($data['to_delete'])) {
				$preparedData['to_delete'] = 0;
				$preparedData['date_created'] = time();
				$dataFormat[] = '%d';
				$dataFormat[] = '%d';
			}
			$wpdb->update($listing_tablename, $preparedData, ['listing_id'=>$listing_id], $dataFormat);
			for($i=1; $i<=3; $i++) {
				self::updateFeatures($listing_id, $i, (isset($data["features_{$i}"])?$data["features_{$i}"]:[]), 0);
				self::updateFeatures($listing_id, $i, (isset($data["features_{$i}_custom"])?$data["features_{$i}_custom"]:[]), 1);
			}
			if($data['openhouse']){
                $wpdb->delete( $openhouse_tablename, ['listing_id'=>$listing_id], ["%d"]);
                foreach($data['openhouse'] as $el) {
                    $row = [
                        'listing_id'=>$listing_id,
                        'date' => date('Y-m-d',strtotime($el['openhouse_date[]'])),
                        'start_time'=>date('H:i:s',mktime(0,$el['openhouse_time_start[]'],0)),
                        'end_time'=>date('H:i:s',mktime(0,$el['openhouse_time_end[]'],0))
                    ];
                    $format = ["%d", "%s", "%s", "%s"];
                    $wpdb->insert($openhouse_tablename, $row, $format);
                }
            }

		} else {
			$preparedData['user_id'] = get_current_user_id();
			$preparedData['date_created'] = time();
			$preparedData['activated'] = 0;
			$preparedData['to_delete'] = isset($data['to_delete'])?0:1;

			$dataFormat[] = '%d';
			$dataFormat[] = '%d';
			$dataFormat[] = '%d';
			$dataFormat[] = '%d';

			$wpdb->insert($listing_tablename, $preparedData, $dataFormat);
			$listing_id = $wpdb->insert_id;
		}

		return $listing_id;
	}


	public static function updateFeatures($listing_id, $i, $features, $isCustom){
		global $wpdb;

		$features_tablename = $wpdb->prefix . self::$features_tablename;
		$currentFeatures = self::getListingFeatures($listing_id, $i, $isCustom);

		foreach($currentFeatures as $currentFeature) {
			$key = array_search($currentFeature['feature'], $features);
			if($key !== false) {
				unset($features[$key]);
			} else {
				$wpdb->delete( $features_tablename, ['feature_id'=>$currentFeature['feature_id']], ["%d"]);
			}
		}

		foreach($features as $feature) {
			$data = ['listing_id'=>$listing_id, 'feature_type'=>$i, 'feature_custom'=>$isCustom, 'feature'=>$feature];
			$format = ["%d", "%d", "%d", "%s"];
			$wpdb->insert($features_tablename, $data, $format);
		}

	}


	public static function isOwner($userId, $listingId) {
		return (bool)count(self::getUserListings($userId, $listingId));
	}
	public static function getUserListings($userId, $listingId = null) {
		global $wpdb;

		$listing_tablename = $wpdb->prefix . self::$listing_tablename;

		$sql = "SELECT *, 
					IF(sale_rent = 1, 'For Sale', 'For Rent') as `sale_rent-text`, 
					IF(activated = 1, 'Yes', 'No') as `active-text`,
					 concat(address, ', ', city, ' ', province) as `address-text`
				from $listing_tablename 
				where user_id = ".(int)$userId;
		if($listingId) {
			$sql .= " and listing_id = ".(int)$listingId;
		}

		$results = $wpdb->get_results( $sql,ARRAY_A);
		$results = ($listingId && isset($results[0]))?$results[0]:$results;

		return $results;
	}

	public static function getListingFeatures($listingId, $type = null, $custom = null) {
		global $wpdb;

		$features_tablename = $wpdb->prefix . self::$features_tablename;

		$sql = "SELECT * from $features_tablename where listing_id = ".(int)$listingId;
		if($type) {
			$sql .= " and feature_type = ".(int)$type;
		}
		if($custom) {
			$sql .= " and feature_custom = 1";
		} else {
			$sql .= " and feature_custom != 1";
		}

		$results = $wpdb->get_results( $sql,ARRAY_A);

		return $results;
	}

	public static function getListingFiles($listingId, $type = null) {
		global $wpdb;

		$files_tablename = $wpdb->prefix . self::$files_tablename;

		$sql = "SELECT * from $files_tablename where listing_id = ".(int)$listingId;
		if($type) {
			$sql .= " and file_type = ".(int)$type;
		}

		$results = $wpdb->get_results( $sql,ARRAY_A);

		return $results;
	}

	public static function getListingOpenhouse($listingId) {
		global $wpdb;

		$openhouse_tablename = $wpdb->prefix . self::$openhouse_tablename;

		$sql = "SELECT listing_id,DATE_FORMAT(`date`,'%m/%d/%Y') as `date`,(HOUR(start_time)*60+MINUTE(start_time)) as start_time,(HOUR(end_time)*60+MINUTE(end_time)) as end_time from $openhouse_tablename where listing_id = ".(int)$listingId;

		$results = $wpdb->get_results( $sql,ARRAY_A);

		return $results;
	}
}

