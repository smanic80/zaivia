<?php

class ZaiviaListings {
	public static $listing_tablename    = "listings";
	public static $features_tablename   = "listing_features";
	public static $files_tablename      = "listing_file";   /* type 1-image, 2-blueprint, 3-rent, 4-profile    */
	public static $openhouse_tablename  = "listing_openhouse";
	public static $rent_tablename       = "listing_rent";
	public static $contact_tablename    = "listing_contact";

	public static $for_rent = 0;
	public static $for_sale = 1;

	public static $file_image = 1;
	public static $file_blueprint = 2;
	public static $file_rent = 3;
	public static $file_profile = 4;
	public static $file_logo = 5;

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



	public static function getUserListings($userId, $listingId = null) {
		global $wpdb;

		$listing_tablename = $wpdb->prefix . self::$listing_tablename;

		$sql = "SELECT *, 
					IF(sale_rent = ".self::$for_sale.", 'For Sale', 'For Rent') as `sale_rent-text`, 
					IF(activated = 1, 'Yes', 'No') as `active-text`,
					 concat(address, ', ', city, ' ', province) as `address-text`
				from $listing_tablename 
				where user_id = ".(int)$userId;
		if($listingId) {
			$sql .= " and listing_id = ".(int)$listingId;
		} else {
			$sql .= " and deleted = 0 and to_delete != 1";
		}

		$results = $wpdb->get_results( $sql,ARRAY_A);
		foreach($results as $key=>$val) {
			$results[$key]['partial_rent'] = explode(";", $val['partial_rent']);
			$results[$key]['room_features'] = unserialize($val['room_features']);

			for($i=1; $i<=3; $i++) {
				$featuresArray = [];
				$features = self::getListingFeatures($listingId, $i, 0);
				foreach($features as $feature) {
					$featuresArray[] = $feature['feature'];
				}
				$results[$key]["features_{$i}"] = $featuresArray;

				$featuresArray = [];
				$features = self::getListingFeatures($listingId, $i, 1);
				foreach($features as $feature) {
					$featuresArray[] = $feature['feature'];
				}
				$results[$key]["features_{$i}_custom"] = $featuresArray;
			}

		}
		$results = ($listingId && isset($results[0]))?$results[0]:$results;

		return $results;
	}

    public static function getListing($listingId) {
        global $wpdb;

        $listing_tablename = $wpdb->prefix . self::$listing_tablename;

        $sql = "SELECT *, 
					IF(sale_rent = ".self::$for_sale.", 'For Sale', 'For Rent') as `sale_rent-text`, 
					IF(activated = 1, 'Yes', 'No') as `active-text`,
					 concat(address, ', ', city, ' ', province) as `address-text`
				from $listing_tablename 
				where listing_id = ".(int)$listingId;

        $results = $wpdb->get_results( $sql,ARRAY_A);
        if(isset($results[0])){
            $results[0]['partial_rent'] = explode(";", $results[0]['partial_rent']);
            $results[0]['room_features'] = unserialize($results[0]['room_features']);

            for($i=1; $i<=3; $i++) {
                $featuresArray = [];
                $features = self::getListingFeatures($listingId, $i, 0);
                foreach($features as $feature) {
                    $featuresArray[] = $feature['feature'];
                }
                $results[0]["features_{$i}"] = $featuresArray;

                $featuresArray = [];
                $features = self::getListingFeatures($listingId, $i, 1);
                foreach($features as $feature) {
                    $featuresArray[] = $feature['feature'];
                }
                $results[0]["features_{$i}_custom"] = $featuresArray;
            }
            $results[0]['rent'] = self::getListingRent($listingId);
            $results[0]['images'] = self::getListingFiles($listingId,self::$file_image,1,false);
            $results[0]['blueprint'] = self::getListingFiles($listingId,self::$file_blueprint,1,false);
        }
        return $results[0];
    }

	public static function saveListing($data) {
		global $wpdb;

		$listing_tablename = $wpdb->prefix . self::$listing_tablename;

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

		if((int)$data['listing_id']) {
			$listingId = (int)$data['listing_id'];

			if(!self::isOwner(get_current_user_id(), $listingId)) {
				return 'This is not yours!';
			}

			$listing = self::getUserListings(get_current_user_id(), $listingId);
			if($listing['to_delete'] === '1' && isset($data['to_delete'])) {
				$preparedData['to_delete'] = 0;
				$preparedData['date_created'] = date('Y-m-d H:i:s', time());
			}

			$wpdb->update($listing_tablename, $preparedData, ['listing_id'=>$listingId]);

			for($i=1; $i<=3; $i++) {
				self::updateListingFeatures($listingId, $i, (isset($data["features_{$i}"])?$data["features_{$i}"]:[]), 0);
				self::updateListingFeatures($listingId, $i, (isset($data["features_{$i}_custom"])?$data["features_{$i}_custom"]:[]), 1);
			}

			self::updateListingOpenhouse( $listingId, (isset($data['openhouse'])?$data['openhouse']:null) );
			self::updateListingRent( $listingId, $data );
			self::updateImagesData( $listingId, $data );


		} else {
			if(isset($data['to_delete'])) {
				$preparedData['to_delete'] = 0;
				$preparedData['date_created'] = date('Y-m-d H:i:s', time());
			}

			$preparedData['user_id'] = get_current_user_id();
			$preparedData['activated'] = 0;

			$wpdb->insert($listing_tablename, $preparedData);
			$listingId = $wpdb->insert_id;

		}

		$res = self::updateListingContact( $listingId, $data );
		$res['listing_id'] = $listingId;

		return $res;
	}

	public static function duplicateListing($listing_from, $listing_to) {
		$listing = self::getUserListings(get_current_user_id(), $listing_from);

		$listing = array_merge($listing, self::getListingRent($listing_from));
		$listing = array_merge($listing, self::getListingContact($listing_from));

		$listing['listing_id'] = $listing_to;
		unset($listing['to_delete']);

		$listing = array_merge($listing, self::saveListing($listing));

		return $listing;
	}

	public static function activateListing($listingId){
		global $wpdb;
		$files_tablename = $wpdb->prefix . self::$listing_tablename;

		$preparedData = [
			'activated'=>1,
			'date_published' => date('Y-m-d H:i:s', time()),
		];

		$listing = self::getUserListings(get_current_user_id(), $listingId);
		if($listing['to_delete'] === '1') {
			$preparedData['to_delete'] = 0;
			$preparedData['date_created'] = date('Y-m-d H:i:s', time());
		}

		return (bool) $wpdb->update($files_tablename, $preparedData, ['listing_id' => $listingId]);
	}





	public static function updateImagesData($listingId, $data){
        global $wpdb;
        $files_tablename = $wpdb->prefix . self::$files_tablename;
        foreach ($data['prop_img'] as $key=>$el){
            $wpdb->update($files_tablename, ['confirmed'=>1,'pos'=>$key], ['listing_id' => $listingId,'file_id' => $el], ['%d'], ['%d','%d']);
        }
        foreach ($data['prop_blue'] as $key=>$el){
            $wpdb->update($files_tablename, ['confirmed'=>1,'pos'=>$key], ['listing_id' => $listingId,'file_id' => $el], ['%d'], ['%d','%d']);
        }
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

	public static function updateListingFeatures($listingId, $type, $features, $isCustom){
		global $wpdb;

		$features_tablename = $wpdb->prefix . self::$features_tablename;
		$currentFeatures = self::getListingFeatures($listingId, $type, $isCustom);

		foreach($currentFeatures as $currentFeature) {
			$key = array_search($currentFeature['feature'], $features);
			if($key !== false) {
				unset($features[$key]);
			} else {
				$wpdb->delete( $features_tablename, ['feature_id'=>$currentFeature['feature_id']], ["%d"]);
			}
		}

		foreach($features as $feature) {
			$data = ['listing_id'=>$listingId, 'feature_type'=>$type, 'feature_custom'=>$isCustom, 'feature'=>$feature];
			$format = ["%d", "%d", "%d", "%s"];
			$wpdb->insert($features_tablename, $data, $format);
		}

	}







	public static function getListingRent($listingId) {
		global $wpdb;

		$rent_tablename = $wpdb->prefix . self::$rent_tablename;

		$sql = "SELECT * from $rent_tablename where listing_id = ".(int)$listingId;

		$results = $wpdb->get_results( $sql,ARRAY_A);
		if(count($results)){
			$results[0]['rent_utilities'] = explode(';',$results[0]['rent_utilities']);
			$results[0]['rent_date'] = ($results[0]['rent_date']!='0000-00-00')?date('m/d/Y',strtotime($results[0]['rent_date'])):'';
			$results[0]['rent_file'] = ZaiviaListings::getListingFiles($listingId, ZaiviaListings::$file_rent);
			return $results[0];
		}
		return [];
	}

	public static function updateListingRent($listingId, $data){
		global $wpdb;

		$rent_tablename = $wpdb->prefix . self::$rent_tablename;
		$files_tablename = $wpdb->prefix . self::$files_tablename;

		if((int)$data['sale_rent'] === self::$for_sale) {
			$wpdb->delete( $rent_tablename, ['listing_id'=>$listingId], ["%d"]);
			$wpdb->delete( $files_tablename, ['listing_id'=>$listingId, "file_type"=>self::$file_rent], ["%d"]);
			return true;
		}

		$anyData = intval( $data['rent_furnishings'].$data['rent_pets'].$data['rent_smoking'].$data['rent_laundry'].$data['rent_electrified_parking'].$data['rent_secured_entry'].$data['rent_private_entry'].$data['rent_onsite'] );

		if($anyData || $data['rent_date'] || $data['rent_deposit'] || $data['rent_utilities'] ) {
			$rent = [
				'rent_date' => $data['rent_date'] ? date('Y-m-d', strtotime($data['rent_date'])) : '',
				'rent_deposit' => $data['rent_deposit'],
				'rent_furnishings' => $data['rent_furnishings'],
				'rent_pets' => $data['rent_pets'],
				'rent_smoking' => $data['rent_smoking'],
				'rent_laundry' => $data['rent_laundry'],
				'rent_electrified_parking' => $data['rent_electrified_parking'],
				'rent_secured_entry' => $data['rent_secured_entry'],
				'rent_private_entry' => $data['rent_private_entry'],
				'rent_onsite' => $data['rent_onsite'],
				'rent_utilities' => implode(';', $data['rent_utilities'])
			];

			$sql = "SELECT * from {$rent_tablename} where listing_id = " . (int)$listingId;
			$results = $wpdb->get_results($sql, ARRAY_A);

			if (count($results)) {
				$wpdb->update($rent_tablename, $rent, ['listing_id' => $listingId]);
			} else {
				$rent['listing_id'] = $listingId;
				$wpdb->insert($rent_tablename, $rent);
			}
		}

		if((int)$data['rent_file']) {
			$files = self::getListingFiles($listingId, self::$file_rent, 1, false);
			$fileId = (int)$data['rent_file'];

			foreach($files as $file) {
				if((int)$file['file_id'] !== $fileId) {
					self::deleteListingFile($file);
				}
			}
			$wpdb->update($files_tablename, ['confirmed' => 1], ['file_id' => (int)$data['rent_file']]);

			$files = self::getListingFiles($listingId, self::$file_rent, 0, false);
			foreach($files as $file) {
				self::deleteListingFile($file);
			}
		} else {
			$files = self::getListingFiles($listingId, self::$file_rent, null, false);
			foreach($files as $file) {
				self::deleteListingFile($file);
			}
		}

		return true;
	}






	public static function getListingOpenhouse($listingId) {
		global $wpdb;

		$openhouse_tablename = $wpdb->prefix . self::$openhouse_tablename;

		$sql = "SELECT listing_id, 
					DATE_FORMAT(`date`,'%m/%d/%Y') as `date`, 
					(HOUR(start_time)*60+MINUTE(start_time)) as start_time, 
					(HOUR(end_time)*60+MINUTE(end_time)) as end_time,
					DATE_FORMAT(`date`,'%W, %M %d') as src_date, 
					DATE_FORMAT(start_time,'%h:%i%p') as src_start_time, 
					DATE_FORMAT(end_time,'%h:%i%p') as src_end_time 
				from $openhouse_tablename where listing_id = ".(int)$listingId;
		$results = $wpdb->get_results( $sql,ARRAY_A);

		return $results;
	}

	public static function updateListingOpenhouse($listingId, $openhouse){
		global $wpdb;

		$openhouse_tablename = $wpdb->prefix . self::$openhouse_tablename;

		$wpdb->delete( $openhouse_tablename, ['listing_id'=>$listingId], ["%d"]);
		if($openhouse){
			foreach($openhouse as $el) {
				$row = [
					'listing_id'=>$listingId,
					'date' => date('Y-m-d',strtotime($el['openhouse_date[]'])),
					'start_time'=>date('H:i:s',mktime(0,$el['openhouse_time_start[]'],0)),
					'end_time'=>date('H:i:s',mktime(0,$el['openhouse_time_end[]'],0))
				];
				$format = ["%d", "%s", "%s", "%s"];
				$wpdb->insert($openhouse_tablename, $row, $format);
			}
		}
	}






	public static function getListingContact($listingId) {
		global $wpdb;

		$contact_tablename = $wpdb->prefix . self::$contact_tablename;

		$sql = "SELECT * from $contact_tablename where listing_id = ".(int)$listingId;
		$results = $wpdb->get_results( $sql,ARRAY_A);

		if(count($results)){
			$results[0]['contact_profile'] = ZaiviaListings::getListingFiles($listingId, ZaiviaListings::$file_profile);;
			$results[0]['contact_logo'] = ZaiviaListings::getListingFiles($listingId, ZaiviaListings::$file_logo);

			return $results[0];
		}
		return [];
	}

	public static function getStoredContact() {
		$data = get_user_meta(get_current_user_id(), "listing_contact", true);

		return $data;
	}


	public static function updateListingContact($listingId, $data){
		global $wpdb;

		$contact_tablename = $wpdb->prefix . self::$contact_tablename;
		$files_tablename = $wpdb->prefix . self::$files_tablename;

		$rent = [
			'contact_name' => $data['contact_name'],
			'contact_name_show' => $data['contact_name_show'],
			'contact_email' => $data['contact_email'],
			'contact_phone1' => $data['contact_phone1'],
			'contact_phone1_type' => $data['contact_phone1_type'],
			'contact_phone1_show' => $data['contact_phone1_show'],
			'contact_phone2' => $data['contact_phone2'],
			'contact_phone2_type' => $data['contact_phone2_type'],
			'contact_phone2_show' => $data['contact_phone2_show'],
			'contact_title' => $data['contact_title'],
			'contact_company' => $data['contact_company'],
			'contact_address' => $data['contact_address'],
			'contact_city' => $data['contact_city'],
			'contact_zip' => $data['contact_zip'],
		];



		$sql = "SELECT * from $contact_tablename where listing_id = ".(int)$listingId;
		$results = $wpdb->get_results( $sql,ARRAY_A);
		if(count($results)) {
			$wpdb->update($contact_tablename, $rent, ['listing_id' => $listingId]);
		} else {
			$rent['listing_id'] = $listingId;
			$wpdb->insert($contact_tablename, $rent);
		}

		if(isset($data['contact_profile']) && is_array($data['contact_profile']) && isset($data['contact_profile']['file_id'])) {
			$data['contact_profile'] = $data['contact_profile']['file_id'];
		}
		if(isset($data['contact_logo']) && is_array($data['contact_logo']) && isset($data['contact_logo']['file_id'])) {
			$data['contact_logo'] = $data['contact_logo']['file_id'];
		}

		if((int)$data['contact_profile']) {
			$file = self::getListingFile($data['contact_profile']);
			if((int)$file['listing_id'] !== $listingId) {
				$data['contact_profile'] = self::duplicateListingFile($data['contact_profile'], $listingId);
			}
		}
		if((int)$data['contact_logo']) {
			$file = self::getListingFile($data['contact_logo']);
			if((int)$file['listing_id'] !== $listingId) {
				$data['contact_logo'] = self::duplicateListingFile($data['contact_logo'], $listingId);
			}
		}

        $files = self::getListingFiles($listingId, self::$file_profile,null,false);
        foreach($files as $file) {
            if(intval($data['contact_profile']) == 0 or intval($file['file_id']) !== intval($data['contact_profile'])) {
                self::deleteListingFile($file);
            }
        }

        if((int)$data['contact_profile']) {
            $wpdb->update($files_tablename, ['confirmed' => 1], ['file_id' => (int)$data['contact_profile']]);
        }

        $files = self::getListingFiles($listingId, self::$file_logo,null,false);
        foreach($files as $file) {
            if(intval($data['contact_logo']) == 0 or intval($file['file_id']) !== intval($data['contact_logo'])) {
                self::deleteListingFile($file);
            }
        }
		if((int)$data['contact_logo']) {
			$wpdb->update($files_tablename, ['confirmed' => 1], ['file_id' => (int)$data['contact_logo']]);
		}

		$rent['contact_profile'] = ZaiviaListings::getListingFiles($listingId, ZaiviaListings::$file_profile);
		$rent['contact_logo'] = ZaiviaListings::getListingFiles($listingId, ZaiviaListings::$file_logo);

//		update_user_meta(get_current_user_id(), "listing_contact", $rent);

		return ['contact_profile' => $rent['contact_profile'], 'contact_logo'=>$rent['contact_logo']];
	}








	public static function getListingFiles($listingId, $type = null, $confirmed = 1, $single = true) {
		global $wpdb;

		$files_tablename = $wpdb->prefix . self::$files_tablename;

		$sql = "SELECT * from $files_tablename where listing_id = ".(int)$listingId;

		if($confirmed !== null) {
			$sql .= " and confirmed = ".(int)$confirmed;
		}
		if($type) {
			$sql .= " and file_type = ".(int)$type;
		}
        $sql .= " order by pos";

		$results = $wpdb->get_results($sql, ARRAY_A);
		foreach($results as $key=>$val) {
			$fileUrl = wp_get_attachment_url( $val['media_id']);
			$results[$key]['file_url'] = $fileUrl ;
			$results[$key]['file_name'] = basename($fileUrl);
			$results[$key]['thumb'] = wp_get_attachment_image_url($val['media_id'],'listing-th');
		}
        
		if($single && $results && isset($results[0])) {
			$results = array_shift($results);
		}
        
		return $results;
	}

    public static function getListingFile($id) {
		global $wpdb;

		$files_tablename = $wpdb->prefix . self::$files_tablename;

		$sql = "SELECT * from $files_tablename where file_id = ".(int)$id;

		$results = $wpdb->get_results( $sql,ARRAY_A);
	    $results = count($results)?$results[0]:[];
		if($results){
			$fileUrl = wp_get_attachment_url( $results['media_id']);
			$results['file_url'] = $fileUrl ;
			$results['file_name'] = basename($fileUrl);
			$results['thumb'] = wp_get_attachment_image_url($results['media_id'],'listing-th');
		}

		return $results;
	}


	public static function addListingFile($listingId, $fileKey/* todo: make it not required param */, $type) {
		global $wpdb;

		if ( ! function_exists( 'media_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
		}

		$files_tablename = $wpdb->prefix . self::$files_tablename;

		$mediaId = media_handle_upload($fileKey, 0);

		if(is_wp_error($mediaId)) {
			$results['error'] = "Media creation error";
		} else {
			$filename = basename(get_attached_file( $mediaId));
            $fileurl = wp_get_attachment_url($mediaId);
            
			$data = [
				'listing_id' => $listingId,
				'media_id' => $mediaId,
				'file_type' => $type
			];

			$results = $wpdb->insert($files_tablename, $data);

			if($results) {
				$results = ['id' => $wpdb->insert_id, 'media_id'=>$mediaId, 'name' => $filename, 'url' => $fileurl];
			} else {
				$results['error'] = "DB error";
			}
		}

		return $results;
	}

	public static function duplicateListingFile($fileId, $listingId){
		global $wpdb;

		$files_tablename = $wpdb->prefix . self::$files_tablename;

		$file = self::getListingFile($fileId);
		$file['listing_id'] = $listingId;
		$file['confirmed'] = 0;

		unset($file['file_id']);
		unset($file['thumb']);
		unset($file['file_name']);
		unset($file['file_url']);

		$results = $wpdb->insert($files_tablename, $file);
		$res = $results ? $wpdb->insert_id : 0;

		return $res;
	}

	public static function deleteListing($listing_id, $reason = '') {
		global $wpdb;
        $listing_tablename = $wpdb->prefix . self::$listing_tablename;

        $sql = "SELECT user_id from $listing_tablename where listing_id = ".(int)$listing_id;
        $listing = $wpdb->get_results( $sql,ARRAY_A);

        if(isset($listing[0]) and $listing[0]['user_id'] == get_current_user_id()) {
            $wpdb->update($listing_tablename, ['deleted_reason' => $reason, 'deleted' => 1], ['listing_id' => $listing_id]);
        }
	}

	public static function deleteListingFile($fileData) {
		global $wpdb;

		$files_tablename = $wpdb->prefix . self::$files_tablename;

		$wpdb->delete($files_tablename, ['file_id'=>$fileData['file_id']]);

		$sql = "SELECT * from $files_tablename where media_id = ".(int)$fileData['media_id'];
		$results = $wpdb->get_results( $sql,ARRAY_A);
		if(!count($results)) {
			wp_delete_post($fileData['media_id']);
		}

	}



	public static function isOwner($userId, $listingId) {
		return (bool)count(self::getUserListings($userId, $listingId));
	}

	public static function format_price($num) {
		return $num;
	}
	public static function formatDate($date) {
		$d = new DateTime($date);
		return $d->format("M j, Y ");
	}
	public static function search($request) {
        global $wpdb;
        $listing_tablename = $wpdb->prefix . self::$listing_tablename;
        $features_tablename = $wpdb->prefix . self::$features_tablename;
        $sql = " from $listing_tablename a left join $features_tablename b on a.listing_id = b.listing_id and b.feature_type = 1 where to_delete != 1 and deleted = 0 ";
        $sql2 = " and to_delete != 1 and deleted = 0 and featured = 1 ";
        if($request['rent'] == 'true'){
            $sql .= ' and sale_rent = '.self::$for_rent;
            $sql2 .= ' and sale_rent = '.self::$for_rent;
        } else {
            $sql .= ' and sale_rent = '.self::$for_sale;
            $sql2 .= ' and sale_rent = '.self::$for_sale;
        }
        $featured = false;
        if($request['rad'] and $request['city']){
            $geo = file_get_contents('http://geogratis.gc.ca/services/geoname/en/geonames.json?concise=CITY,TOWN&sort-field=name&q='.urlencode($request['city']));
            if($geo){
                $geo = json_decode($geo,true);
                if(count($geo['items'])) {
                    $lat = $geo['items'][0]['latitude'];
                    $lng = $geo['items'][0]['longitude'];
                    $sql .= ' and ( ( 6971 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin(radians(lat)) ) ) < ' . intval($request['rad']) . ')';

                    $sql2 .= ' and ( ( 6971 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin(radians(lat)) ) ) < ' . intval($request['rad']) . ')';
                    $results = $wpdb->get_results( "SELECT a.*,(TO_DAYS(NOW()) - TO_DAYS(date_published)<=10) as new_listing FROM $listing_tablename a JOIN (SELECT (RAND() * (SELECT MAX(listing_id) FROM $listing_tablename)) AS id) AS r2 left join $features_tablename b on a.listing_id = b.listing_id and b.feature_type = 1 WHERE a.listing_id >= r2.id $sql2 LIMIT 1", ARRAY_A);
                    if(isset($results[0])){
                        $results[0]['openhouse'] = self::getListingOpenhouse($results[0]['listing_id']);
                        $results[0]['contact'] = self::getListingContact($results[0]['listing_id']);
                        $results[0]['images'] = self::getListingFiles($results[0]['listing_id'],self::$file_image);
                        $results[0]['featured_one'] = 1;
                        $featured = $results[0];
                    }
                }
            }
        }
        if($request['price_min']){
            $sql .= ' and ( price >= '.intval($request['price_min']).')';
        }
        if($request['price_max']){
            $sql .= ' and ( price <= '.intval($request['price_max']).')';
        }
        if($request['sqft_min']){
            $sql .= ' and ( square_footage >= '.intval($request['sqft_min']).')';
        }
        if($request['sqft_max']){
            $sql .= ' and ( square_footage <= '.intval($request['sqft_max']).')';
        }
        if($request['year_min']){
            $sql .= ' and ( year_built >= '.intval($request['year_min']).')';
        }
        if($request['year_max']){
            $sql .= ' and ( year_built <= '.intval($request['year_max']).')';
        }
        if($request['beds']){
            $sql .= ' and ( bedrooms >= '.intval($request['beds']).')';
        }
        if($request['baths']){
            $sql .= ' and ( bathrooms >= '.intval($request['baths']).')';
        }
        if($request['days_on']){
            $sql .= ' and ( TO_DAYS(NOW()) - TO_DAYS(date_published) <= '.intval($request['days_on']).')';
        }
        if($request['hometype']){
            $items = explode(',',$request['hometype']);
            $sql .= ' and ( ';
            foreach ($items as $item){
                $sql .= '(property_type like "%'.$item.'%") or ';
            }
            $sql .= '0)';
        }
        if($request['sale_by']){
            $items = explode(',',$request['sale_by']);
            $sql .= ' and ( ';
            foreach ($items as $item){
                $sql .= '(sale_by = '.intval($item).') or ';
            }
            $sql .= '0)';
        }
        if($request['features_1']){
            $items = explode(',',$request['features_1']);
            $sql .= ' and ( ';
            foreach ($items as $item){
                $sql .= '(feature = "'.$item.'") or ';
            }
            $sql .= '0)';
        }
        $cnt = $wpdb->get_results('select count(distinct a.listing_id) as cnt '.$sql,ARRAY_A);
        $cnt = $cnt[0]['cnt']+($featured?1:0);
        if($featured){
            $sql .= ' and a.listing_id <> '.$featured['listing_id'];
        }

        $sql .= ' group by a.listing_id';
        if($request['features_1']){
            $items_cnt = count(explode(',',$request['features_1']));
            $sql .= ' having count(feature_id) = '.$items_cnt;
        }
        if(in_array($request['sort_by'],array('price_low_high','price_high_low','date_old_new','date_new_old'))){
            $sql .= ' order by ';
            if($request['sort_by'] == 'price_low_high'){
                $sql .= 'price asc';
            } elseif($request['sort_by'] == 'price_high_low'){
                $sql .= 'price desc';
            } elseif($request['sort_by'] == 'date_old_new'){
                $sql .= 'date_published asc';
            } elseif($request['sort_by'] == 'date_new_old'){
                $sql .= 'date_published desc';
            }
        }
        $per_page = 10;
        $page = $request['page']?intval($request['page']):1;
        if($page < 1) {
            $page = 1;
        }
        $page_max = ceil($cnt/$per_page);
        if($page > $page_max ) {
            $page = $page_max;
        }
        //var_dump($sql);die;
        $sql .= ' limit '.(($page-1)*$per_page).','.($per_page-($featured?1:0));
//todo list only used fields
        $results = $wpdb->get_results( 'SELECT a.*,(TO_DAYS(NOW()) - TO_DAYS(date_published)<=10) as new_listing '.$sql, ARRAY_A);

        foreach($results as $key=>$val) {
            $results[$key]['openhouse'] = self::getListingOpenhouse($val['listing_id']);
            $results[$key]['contact'] = self::getListingContact($val['listing_id']);
            $results[$key]['images'] = self::getListingFiles($val['listing_id'],self::$file_image);
        }
        $ads = [
            'list_banner_url' => get_field('list_banner_url',intval($request['page_id'])),
            'list_banner_image' => get_field('list_banner_image',intval($request['page_id']))
        ];
		return array('items'=>$results,'count'=>count($results),'page'=>$page,'pages'=>$page_max,'ads'=>$ads,'featured'=>$featured);
	}

	public static function favorite($request){
        global $wpdb;
        $current_user = wp_get_current_user();
        $fav_ids = get_user_meta($current_user->ID,'favorite_listing',true);
        if(!is_array($fav_ids)){
            $fav_ids = array();
        }
        $view_ids = get_user_meta($current_user->ID,'recently_listing',true);
        if(!is_array($view_ids)){
            $view_ids = array();
        }
        if($request['del'] and isset($fav_ids[intval($request['del'])])){
            unset($fav_ids[intval($request['del'])]);
            update_user_meta($current_user->ID,'favorite_listing', $fav_ids);
        }
        if($request['add']){
            $fav_ids[intval($request['add'])] = intval($request['add']);
            update_user_meta($current_user->ID,'favorite_listing', $fav_ids);
        }
        $listing_tablename = $wpdb->prefix . self::$listing_tablename;
        $fav_list = $wpdb->get_results( "SELECT listing_id,unit_number,address,city,province,price from $listing_tablename where to_delete != 1 and deleted = 0 and listing_id in (".implode(',',$fav_ids).")", ARRAY_A);
        foreach($fav_list as $key=>$val) {
            $fav_list[$key]['images'] = self::getListingFiles($val['listing_id'],self::$file_image);
        }
        $view_list = $wpdb->get_results( "SELECT listing_id,unit_number,address,city,province,price from $listing_tablename where to_delete != 1 and deleted = 0 and listing_id in (".implode(',',$view_ids).")", ARRAY_A);
        foreach($view_list as $key=>$val) {
            $view_list[$key]['images'] = self::getListingFiles($val['listing_id'],self::$file_image);
        }
	    return array(
	        'fav'=>$fav_list,
            'view'=>$view_list
        );
    }

    public static function getMarket($listing_id)
    {
        global $wpdb;
        $listing_tablename = $wpdb->prefix . self::$listing_tablename;
        $listing = $wpdb->get_results( "SELECT lat,lng from $listing_tablename where listing_id = $listing_id", ARRAY_A);
        if($listing){
            $lat = $listing[0]['lat'];
            $lng = $listing[0]['lng'];
            $sql = "select a.* from $listing_tablename a where to_delete != 1 and deleted = 0 and listing_id <> $listing_id";
            $sql .= ' and ( ( 6971 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin(radians(lat)) ) ) < 10)';
            $order_by = ' order by ( 6971 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin(radians(lat)) ) ) asc limit 10';
        }
        $results = array(
	        'sale' => $wpdb->get_results( $sql. ' and sale_rent = '.self::$for_sale.$order_by, ARRAY_A),
	        'offer' => $wpdb->get_results( $sql. ' and status = "Conditional Offer"'.$order_by, ARRAY_A),
	        'sold' => $wpdb->get_results( $sql. ' and status = "Sold" '.$order_by, ARRAY_A)
        );
        foreach($results['sale'] as $key=>$val) {
            $results['sale'][$key]['openhouse'] = self::getListingOpenhouse($val['listing_id']);
            $results['sale'][$key]['contact'] = self::getListingContact($val['listing_id']);
            $results['sale'][$key]['images'] = self::getListingFiles($val['listing_id'],self::$file_image);
        }
        foreach($results['offer'] as $key=>$val) {
            $results['offer'][$key]['openhouse'] = self::getListingOpenhouse($val['listing_id']);
            $results['offer'][$key]['contact'] = self::getListingContact($val['listing_id']);
            $results['offer'][$key]['images'] = self::getListingFiles($val['listing_id'],self::$file_image);
        }
        foreach($results['sold'] as $key=>$val) {
            $results['sold'][$key]['openhouse'] = self::getListingOpenhouse($val['listing_id']);
            $results['sold'][$key]['contact'] = self::getListingContact($val['listing_id']);
            $results['sold'][$key]['images'] = self::getListingFiles($val['listing_id'],self::$file_image);
        }
        return $results;
    }
}

