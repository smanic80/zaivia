<?php
	add_filter('show_admin_bar', '__return_false');

	add_action( 'after_setup_theme', function() {
		add_image_size( 'listing-card', 321, 214 );
		add_image_size( 'listing-th', 118, 92 );
	});

	add_action( 'wp_ajax_uploadImageFile', 'uploadImageFile' );
	add_action( 'wp_ajax_nopriv_uploadImageFile', 'uploadImageFile' );
	function uploadImageFile() {
        if(isset($_REQUEST['delete'])) {
            $id = $_REQUEST['id'];
            $file = ZaiviaListings::getListingFile($id);
            $media_id = $file['media_id'];
            $media_url = $_REQUEST['delete'];
            $url = wp_get_attachment_url($media_id);
            if($media_url == $url){
                wp_delete_attachment($media_id);
            }
            exit;
        }

        if(isset($_FILES[0])) {
            $imgsize = @getimagesize($_FILES[0]['tmp_name']);
            if (!isset($imgsize) || !isset($imgsize['mime']) || !in_array($imgsize['mime'], array('image/jpeg', 'image/png'))) {
                exit;
            }
        }
        $list = [];
        $listingId = isset($_POST['listing_id']) ? (int)$_POST['listing_id'] : 0;

        if($listingId && $_FILES) {
            $list = ZaiviaListings::addListingFile($listingId, "0", ($_REQUEST["type"] ? ZaiviaListings::$file_image : ZaiviaListings::$file_blueprint));

	        $thumb = wp_get_attachment_image_src($list['media_id'], 'listing-th');
            $list['thumb'] = $thumb[0];
        }
        echo json_encode($list);
        die;
    }

	add_action( 'wp_ajax_uploadLisingFile', 'uploadLisingFile' );
	add_action( 'wp_ajax_nopriv_uploadLisingFile', 'uploadLisingFile' );
	function uploadLisingFile() {

		$list = [];
		$listingId = isset($_POST['listing_id']) ? (int)$_POST['listing_id'] : 0;
		$fileType = isset($_POST['file_type']) ? (int)$_POST['file_type'] : 0;
		
		if($listingId && $_FILES) {
			$list = ZaiviaListings::addListingFile($listingId, '0', $fileType);
		}

        echo json_encode($list);
        die;
    }

    add_action( 'wp_ajax_preloadLising', 'preloadLising' );
	add_action( 'wp_ajax_nopriv_preloadLising', 'preloadLising' );
	function preloadLising() {
		$listing_to = isset($_POST['listing_to']) ? (int)$_POST['listing_to'] : 0;
		$listing_from = isset($_POST['listing_from']) ? (int)$_POST['listing_from'] : 0;

		$listing = ZaiviaListings::duplicateListing($listing_from, $listing_to);

        echo json_encode($listing);
        die;
    }

	add_action( 'wp_ajax_valideLisingStep', 'valideLisingStep' );
	add_action( 'wp_ajax_nopriv_valideLisingStep', 'valideLisingStep' );
	function valideLisingStep() {
		$errors = [];
		if(isset($_POST['required'])) {
			foreach($_POST['required'] as $fName=>$fVal){
				if(!strlen(trim($fVal))) $errors[] = $fName;
			}
		}
		if(isset($_POST['zip'])) {
			$pattern = "/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/";
			foreach($_POST['zip'] as $fName=>$fVal){
				if($fVal && !preg_match($pattern, strtoupper(trim($fVal)))) {
					$errors[] = $fName;
				}
			}
		}

		$listingData = [
			"errors"=>$errors,
			"listing_id"=>0,
			"contact_profile"=>0,
			"contact_logo"=>0,
		];

		if(isset($_POST['listing-data'])){
			$str  = stripslashes_deep( $_POST['listing-data'] );
			$data = @json_decode( $str, true );

			if(isset($data['listing_id'])) {
				$listingData['listing_id'] = $data['listing_id'];
			}

			$listingData = [
				"contact_profile"=>isset($data['contact_profile']) ? ZaiviaListings::getListingFile((int)$data['contact_profile']) : 0,
				"contact_logo"=>isset($data['contact_logo']) ? ZaiviaListings::getListingFile((int)$data['contact_logo']) : 0,
			];

			if(!$errors) {
				$listingData = ZaiviaListings::saveListing($data);
			}
		}

		echo json_encode([
		    "errors"=>$errors,
		    "listing_id"=>$listingData['listing_id'],
            "contact_profile"=>$listingData['contact_profile'],
            "contact_logo"=>$listingData['contact_logo']
        ]);

		die;
	}

	add_action( 'wp_ajax_processLising', 'processLising' );
	add_action( 'wp_ajax_nopriv_processLising', 'processLising' );
	function processLising() {
		$res = false;
		if($_POST['listing-data']){
			$str = stripslashes_deep($_POST['listing-data']);

			$data = json_decode($str, true);

			if(isset($data['listing_id'])) {
				$res = ZaiviaListings::activateListing((int)$data['listing_id']);
			}
		}
		echo json_encode($res);
		die;
	}






	function am_array_search($search, $field, $array) {
		foreach ($array as $key => $val) {
			if ($val[$field] === $search) {
				return $key;
			}
		}
		return null;
	}