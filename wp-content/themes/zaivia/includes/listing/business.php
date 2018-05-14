<?php

class ZaiviaBusiness extends listing_base{
	public static $type_banner = 0;
	public static $type_card = 1;

	public static $image_key_profile = 'card_profile_image';
	public static $image_key_logo = 'card_business_image';


	public static $banner_radius = 50;

	public static function findBanners($section, $city) {
		$res = [];

		if(!$city) return $res;
		$geo = self::getCityCoords($city);
		if(!$geo) return $res;

		$res = self::getBanner($section, $geo['lat'], $geo['lng']);

		return $res;
	}

	public static function getBanner($section, $lat, $lng){
		global $wpdb;

		$geo_tablename = $wpdb->prefix . self::$geo_tablename;
		$posts_tablename = $wpdb->prefix . "posts";
		$postmeta_tablename = $wpdb->prefix . "postmeta";

		$res = [];
		$sql = "select {$geo_tablename}.post_id from {$geo_tablename} 
			join {$posts_tablename} on {$geo_tablename}.post_id = ID and post_status = 'publish'
			join {$postmeta_tablename} on {$postmeta_tablename}.post_id = {$geo_tablename}.post_id and meta_key = 'section' and meta_value = '{$section}'
			where " . self::getGeoRadiusSql($lat, $lng, self::$banner_radius) . "
			order by rand()
			limit 1";
		$posts = $wpdb->get_col($sql);
		if($posts) {
			$postId = $posts[0];
			$media = get_attached_media("image", $postId);
			$image = array_shift($media);

			$res = [
				'list_banner_url' => get_post_meta($postId, 'url', true),
				'list_banner_image' => ($image ? wp_get_attachment_url($image->ID) : "")
			];
		}

		return $res;
	}

	public static function addBanner($request){
		$user_id = get_current_user_id();

		$editPostId = isset($request['entity_id']) ? (int)$request['entity_id'] : 0;
		if(!self::isOwner($user_id, $editPostId, ZaiviaBusiness::$posttype_banner)) {
			return ['error'=>__('This is not yours!')];
		}

		$mediaId = (int)$request['banner_image_upload_input_media'];
		if(!$mediaId) {
			return ['error'=>__('Image not selected')];
		}

		$banner_community = stripcslashes($request['banner_community']);
		$geo = self::getCityCoords($banner_community);
		if(!$geo) {
			return ['error'=>__('Can not find community geo coordinates')];
		}

		$data = [
			'ID' => $editPostId,
			'post_type' => ZaiviaBusiness::$posttype_banner,
			'post_title' => sanitize_text_field($request['banner_title']),
			'post_author' => $user_id,
		];
		if($editPostId) {
			$postId = wp_update_post($data, true);
		} else {
			$postId = wp_insert_post($data, true);
		}

		$res = [];
		if (is_wp_error($postId)) {
			$res['error'] = $postId->get_error_message();
		} else {
			update_post_meta($postId,"url", esc_url($request['banner_url']));
			update_post_meta($postId,"section", sanitize_text_field($request['banner_section']));
			update_post_meta($postId,"community", $banner_community);
			update_post_meta($postId,"duration", (int)$request['duration_checked']);
			update_post_meta($postId,"geo", $geo);

			self::updateBusinessFile($postId, $mediaId, ZaiviaListings::$image_key);
			self::updateBusinessGeo($postId, $geo, $banner_community);

			$res = $postId;
		}

		return $res;
	}

	public static function addCard($request){
		$user_id = get_current_user_id();

		$editPostId = isset($request['entity_id']) ? (int)$request['entity_id'] : 0;
		if(!self::isOwner($user_id, $editPostId, ZaiviaBusiness::$posttype_card)) {
			return ['error'=>'This is not yours!'];
		}

		$profile_imageId = (int)$request['card_profile_image_upload_input_media'];
		$business_imageId = (int)$request['card_business_image_upload_input_media'];
		if(!$profile_imageId || !$business_imageId) {
			return ['error'=>'Profile image or business logo not selected'];
		}

		$card_city = sanitize_text_field($request['card_city']);
		$geo = self::getCityCoords($card_city);

		if(!$geo) {
			return ['error'=>'Can not find community geo coordinates'];
		}

		$card_first_name = sanitize_text_field($request['card_first_name']);
		$card_last_name = sanitize_text_field($request['card_last_name']);
		$card_company = sanitize_text_field($request['card_company']);
		$card_job_title = sanitize_text_field($request['card_job_title']);

		$data = [
			'ID' => $editPostId,
			'post_type' => ZaiviaBusiness::$posttype_card,
			'post_title' => implode(" ", [$card_first_name, $card_last_name]).', '.$card_job_title." at ".$card_company,
			'post_author' => $user_id,
		];
		if($editPostId) {
			$postId = wp_update_post($data, true);
		} else {
			$postId = wp_insert_post($data, true);
		}

		$res = [];
		if (is_wp_error($postId)) {
			$res['error'] = $postId->get_error_message();
		} else {
			update_post_meta($postId,"card_first_name", $card_first_name);
			update_post_meta($postId,"card_last_name", $card_last_name);
			update_post_meta($postId,"card_company", $card_company);
			update_post_meta($postId,"card_company_show", (int)$request['card_company_show']);
			update_post_meta($postId,"card_job_title", $card_job_title);
			update_post_meta($postId,"card_email", sanitize_email($request['card_email']));
			update_post_meta($postId,"card_phone", sanitize_text_field($request['card_phone']));
			update_post_meta($postId,"card_phone_type", sanitize_text_field($request['card_phone_type']));
			update_post_meta($postId,"card_phone2", sanitize_text_field($request['card_phone2']));
			update_post_meta($postId,"card_phone2_type", sanitize_text_field($request['card_phone2_type']));
			update_post_meta($postId,"card_industry", sanitize_text_field($request['card_industry']));
			update_post_meta($postId,"card_sponsor", (int)$request['card_sponsor']);
			update_post_meta($postId,"card_address", sanitize_text_field($request['card_address']));
			update_post_meta($postId,"card_city", $card_city);
			update_post_meta($postId,"card_zip", sanitize_text_field($request['card_zip']));
			update_post_meta($postId,"card_url_show", (int)$request['card_url_show']);
			update_post_meta($postId,"card_url", esc_url($request['card_url']));
			update_post_meta($postId,"card_comments", sanitize_text_field($request['card_comments']));
			update_post_meta($postId,"card_featured", (int)$request['card_featured']);

			update_post_meta($postId,"duration", (int)$request['duration_checked']);
			update_post_meta($postId,"geo", $geo);

			self::updateBusinessFile($postId, $profile_imageId, ZaiviaBusiness::$image_key_profile);
			self::updateBusinessFile($postId, $business_imageId, ZaiviaBusiness::$image_key_logo);
			self::updateBusinessGeo($postId, $geo, $card_city);

			$res = $postId;
		}

		return $res;
	}

	public static function activateBusiness($itemId){
		$userId = get_current_user_id();
		$type = get_post_type($itemId);

		if(!self::isOwner($userId, $itemId, $type)) {
			return __('This is not yours!');
		}

		wp_publish_post($itemId);

		$duration = (int)get_post_meta($itemId, "duration");
		if($type === ZaiviaBusiness::$posttype_banner) {
			$date_renewal = self::calculateEndDate($itemId, $duration, ["date_renewal"]);
			update_post_meta($itemId,"date_renewal", $date_renewal);
		} else {
			$dates = self::calculateEndDate($itemId, $duration, ["card_sponsor_date", "card_url_show_date", "card_featured_date"]);
			foreach($dates as $key=>$date) {
				update_post_meta($itemId, $key, $date);
			}
			update_post_meta($itemId,"card_sponsor", 0);
			update_post_meta($itemId,"card_url_show", 0);
			update_post_meta($itemId,"card_featured", 0);
		}

		update_post_meta($itemId,"duration", 0);
		return true;
	}

	public static function getEntities($entity, $entityId = null, $userId = null, $status='any'){
		$args = [
			'author' => (int)$userId,
			'post_type' => $entity,
			'post_status' => $status,
			'nopaging' => true,
		];
		if($entityId) {
			$args['post__in'] = [(int)$entityId];
		}
		$items = get_posts($args);

		$results = [];
		foreach($items as $item) {

			$tmp = [
				'id' => $item->ID,
				'title' => $item->post_title,
				'date_created' => $item->post_date,
				'date_renewal' => ($item->post_status === 'publish') ? get_post_meta($item->ID,"date_renewal", true) : "",
			];

			$medias = get_attached_media("image", $item->ID);
			foreach($medias as $media) {
				$filetype = get_post_meta($media->ID, "filetype", true);

				$tmp[$filetype.'_id'] =  $media->ID;
				$tmp[$filetype.'_url'] = wp_get_attachment_url( $media->ID);
			}

			$tmp['duration'] = get_post_meta($item->ID,"duration", true);
			$tmp['geo'] = get_post_meta($item->ID,"geo", true);

			if($entity === self::$posttype_banner) {
				$tmp['url'] = get_post_meta($item->ID,"url", true);
				$tmp['section'] = get_post_meta($item->ID,"section", true);
				$tmp['community'] = get_post_meta($item->ID,"community", true);
			}

			if($entity === self::$posttype_card) {
				$tmp['card_first_name'] = get_post_meta($item->ID,"card_first_name", true);
				$tmp['card_last_name'] = get_post_meta($item->ID,"card_last_name", true);
				$tmp['card_company'] = get_post_meta($item->ID,"card_company", true);
				$tmp['card_company_show'] = get_post_meta($item->ID,"card_company_show", true);
				$tmp['card_job_title'] = get_post_meta($item->ID,"card_job_title", true);
				$tmp['card_email'] = get_post_meta($item->ID,"card_email", true);
				$tmp['card_phone'] = get_post_meta($item->ID,"card_phone", true);
				$tmp['card_phone_type'] = get_post_meta($item->ID,"card_phone_type", true);
				$tmp['card_phone2'] = get_post_meta($item->ID,"card_phone2", true);
				$tmp['card_phone2_type'] = get_post_meta($item->ID,"card_phone2_type", true);
				$tmp['card_industry'] = get_post_meta($item->ID,"card_industry", true);
				$tmp['card_sponsor'] = get_post_meta($item->ID,"card_sponsor", true);
				$tmp['card_address'] = get_post_meta($item->ID,"card_address", true);
				$tmp['card_city'] = get_post_meta($item->ID,"card_city", true);
				$tmp['card_zip'] = get_post_meta($item->ID,"card_zip", true);
				$tmp['card_url_show'] = get_post_meta($item->ID,"card_url_show", true);
				$tmp['card_url'] = get_post_meta($item->ID,"card_url", true);
				$tmp['card_comments'] = get_post_meta($item->ID, 'card_comments', true);
				$tmp['card_featured'] = get_post_meta($item->ID,"card_featured", true);

				$tmp['card_sponsor_date'] = get_post_meta($item->ID,"card_sponsor_date", true);
				$tmp['card_url_date'] = get_post_meta($item->ID,"card_url_date", true);
				$tmp['card_featured_date'] = get_post_meta($item->ID,"card_featured_date", true);
			}

			$results[] = $tmp;
		}

		if($entityId) {
			$res = isset( $results[0] ) ? $results[0] : null;
		} else {
			$res = $results;
		}
		return $res;
	}

	public static function deleteEntity($id) {
		global $wpdb;

		$geo_tablename = $wpdb->prefix . self::$geo_tablename;
		$wpdb->delete($geo_tablename, ["post_id"=>$id] );

		$post_attachments = get_children(['post_parent' => $id]);
		if($post_attachments) {
			foreach ($post_attachments as $attachment) {
				wp_delete_attachment($attachment->ID, true);
			}
		}

		wp_delete_post($id, true);

		return true;
	}



	public static function addBusinessFile($user_id){
		if ( ! function_exists( 'media_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
		}

		$unusedAttachments = get_posts([
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => 0,
			'author' => $user_id,
			'meta_query' => [[
				'key'     => 'listing_file',
				'compare' => 'NOT EXISTS'
			]]
		]);

		foreach ($unusedAttachments as $post) {
			wp_delete_attachment( $post->ID, true );
		}

		$mediaId = media_handle_upload(0, 0);

		if(is_wp_error($mediaId)) {
			$results['error'] = __("Media creation error");
		} else {
			$filename = basename(get_attached_file( $mediaId));
			$fileurl = wp_get_attachment_url($mediaId);

			$results = ['media_id'=>$mediaId, 'name' => $filename, 'url' => $fileurl];
		}

		return $results;
	}

	public static function calculatePrice( $entity_id ) {
		$price = 0;
		if(get_post_type($entity_id) === ZaiviaBusiness::$posttype_banner) {
			$months = get_post_meta($entity_id,"duration", true);
			$price = (float)get_field("banner_price", "option");
			$durations = get_field("banner_duration", "option");
			$discount = 0;
			foreach($durations as $duration) {
				if((int)$duration['months'] === $months) {
					$discount = (int)$duration['discount'];
				}
			}

			$price = $price * $months - ($price * $months * $discount / 100);
		}

		if(get_post_type($entity_id) === ZaiviaBusiness::$posttype_card) {
			$months = get_post_meta($entity_id,"duration", true);

			$sponsor_price = (float)get_field("card_sponsor_price", "option");
			$sponsor_checked = (int)get_post_meta($entity_id,"card_sponsor", true);

			$link_price = (float)get_field("card_link_price", "option");
			$link_checked = (int)get_post_meta($entity_id,"card_url_show", true);

			$featured_price = (float)get_field("card_featured_price", "option");
			$featured_checked = (int)get_post_meta($entity_id,"card_featured", true);

			$price = [];
			if($sponsor_checked) $price['sponsor'] = $sponsor_price * $months;
			if($link_checked) $price['link'] = $link_price * $months;
			if($featured_checked) $price['featured'] = $featured_price * $months;
		}

		return $price;
	}

	public static function calculateEndDate($entity_id, $duration, $keys) {
		if(!$duration) return '';

		$startDates = [];
		$published = ($entity_id && get_post_status($entity_id) === 'publish');
		foreach($keys as $key) {
			if($published) {
				$startDates[$key] = get_post_meta($entity_id, $key, true);
			}
			if(!isset($startDates[$key])) {
				$startDates[$key] = time();
			}
		}

		$date_renewal = null;
		$timestamp = [];
		foreach($startDates as $key=>$startDate) {
			$newDate = strtotime('+'.$duration.' months', $startDate);
			$timestamp[$key] = $newDate;
			if(!$date_renewal || $date_renewal > $startDate) {
				$date_renewal = $newDate;
			}
		}
		$timestamp['date_renewal'] = $date_renewal;

		return $timestamp;
	}

	public static function isOwner($userId, $id, $entity) {
		if(!$id) return true;
		return (bool)count(self::getEntities($entity, $id, $userId));
	}

	public static function listingContactToCard($data) {
		$first_name = $last_name = "";
		if($data['contact_name_show']) {
			list($first_name, $last_name) = explode(" ", $data['contact_name']);
		}

		$res = [
			"card_first_name" => $first_name,
			"card_last_name" => $last_name,
			"card_job_title" => __("Agent"),
			"card_company" => $data['contact_company'],
			"card_phone" => $data['contact_phone1_show'] ? $data['contact_phone1'] : "",
			"card_phone_type" => $data['contact_phone1_show'] ? $data['contact_phone1_type'] : "",
			"card_phone2" => $data['contact_phone2_show'] ? $data['contact_phone2'] : "",
			"card_phone2_type" => $data['contact_phone2_show'] ? $data['contact_phone2_type'] : "",
			"card_email" => $data['contact_email'],

			"card_address" => $data['contact_address'],
			"card_city"=> $data['contact_city'],

			"card_profile_image_url" => isset($data['contact_profile']['contact_card_profile']) ? $data['contact_profile']['contact_card_profile'] : "",
			"card_business_image_url" => isset($data['contact_logo']['contact_card_logo']) ? $data['contact_logo']['contact_card_logo'] : "",
		];

		return $res;
	}

	public static function renderCard($data) {
		if(isset($data['card_lat']) && isset($data['card_lng']) ) {
			$data["card_address_query"] = $data['card_lat'].",".$data['card_lng'];
		} elseif(isset($data['card_city']) || isset($data['card_address'])) {
			$data["card_address_query"] = $data['card_city'].",".$data['card_address'];
		}
		ob_start();
		include(get_template_directory() . "/templates/business-card.php");
		return ob_get_clean();
	}

	private static function updateBusinessFile($postId, $mediaId, $filetype){
		$unusedAttachments = get_posts([
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_parent' => $postId,
			'meta_query' => [[
				'key'     => 'filetype',
				'value'   => $filetype,
				'compare' => '=',
			]]
		]);
		foreach ($unusedAttachments as $post) {
			if($mediaId !== $post->ID) {
				wp_delete_attachment( $post->ID, true );
			}
		}
		wp_update_post( ['ID' => $mediaId, 'post_parent' => $postId ]);
		add_post_meta($mediaId, "filetype", $filetype);

		return true;
	}

	private static function updateBusinessGeo($postId, $geo, $address){
		global $wpdb;

		$geo_tablename = $wpdb->prefix . self::$geo_tablename;

		$geoId = (int)$wpdb->get_var($wpdb->prepare("select geo_id FROM $geo_tablename where post_id = %d", $postId) );
		$preparedData = [
			'lat' => $geo['lat'],
			'lng' => $geo['lng'],
			'address' => $address,
		];
		if($geoId) {
			$wpdb->update($geo_tablename, $preparedData, ["geo_id" => $geoId]);
		} else {
			$preparedData['post_id'] = $postId;
			$preparedData['type'] = self::$type_banner;
			$wpdb->insert($geo_tablename, $preparedData);
		}

		return true;
	}
}
