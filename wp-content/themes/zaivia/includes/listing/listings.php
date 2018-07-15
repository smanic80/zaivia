<?php

class ZaiviaListings extends listing_base {
	public static $for_rent = 0;
	public static $for_sale = 1;

	public static $file_image = 1;
	public static $file_blueprint = 2;
	public static $file_rent = 3;
	public static $file_profile = 4;
	public static $file_logo = 5;

	public static $max_rescent = 5;
	public static $search_per_page = ['list'=>9, 'grid'=>12];
	public static $market_radius = 10;
	public static $market_limit = 10;

	public static $image_key = 'banner_image';

	public static function getListings($listingId = null, $userId=null, $formatMoney = true) {
		global $wpdb;

		$listing_tablename = $wpdb->prefix . self::$listing_tablename;

		$sql = "SELECT *, 
					IF(sale_rent = ".self::$for_sale.", '".__('For Sale')."', '".__('For Rent')."') as `sale_rent-text`, 
					IF(activated = 1, '".__('Yes')."', '".__('No')."') as `active-text`,
					 concat(address, ', ', city, ' ', province) as `address-text`
				from $listing_tablename 
				where ";
		$where = ["deleted = 0"];
		if($listingId) {
			$where[] = "listing_id = ".(int)$listingId;
		} else {
			$where[] = "to_delete != 1";
		}
		if($userId) {
			$where[] = "user_id = ".(int)$userId;
		}

		$sql .= implode(" and ", $where);
		$results = $wpdb->get_results( $sql,ARRAY_A);
		foreach($results as $key=>$val) {

			$results[$key]['partial_rent'] = explode(";", $results[$key]['partial_rent']);
			$results[$key]['room_features'] = unserialize($results[$key]['room_features']);
			$results[$key]['renewal_date'] = self::getRenewealDate($val);

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

			if($listingId) {
				$results[ $key ]['rent']      = self::getListingRent( $listingId );
				$results[ $key ]['price']     = $formatMoney ? self::formatMoney( $val['price'] ) : $val['price'];
				$results[ $key ]['images']    = self::getListingImage( $listingId, false );
				$results[ $key ]['blueprint'] = self::getListingFiles( $listingId, self::$file_blueprint, 1, false );
				$results[ $key ]['openhouse'] = ( $val['sale_rent'] === self::$for_sale ) ? self::getListingOpenhouse( $listingId ) : [];
				$results[ $key ]['contact']   = self::getListingContact( $listingId );
				$results[ $key ]['faved']     = in_array( $listingId, self::getCurrentUserFavedIds() );
			}
		}
		if($listingId) {
			$res = isset( $results[0] ) ? $results[0] : null;
		} else {
			$res = $results;
		}

		return $res;
	}

	public static function getRenewealDate($listing){
		$dates = [];
		if($listing['featured_date'] && strtotime($listing['featured_date'])) $dates[] = strtotime($listing['featured_date']);
		if($listing['premium_date'] && strtotime($listing['premium_date'])) $dates[] = strtotime($listing['premium_date']);
		if($listing['url_date'] && strtotime($listing['url_date'])) $dates[] = strtotime($listing['url_date']);

		return $dates ? min(array_values($dates)) : "";
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

			'price' => (float)str_replace(",", "", $data['price']),
			'property_type' => $data['property_type'],
			'house_type' => $data['house_type'],
			'square_footage' => (float)str_replace(",","", $data['square_footage']),
			'bedrooms' => (int)$data['bedrooms'],
			'bathrooms' => (int)$data['bathrooms'],

			'roof_type' => $data['roof_type'],
			'exterior_type' => $data['exterior_type'],
			'parking' => $data['parking'],
			'driveway' => $data['driveway'],
			'size_x' => $data['size_x'],
			'size_y' => $data['size_y'],
			'size_units' => $data['size_units'],

			'year_built' => (int)$data['year_built'],
			'annual_taxes' => (float)str_replace(",","", $data['annual_taxes']),
			'condo_fees' => (float)str_replace(",","", $data['condo_fees']),
			'partial_rent' => implode(";", $data['partial_rent']),

			'room_features' => serialize($data['room_features']),
			'description' => $data['description'],

			'featured' => $data['featured'],
			'premium' => $data['premium'],
			'url' => $data['url'],
			'url_value' => $data['url_value'],
			'bump_up' => $data['bump_up'],

			'status' => $data['status'],
		];

		$userId = get_current_user_id();

		if((int)$data['listing_id']) {
			$listingId = (int)$data['listing_id'];
			if(!self::isOwner($userId, $listingId)) {
				return __('This is not yours!');
			}

			$listing = self::getListings($listingId);
			if($listing['to_delete'] === '1' && isset($data['to_delete'])) {
				$preparedData['to_delete'] = 0;
				$preparedData['date_created'] = date('Y-m-d H:i:s', time());
			}

			if(is_administrator()) {
				$traits = [ "featured", "premium", "url" ];
				foreach ( $traits as $trait ) {
					$preparedData[ $trait . '_date' ] = date('Y-m-d',strtotime($data[ $trait . '_date']));
				}

				//if($listing['bump_up'] === '1') $preparedData['bump_up'] = $curDate;
				self::useCoupon( (int) $listing['applied_coupon'], $userId );
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

			$preparedData['user_id'] = $userId;
			$preparedData['activated'] = 0;

			$wpdb->insert($listing_tablename, $preparedData);
			$listingId = $wpdb->insert_id;

		}

		$res = self::updateListingContact( $listingId, $data );
		$res['listing_id'] = $listingId;

		if(isset($data['to_delete']) && $data['to_delete'] === 0 ) {
			$wpdb->delete($listing_tablename, ["to_delete" => 1, "user_id" =>(int)$userId]  );
		}
		return $res;
	}

	public static function duplicateListing($listing_from, $listing_to) {
		$userId = is_administrator() ? false :  get_current_user_id();

		$listing = self::getListings($listing_from, $userId);

		$listing = array_merge($listing, self::getListingRent($listing_from));
		$listing = array_merge($listing, self::getListingContact($listing_from));

		$listing['listing_id'] = $listing_to;
		unset($listing['to_delete']);

		$listing = array_merge($listing, self::saveListing($listing));

		return $listing;
	}

	public static function activateListing($listingId){
		global $wpdb;
		$listing_tablename = $wpdb->prefix . self::$listing_tablename;

		$userId = is_administrator() ? false :  get_current_user_id();

		if(!self::isOwner($userId, $listingId)) {
			return __('This is not yours!');
		}


		$listing = self::getListings($listingId, $userId);
		$curDate = date('Y-m-d H:i:s', time());

		$preparedData = [
			'activated'=>1,
			'date_published' => $curDate,
			'applied_coupon' => null
		];
		if($listing['to_delete'] === '1') {
			$preparedData['to_delete'] = 0;
			$preparedData['date_created'] = $curDate;
		}

		if(!is_administrator()) {
			$traits = [ "featured", "premium", "url" ];
			foreach ( $traits as $trait ) {
				$preparedData[ $trait . '_date' ] = self::calculateTraitDate( $trait, $listing );
				$preparedData[ $trait ]           = 0;
			}

			//if($listing['bump_up'] === '1') $preparedData['bump_up'] = $curDate;
			self::useCoupon( (int) $listing['applied_coupon'], $userId );
		}
		$res = (bool) $wpdb->update($listing_tablename, $preparedData, ['listing_id' => $listingId]);

		return $res;
	}

	public static function on_offListing($listingId, $enable) {
		global $wpdb;
		$listing_tablename = $wpdb->prefix . self::$listing_tablename;

		$curDate = date('Y-m-d H:i:s', time());
		$preparedData = [
			'activated'=>$enable,
			'date_published' => $curDate,
		];

		$res = (bool) $wpdb->update($listing_tablename, $preparedData, ['listing_id' => $listingId]);

		return $res;
	}

	public static function calculateTraitDate($trait, $listing) {
		if((int)$listing[$trait] !== 1) return $listing[$trait . '_date'];

		$period = (int)get_field($trait . "_days", "option");
		$date = $listing[$trait . '_date'] ? strtotime($listing[$trait . '_date']) : time();

		return date('Y-m-d', strtotime("+" . $period . " days", $date));
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
			$results[0]['rent_utilities'] = $results[0]['rent_utilities'] ? explode(';', $results[0]['rent_utilities']) : [];
			$results[0]['rent_date'] = ($results[0]['rent_date']!='0000-00-00') ? date('m/d/Y',strtotime($results[0]['rent_date'])) : '';
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
					DATE_FORMAT(start_time,'%l:%i%p') as src_start_time, 
					DATE_FORMAT(end_time,'%l:%i%p') as src_end_time 
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

		$contactData= [
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
			$wpdb->update($contact_tablename, $contactData, ['listing_id' => $listingId]);
		} else {
			$contactData['listing_id'] = $listingId;
			$wpdb->insert($contact_tablename, $contactData);
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

		$contactData['contact_profile'] = ZaiviaListings::getListingFiles($listingId, ZaiviaListings::$file_profile);
		$contactData['contact_logo'] = ZaiviaListings::getListingFiles($listingId, ZaiviaListings::$file_logo);

//		update_user_meta(get_current_user_id(), "listing_contact", $contactData);

		return ['contact_profile' => $contactData['contact_profile'], 'contact_logo'=>$contactData['contact_logo']];
	}






	public static function getListingImage($listingId, $single = true){
		$results = self::getListingFiles($listingId, self::$file_image,1, $single);

		if(!$results) {
			$img = "default.jpg";
			$url = get_template_directory_uri()."/images/".$img;
			$default = [
				'file_url' => $url,
				'file_name' => $img,
				'big' => $url,
				'card' => $url,
				'thumb' => $url,
			];
			$results = $single ? $default : [$default];
		}

		return $results;
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
			$results[$key]['big'] = wp_get_attachment_image_url($val['media_id'],'listing-big');
			$results[$key]['card'] = wp_get_attachment_image_url($val['media_id'],'listing-card');
			$results[$key]['thumb'] = wp_get_attachment_image_url($val['media_id'],'listing-th');
			$results[$key]['contact_card_profile'] = wp_get_attachment_image_url($val['media_id'],'contact_card-profile');
			$results[$key]['contact_card_logo'] = wp_get_attachment_image_url($val['media_id'],'contact_card-logo');
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
			$results['big'] = wp_get_attachment_image_url($results['media_id'],'listing-big');
			$results['card'] = wp_get_attachment_image_url($results['media_id'],'listing-card');
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
			add_post_meta($mediaId, "listing_file", $listingId);

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

	public static function deleteListing($listing_id, $reason) {
		global $wpdb;
		$listing_tablename = $wpdb->prefix . self::$listing_tablename;
		$deleted_tablename = $wpdb->prefix . self::$deleted_tablename;

		if($reason) {
			$data = ['listing_id' => $listing_id,
			         'is_sold' => isset($reason['is_sold']) ? (int)$reason['is_sold'] : 0,
			         'is_share_price' => isset($reason['is_share_price']) ? (int)$reason['is_share_price'] : 0,
			         'is_satisfied' => isset($reason['is_satisfied']) ? (int)$reason['is_satisfied'] : 0,
			         'price' => isset($reason['price']) ? (int)$reason['price'] : 0,
			         'comments' => isset($reason['comments']) ? sanitize_text_field($reason['comments']) : "",
			];
		} else {
			$data = ['listing_id' => $listing_id,
			         'is_sold' => 0,
			         'is_share_price' => 0,
			         'is_satisfied' => 0,
			         'price' => 0,
			         'comments' => "Deleted by admin",
			];
		}

		$wpdb->update($listing_tablename, ['deleted' => 1], ['listing_id' => $listing_id]);
		$wpdb->insert($deleted_tablename, $data);
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



	public static function isOwner($userId, $id, $entity_type="listing") {
		if(!$id) return true;

		$userId = is_administrator() ? false : $userId;
		return (bool)count(self::getListings($id, $userId));
	}



	public static function searchListings($request) {
		global $wpdb;

		$listing_tablename = $wpdb->prefix . self::$listing_tablename;
		$features_tablename = $wpdb->prefix . self::$features_tablename;

		$request_type = isset($request['type']) ? $request['type'] : '';
		$daysNew = (int)get_field("new_days", "option");

		$sqlSelect = ($request_type !== 'map') ?
			"SELECT a.*, DATEDIFF(NOW(), date_published) <= {$daysNew} as new_listing, DATEDIFF(NOW(), premium_date) < 0 as premium" :
			"SELECT a.listing_id, a.lat, a.lng";

		$sqlFrom = ($request_type !== 'map') ?
			"from $listing_tablename a left join $features_tablename b on a.listing_id = b.listing_id and b.feature_type = 1" :
			"from $listing_tablename a";


		$sqlWhere = self::buildSearchWhere($request);

		$featured = ($request_type !== 'map') ? self::searchFeatured($sqlWhere) : [];
		if($featured){
			$sqlWhere[] = 'a.listing_id <> '.$featured['listing_id'];
		}
		$sqlWhere = " where " . implode(" and ", $sqlWhere);

		$sqlGroup = ($request_type !== 'map') ? "group by a.listing_id" : "";
		$sqlOrder = ($request_type !== 'map') ? self::searchOrder($request['sort_by']) : "";

		$pagination = ($request_type !== 'map') ? self::searchPagination($sqlFrom, $sqlWhere, $featured, (isset($request['page']) ? intval($request['page']) : 1), $request_type) : "";
		$sqlLimit = ($request_type !== 'map') ? ('limit ' . (($pagination['page'] - 1) * $pagination['per_page']) . ',' . ($pagination['per_page'] - ($featured ? 1 : 0)) ) : "";

		$paginationHtml = self::buildBaginationHtml($pagination['page_max'], $pagination['page']);
		$filteredHtml = self::buildFilteredHtml($request);

		$sql = $sqlSelect . " " . $sqlFrom . ' ' . $sqlWhere . ' ' . $sqlGroup . ' ' . $sqlOrder . ' ' . $sqlLimit;

		$results = $wpdb->get_results( $sql, ARRAY_A);
		$results = ($request_type !== 'map') ? self::prepareSearchResult($results) : $results;

		$ads = ZaiviaBusiness::findRandomBanner(($request['rent'] == 'true') ? self::$for_rent : self::$for_sale,$request['city']?$request['city']:'');

		return array('items'=>$results, 'count'=>$pagination['count'], 'pagination'=>$paginationHtml, 'filtered'=>$filteredHtml, 'ads'=>$ads, 'featured'=>$featured, );
	}





	private static function buildSearchWhere($request){
		$sqlWhere = [
			"to_delete != 1",
			"deleted = 0",
			"activated = 1",
			"sale_rent = " . ( ($request['rent'] == 'true') ? self::$for_rent : self::$for_sale ),
		];

		$rad = $request['rad']?$request['rad']:'';
		$city = $request['city']?$request['city']:'';
		$geo = self::getCityCoords($city);

		if($geo) {
			$sqlWhere[] = self::getGeoRadiusSql($geo['lat'], $geo['lng'], $rad);
		} else {
			$sqlWhere[] = 'false';
		}

		if($request['price_min']){
			$sqlWhere[] = '( price >= '.intval($request['price_min']).')';
		}
		if($request['price_max']){
			$sqlWhere[] = '( price <= '.intval($request['price_max']).')';
		}
		if($request['sqft_min']){
			$sqlWhere[] = '( square_footage >= '.intval($request['sqft_min']).')';
		}
		if($request['sqft_max']){
			$sqlWhere[] = '( square_footage <= '.intval($request['sqft_max']).')';
		}
		if($request['year_min']){
			$sqlWhere[] = '( year_built >= '.intval($request['year_min']).')';
		}
		if($request['year_max']){
			$sqlWhere[] = '( year_built <= '.intval($request['year_max']).')';
		}
		if($request['beds']){
			$sqlWhere[] = '( bedrooms >= '.intval($request['beds']).')';
		}
		if($request['baths']){
			$sqlWhere[] = '( bathrooms >= '.intval($request['baths']).')';
		}
		if($request['days_on']){
			$sqlWhere[] = '(DATEDIFF(NOW(), date_published) <= '. intval($request['days_on']) .')';
		}
		if($request['propertytype']){
			$items = explode(',', $request['propertytype']);
			$subQuery = [];
			foreach ($items as $item){
				$subQuery[] = 'property_type like "%' . $item . '%"';
			}
			$sqlWhere[] = "(" . (implode(" or ", $subQuery)) . ")";
		}
		if($request['sale_by']){
			$items = explode(',', $request['sale_by']);
			$subQuery = [];
			foreach ($items as $item){
				$subQuery[] = 'sale_by = '.intval($item);
			}
			$sqlWhere[] = "(" . (implode(" or ", $subQuery)) . ")";
		}
		if($request['features_1']){
			$items = explode(',',$request['features_1']);
			$subQuery = [];
			foreach ($items as $item){
				$subQuery[] = 'feature = "'.$item;
			}
			$sqlWhere[] = "(" . (implode(" or ", $subQuery)) . ")";
		}

		return $sqlWhere;
	}

	private static function buildFilteredHtml($request){
		$filtered = '';

		if($request['price_min']!='' && $request['price_max']){
			$filtered .= '<li><a href="#" class="clear_price"><i class="fa fa-times" aria-hidden="true"></i></a>'.$request['price_min'].' - '.$request['price_max'].'</li>';
		}
		if($request['sqft_min']){
			$filtered .= '<li><a href="#" class="clear_sqft-min"><i class="fa fa-times" aria-hidden="true"></i></a>'.__('Square Min','am').' '.intval($request['sqft_min']).' '. __('Feet','am') .'</li>';
		}
		if($request['sqft_max']){
			$filtered .= '<li><a href="#" class="clear_sqft-max"><i class="fa fa-times" aria-hidden="true"></i></a>'.__('Square Max','am').' '.intval($request['sqft_max']).' '. __('Feet','am') .'</li>';
		}
		if($request['year_min']){
			$filtered .= '<li><a href="#" class="clear_year-built-min"><i class="fa fa-times" aria-hidden="true"></i></a>'.__('Year Built Min','am').' '.intval($request['year_min']). '</li>';
		}
		if($request['year_max']){
			$filtered .= '<li><a href="#" class="clear_year-built-max"><i class="fa fa-times" aria-hidden="true"></i></a>'.__('Year Built Max','am').' '.intval($request['year_max']). '</li>';
		}
		if($request['beds']){
			$filtered .= '<li><a href="#" class="clear_beds"><i class="fa fa-times" aria-hidden="true"></i></a>'. intval($request['beds']) .' '. __('Beds','am') . '</li>';
		}
		if($request['baths']){
			$filtered .= '<li><a href="#" class="clear_baths"><i class="fa fa-times" aria-hidden="true"></i></a>'. intval($request['baths']) .' '. __('Bath','am') . '</li>';
		}
		if($request['propertytype']){
			$items = explode(',',$request['propertytype']);
			foreach ($items as $item){
				$filtered .= '<li><a href="#" class="clear_propertytype" data-val="'.$item.'"><i class="fa fa-times" aria-hidden="true"></i></a>'.$item.'</li>';
			}
		}
		if($request['sale_by']!=''){
			$items = explode(',',$request['sale_by']);
			foreach ($items as $item){
				if ($item == '0'){
					$item_name = __('by agent','am');
				} else if ($item == '1'){
					$item_name = __('by owner','am');
				} else {
					$item_name = __('by property management','am');
				}
				$filtered .= '<li><a href="#" class="clear_show_only" data-val="'.$item.'"><i class="fa fa-times" aria-hidden="true"></i></a>'.$item_name.'</li>';
			}
		}
		if($request['features_1']){
			$features_1 = get_field('features_1', 'option');
			$items = explode(',',$request['features_1']);
			foreach ($items as $item){
				$item_name = $item;
				foreach ($features_1 as $feature){
					if($feature['key'] == $item){
						$item_name = $feature['name'];
						break;
					}
				}
				$filtered .= '<li><a href="#" class="clear_features_1" data-val="'.$item.'"><i class="fa fa-times" aria-hidden="true"></i></a>'.$item_name.'</li>';
			}
		}

		return $filtered;
	}

	private static function searchPagination($sqlFrom, $sqlWhere, $featured, $page, $request_type){
		global $wpdb;

		$sql = 'select count(distinct a.listing_id)' . " " . $sqlFrom . " " . $sqlWhere;
		$cnt = $wpdb->get_var($sql) + ($featured ? 1 : 0);
		$page_max = ceil($cnt / self::$search_per_page[$request_type]) + 1;
		$page = ( $page < 1 ) ? 1 : ($page > $page_max ? $page_max : $page);

		return ['count' => $cnt, 'page' => $page, 'pages' => ($page_max-1), 'per_page'=>self::$search_per_page[$request_type]];
	}

	private static function buildBaginationHtml($page_max, $page){
		$pagination = '';
		if($page_max > 1){
			if ($page == 1) {
				$pagination .= '<span class="page-numbers">'.__('Previous','am').'</span>';
			} else {
				$pagination .= '<a class="prev page-numbers" data-page="' . ($page - 1) . '" href="#">'.__('Previous','am').'</a>';
			}
			$p_start = $page - 5;
			if ($p_start < 1) {
				$p_start = 1;
			}
			$p_end = $page + 5;
			if ($p_end > $page_max-1) {
				$p_end = $page_max-1;
			}
			for ($p = $p_start; $p <= $p_end; $p++) {
				if ($p == $page) {
					$pagination .= '<span class="page-numbers current">' . $p . '</span>';
				} else {
					$pagination .= '<a class="page-numbers" data-page="' . $p . '" href="#">' . $p . '</a>';
				}
			}
			if ($page == $page_max-1) {
				$pagination .= '<span class="page-numbers">'.__('Next','am').'</span>';
			} else {
				$pagination .= '<a class="prev page-numbers" data-page="' . ($page + 1) . '" href="#">'.__('Next','am').'</a>';
			}
		}
		return $pagination;
	}

	private static function searchFeatured($where){
		global $wpdb;

		$listing_tablename = $wpdb->prefix . self::$listing_tablename;
		$features_tablename = $wpdb->prefix . self::$features_tablename;

		$daysNew = (int)get_field("new_days", "option");

		$where[] = "DATEDIFF(now(), featured_date) < 0";

		$featuredSql = "
			SELECT a.*, DATEDIFF(NOW(), date_published) <= {$daysNew} as new_listing 
			FROM $listing_tablename a 
			left join $features_tablename b on a.listing_id = b.listing_id and b.feature_type = 1 
			WHERE ".implode(" and ", $where)." 
			ORDER BY RAND() LIMIT 1
		";

		$results = $wpdb->get_results( $featuredSql, ARRAY_A);
		if(isset($results[0])){
			$results[0]['openhouse'] = ($results[0]['sale_rent'] === self::$for_sale) ? self::getListingOpenhouse($results[0]['listing_id']) : [];
			$results[0]['contact'] = self::getListingContact($results[0]['listing_id']);
			$results[0]['images'] = self::getListingImage($results[0]['listing_id']);
			$results[0]['featured_one'] = 1;
			$featured = $results[0];
		}

		return isset($featured) ? $featured : [];
	}

	private static function searchOrder($sort_by) {
		$sqlOrder = '';
		if (in_array($sort_by, ['price_low_high', 'price_high_low', 'date_old_new', 'date_new_old'])) {
			$sqlOrder = 'order by ';
			if ($sort_by == 'price_low_high') {
				$sqlOrder .= 'price asc';
			} elseif ($sort_by == 'price_high_low') {
				$sqlOrder .= 'price desc';
			} elseif ($sort_by == 'date_old_new') {
				$sqlOrder .= 'date_published asc';
			} elseif ($sort_by == 'date_new_old') {
				$sqlOrder .= 'date_published desc';
			}
		}

		return $sqlOrder;
	}

	private static function prepareSearchResult($results) {
		$fav_ids = self::getCurrentUserFavedIds();
		foreach($results as $key=>$val) {
			$results[$key]['faved'] = in_array($results[$key]['listing_id'], $fav_ids);
			$results[$key]['price'] = self::formatMoney($results[$key]['price']);
			$results[$key]['openhouse'] = ($results[$key]['sale_rent'] === self::$for_sale) ? self::getListingOpenhouse($val['listing_id']) : [];
			$results[$key]['contact'] = self::getListingContact($val['listing_id']);
			$results[$key]['images'] = self::getListingImage($val['listing_id']);
			$results[$key]['partial_rent_text'] = $val['partial_rent'] ? implode(', ',explode(";", $val['partial_rent'])) : "";
		}

		return $results;
	}


	public static function favorite($request){
		global $wpdb;

		$userId = get_current_user_id();
		$listing_tablename = $wpdb->prefix . self::$listing_tablename;
		$fav_list = $view_list = [];


		$fav_ids = self::getCurrentUserFavedIds();

		if($request['del'] and isset($fav_ids[intval($request['del'])])){
			unset($fav_ids[intval($request['del'])]);
		}
		if($request['add']){
			$fav_ids[intval($request['add'])] = intval($request['add']);
		}

		if($userId) {
			update_user_meta($userId,'favorite_listing', $fav_ids);
		} else {
			setcookie("favorite_listing", $fav_ids);
		}


		if($fav_ids) {
			$sql = "SELECT listing_id,unit_number,address,city,province,price from {$listing_tablename} where to_delete != 1 and deleted = 0 and listing_id in (".implode(',',$fav_ids).")";
			$fav_list = $wpdb->get_results( $sql, ARRAY_A);
			foreach($fav_list as $key=>$val) {
				$fav_list[$key]['images'] = self::getListingImage($val['listing_id']);
				$fav_list[$key]['price'] = self::formatMoney($val['price']);
			}
		}

		$view_ids = self::getCurrentUserViewedIds();
		if($view_ids){
			$sql = "SELECT listing_id,unit_number,address,city,province,price from {$listing_tablename} where to_delete != 1 and deleted = 0 and listing_id in (".implode(',',$view_ids).")";
			$view_list = $wpdb->get_results($sql,ARRAY_A);
			foreach($view_list as $key=>$val) {
				$view_list[$key]['images'] = self::getListingImage($val['listing_id']);
				$view_list[$key]['price'] = self::formatMoney($val['price']);
			}
		}

		return array(
			'fav'=>$fav_list,
			'view'=>$view_list
		);
	}

	public static function getCurrentUserFavedIds() {
		$userId = get_current_user_id();
		if($userId) {
			$fav_ids = get_user_meta($userId,'favorite_listing',true);
			$fav_ids = is_array($fav_ids) ? $fav_ids : [];
		} else {
			$fav_ids = isset($_COOKIE['favorite_listing']) ? json_decode(stripslashes($_COOKIE['favorite_listing'])) : [];
		}

		return $fav_ids;
	}

	public static function getCurrentUserViewedIds(){
		$userId = get_current_user_id();
		if($userId) {
			$view_ids = get_user_meta($userId,'recently_listing',true);
			$view_ids = is_array($view_ids) ? $view_ids : [];
		} else {
			$view_ids = isset($_COOKIE['recently_listing']) ? json_decode(stripslashes($_COOKIE['recently_listing'])) : [];
		}

		return $view_ids;
	}

	public static function updateLastViewed($listing_id){
		self::setLastViewed(self::combineLastViewed($listing_id, self::getCurrentUserViewedIds()));
	}

	public static function combineLastViewed($listing_id, $view_ids){
		if (($key = array_search($listing_id, $view_ids)) !== false) {
			unset($view_ids[$key]);
		}
		$view_ids[] = $listing_id;
		$view_ids = array_slice($view_ids, -ZaiviaListings::$max_rescent);

		return $view_ids;
	}

	public static function setLastViewed($view_ids){
		$userId = get_current_user_id();
		if($userId) {
			update_user_meta($userId,'recently_listing', $view_ids);
		} else {
			setrawcookie("recently_listing", json_encode($view_ids), 0,"/");
		}
	}

	public static function getMarket($listing_id) {
		global $wpdb;

		$listing_tablename = $wpdb->prefix . self::$listing_tablename;

		$listing = $wpdb->get_results( "SELECT lat,lng from $listing_tablename where listing_id = $listing_id", ARRAY_A);
		if($listing){
			$lat = $listing[0]['lat'];
			$lng = $listing[0]['lng'];
			$sql = "select a.* from $listing_tablename a where to_delete != 1 and deleted = 0 and listing_id <> $listing_id and sale_rent = ".self::$for_sale;
			$sql .= " and " . self::getGeoRadiusSql($lat, $lng, self::$market_radius);

			$order_by = ' order by '.self::getGeoRadiusSql($lat, $lng) . ' asc limit '.self::$market_limit;
		}
		$results = array(
			'sale' => $wpdb->get_results( $sql . ' and status = "Active"' . $order_by, ARRAY_A),
			'offer' => $wpdb->get_results( $sql. ' and status = "Conditional Offer"' . $order_by, ARRAY_A),
			'sold' => $wpdb->get_results( $sql . ' and status = "Sold" ' . $order_by, ARRAY_A)
		);
		foreach($results['sale'] as $key=>$val) {
			$results['sale'][$key]['price'] = self::formatMoney($val['price']);
			$results['sale'][$key]['openhouse'] = self::getListingOpenhouse($val['listing_id']);
			$results['sale'][$key]['contact'] = self::getListingContact($val['listing_id']);
			$results['sale'][$key]['images'] = self::getListingImage($val['listing_id']);
		}
		foreach($results['offer'] as $key=>$val) {
			$results['offer'][$key]['price'] = self::formatMoney($val['price']);
			$results['offer'][$key]['openhouse'] = self::getListingOpenhouse($val['listing_id']);
			$results['offer'][$key]['contact'] = self::getListingContact($val['listing_id']);
			$results['offer'][$key]['images'] = self::getListingImage($val['listing_id']);
		}
		foreach($results['sold'] as $key=>$val) {
			$results['sold'][$key]['price'] = self::formatMoney($val['price']);
			$results['sold'][$key]['openhouse'] = self::getListingOpenhouse($val['listing_id']);
			$results['sold'][$key]['contact'] = self::getListingContact($val['listing_id']);
			$results['sold'][$key]['images'] = self::getListingImage($val['listing_id']);
		}
		return $results;
	}


	public static function prepareRenderListingData($listing) {
		$na = __("N/A", 'am');

		$listing['price_per_month'] = ($listing['sale_rent'] == ZaiviaListings::$for_rent) ?
			__('per month','am') :
			__('Est. Mortage: ','am') . '<span class="calc_payment_top">' . ZaiviaListings::formatMoney(ZaiviaListings::calculateMortage($listing['price'])) . '</span>' . __('/mth','am');

		$listing['price_formatted'] = ZaiviaListings::formatMoney($listing['price']);
		$listing['date_published'] = date('M d, Y',strtotime($listing['date_published']));
		$listing['MLSNumber'] = $listing['MLSNumber'] ? $listing['MLSNumber'] : $na;

		$listing['listing_type_title'] = $listing['property_type'] . " - " . (($listing['sale_rent'] == ZaiviaListings::$for_rent) ?
				(($listing['partial_rent'] ? (implode(', ',$listing['partial_rent'])." ") : "" ) .  __('for Rent','am') ) :
				__('For Sale','am'));


		$listing['bedrooms'] = $listing['bedrooms'] ? self::getRenderBathroom($listing, 'bedrooms') : $na;
		$listing['bathrooms'] = $listing['bathrooms'] ? self::getRenderBathroom($listing, 'bathrooms') : $na;

		$listing['parking'] = $listing['parking'] ? $listing['parking'] : $na;
		$listing['square_footage'] = $listing['square_footage'] ? $listing['square_footage'].' '.__('sq. ft','am') : $na;
		$listing['year_built'] = $listing['year_built'] ? $listing['parking'] : $na;

		$listing['rent_date'] = (isset($listing['rent']['rent_date']) && $listing['rent']['rent_date']) ? date('M d, Y',strtotime($listing['rent']['rent_date'])) : $na;
		$listing['rent_deposit'] = (isset($listing['rent']['rent_deposit']) && $listing['rent']['rent_deposit']) ? ZaiviaListings::formatMoney($listing['rent']['rent_deposit']) : $na;
		$listing['rent_furnishings'] = (isset($listing['rent']['rent_furnishings']) && $listing['rent']['rent_furnishings']) ?  __('Yes','am') : __('No','am');
		$listing['rent_pets'] = (isset($listing['rent']['rent_pets']) && $listing['rent']['rent_pets']) ?  __('Yes','am') : __('No','am');
		$listing['rent_smoking'] = (isset($listing['rent']['rent_smoking']) && $listing['rent']['rent_smoking']) ?  __('Yes','am') : __('Non-smoking','am');
		$listing['rent_laundry'] = (isset($listing['rent']['rent_laundry']) && $listing['rent']['rent_laundry'])  ?  __('Yes','am') : __('No','am');
		$listing['rent_electrified_parking'] = (isset($listing['rent']['rent_furnishings']) && $listing['rent']['rent_electrified_parking']) ?  __('Yes','am') : __('No','am');
		$listing['rent_secured_entry'] = (isset($listing['rent']['rent_furnishings']) && $listing['rent']['rent_secured_entry']) ?  __('Yes','am') : __('No','am');
		$listing['rent_private_entry'] = (isset($listing['rent']['rent_furnishings']) && $listing['rent']['rent_private_entry']) ?  __('Yes','am') : __('No','am');
		$listing['rent_onsite'] = (isset($listing['rent']['rent_furnishings']) && $listing['rent']['rent_onsite']) ?  __('Yes','am') : __('No','am');

		$listing['driveway'] = $listing['driveway'] ? $listing['driveway'] : $na;
		$listing['lot_size'] = ($listing['size_x'] && $listing['size_y']) ? ($listing['size_x'] . ' x ' . $listing['size_y'] . ' ' . $listing['size_units']) : $na;
		$listing['finished_basement'] = isset($listing['finished_basement']) ? ($listing['finished_basement'] ? __('Finished','am') : __('Not Finished','am')) : $na;
		$listing['exterior_type'] = $listing['exterior_type'] ? $listing['exterior_type'] : $na;
		$listing['roof_type'] = $listing['roof_type'] ? $listing['roof_type'] : $na;
		$listing['annual_taxes'] = $listing['annual_taxes'] ? ZaiviaListings::formatMoney($listing['annual_taxes']) : $na;

		return $listing;
	}


	public static function calculateMortage($price, $deposit=null, $rate=null, $period=null) {
		$deposit = is_null($deposit) ? (int) get_field( "mortage_default_deposit", "option" ) : $deposit;
		$rate = is_null($rate) ? (float) get_field( "mortage_annual_interest", "option" ) : $rate;
		$period = is_null($period) ? (int) get_field( "mortage_payment_period", "option" ) : $period;

		$monthRate = $rate / 12;
		$monthPriod = $period * 12;

		$pow = pow($monthRate+1, $monthPriod);

		return round(($price - $deposit) * ( ($monthRate * $pow) / ($pow - 1) ));
	}

	public static function calculatePrice($listing){
		if(!is_array($listing)) {
			$listing = ZaiviaListings::getListings($listing);
		}

		$keys = array_keys(ZaiviaListings::getFeatureKeys());

		$price = ["total"=>0];
		foreach($keys as $key) {
			if($listing[$key]){
				$featurePrice = (float)get_field($key."_price", "option");

				$price[$key] = $featurePrice;
				$price["total"] += $featurePrice;
			}
		}

		$discounted = self::applyCoupon((int)$listing['applied_coupon'], $price["total"]);

		$price["subtotal"] = $price["total"];
		$price["total"] = $discounted["sum"];
		$price["discount"] = $discounted["coupon_amount"];
		$price["coupon_name"] = $discounted["coupon_name"];

		return $price;
	}

	public static function saveSearch($request, $email=null){
		global $wpdb;

		$search_tablename = $wpdb->prefix . self::$search_tablename;

		if(!$email) {
			$user = wp_get_current_user();
			$email = $user->user_email;
		}
		if(is_array($request)) {
			$request = json_encode($request);
		}

		$wpdb->delete( $search_tablename, ["search_email"=>$email], ["%s"]);
		$wpdb->insert( $search_tablename, ["search_email"=>$email, "search_request"=>$request], ["%s". "%s"]);

		return true;
	}

	public static function getFeatureKeys(){
		return [
			"featured" =>  __( 'Featured Listing:', 'am' ),
			"premium" =>  __( 'Premium Listing:', 'am' ),
			"link" =>  __( 'Website URL', 'am' ),
			"bump_up" =>  __( 'Bump Up', 'am' ),
		];
	}

	private static function getRenderBathroom($listing, $key){
		$res = (int)$listing[$key];
		if($res) {
			$items = get_field($key, 'option');
			$cnt = 1;
			foreach($items as $item){
				if($res === (int)$item['name'] && $cnt === count($items)) {
					$res .= "+";
				}
				$cnt++;
			}
		}

		return $res;
	}
}