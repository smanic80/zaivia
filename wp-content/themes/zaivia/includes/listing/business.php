<?php

class ZaiviaBusiness extends listing_base{
	public static $type_banner = 0;
	public static $type_card = 1;



	public static $banner_radius = 10;


	public static function getUserEntities($userId, $entity, $entityId = null, $status='any'){
		$args = [
			'author' => (int)$userId,
			'post_type' => $entity,
			'post_status' => $status,
			'nopaging' => true,
		];
		if($entityId) {
			$args['p'] = [(int)$entityId];
		}
		$res = [];
		$items = get_posts($args);
		foreach($items as $item) {
			$res[] = [
				'id' => $item->ID,
				'banner_title' => $item->post_title,
				'date_created' => $item->post_date,
				'date_renewal' => get_post_meta($item->ID,"date_renewal"),
				'url' => get_post_meta($item->ID,"url"),
				'section' => get_post_meta($item->ID,"section"),
				'community' => get_post_meta($item->ID,"community"),
				'duration' => get_post_meta($item->ID,"duration"),
				'geo' => get_post_meta($item->ID,"geo"),
			];
		}
		return get_posts($args);
	}


	public static function addBanner($request){
		global $wpdb;

		$geo_tablename = $wpdb->prefix . self::$geo_tablename;

		$user_id = get_current_user_id();

		$editPostId = isset($request['id']) ? (int)$request['id'] : 0;
		$mediaId = (int)$request['banner_upload_input_media'];

		$banner_title = stripcslashes($request['banner_title']);
		$banner_url = stripcslashes($request['banner_url']);
		$banner_section = stripcslashes($request['banner_section']);
		$duration_checked = (int)$request['duration_checked'];

		$banner_community = stripcslashes($request['banner_community']);

		if(!self::isOwner($user_id, $editPostId, ZaiviaBusiness::$posttype_banner)) {
			return ['error'=>'This is not yours!'];
		}
		if(!$mediaId) {
			return ['error'=>'Image not selected'];
		}
		$geo = self::getCityCoords($banner_community, self::$banner_radius);
		if(!$geo) {
			return ['error'=>'Can not find community geo coordinates'];
		}

		$data = [
			'ID' => $editPostId,
			'post_type' => ZaiviaBusiness::$posttype_banner,
			'post_title' => $banner_title,
			'post_author' => $user_id,
		];
		$postId = wp_insert_post($data, true);

		$res = [];
		if (is_wp_error($postId)) {
			$res['error'] = $postId->get_error_message();
		} else {
			update_post_meta($postId,"url", $banner_url);
			update_post_meta($postId,"section", $banner_section);
			update_post_meta($postId,"community", $banner_community);
			update_post_meta($postId,"duration", $duration_checked);
			update_post_meta($postId,"geo", $geo);
			set_post_thumbnail( $postId, $mediaId );

			$geoId = (int)$wpdb->get_var($wpdb->prepare("select geo_id FROM $geo_tablename where post_id = %d", $postId) );
			$preparedData = [
				'lat' => $geo['lat'],
				'lng' => $geo['lng'],
				'address' => $banner_community,
			];
			if($geoId) {
				$wpdb->update($geo_tablename, $preparedData, ["geo_id" => $geoId]);
			} else {
				$preparedData['post_id'] = $postId;
				$preparedData['type'] = self::$type_banner;
				$wpdb->insert($geo_tablename, $preparedData);
			}
		}

		return $res;
	}

	public static function activateItem($itemId, $entity){
		global $wpdb;
		$files_tablename = $wpdb->prefix . self::$listing_tablename;

		$userId = get_current_user_id();
		if(!self::isOwner($userId, $itemId, $entity)) {
			return 'This is not yours!';
		}

		$data = [
			'ID' => $itemId,
			'post_type' => $entity,
			'post_status' => 'publish'
		];
		$postId = wp_insert_post($data, true);

		$res = [];
		if (is_wp_error($postId)) {
			$res['error'] = $postId->get_error_message();
		} else {
			$duration = (int)get_post_meta($postId,"duration");

			$date_renewal = date('Y-m-d', strtotime("+".$duration." months"));

			update_post_meta($postId,"date_renewal", $date_renewal);
		}





		$listing = self::getUserListings(get_current_user_id(), $listingId);
		$curDate = date('Y-m-d H:i:s', time());

		$preparedData = [
			'activated'=>1,
			'date_published' => $curDate,
		];
		if($listing['to_delete'] === '1') {
			$preparedData['to_delete'] = 0;
			$preparedData['date_created'] = $curDate;
		}
		if($listing['featured'] === '1') $preparedData['featured_date'] = $curDate;
		if($listing['premium'] === '1') $preparedData['premium_date'] = $curDate;
		if($listing['url'] === '1') $preparedData['url_date'] = $curDate;
		if($listing['bump_up'] === '1') $preparedData['bump_up'] = $curDate;

		return (bool) $wpdb->update($files_tablename, $preparedData, ['listing_id' => $listingId]);
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
			'author' => $user_id
		]);
		foreach ($unusedAttachments as $post) {
			wp_delete_post($post->ID);
		}

		$mediaId = media_handle_upload(0, 0);

		if(is_wp_error($mediaId)) {
			$results['error'] = "Media creation error";
		} else {
			$filename = basename(get_attached_file( $mediaId));
			$fileurl = wp_get_attachment_url($mediaId);

			$results = ['media_id'=>$mediaId, 'name' => $filename, 'url' => $fileurl];
		}

		return $results;
	}

	public static function isOwner($userId, $id, $entity) {
		if(!$id) return true;
		return (bool)count(self::getUserEntities($userId, $entity, $id));
	}
}


