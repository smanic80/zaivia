<?php
	add_filter('show_admin_bar', '__return_false');



	add_action( 'wp_ajax_uploadLisingFile', 'uploadLisingFile' );
	add_action( 'wp_ajax_nopriv_uploadLisingFile', 'uploadLisingFile' );
	function uploadLisingFile() {
        $list = [];
        foreach($_FILES as $file)
        {
            $list[] = wp_handle_upload($file,array('test_form' => FALSE));
        }
        echo json_encode($list);
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
				if(!preg_match($pattern, strtoupper(trim($fVal)))) {
					$errors[] = $fName;
				}
			}
		}
		$listingId = 0;
		if($_POST['listing-data']){
			$str = stripslashes_deep($_POST['listing-data']);

			$data = json_decode($str, true);

			if(isset($data['listing_id'])) {
				$listingId = $data['listing_id'];
			}
			if(!$errors) {
				$listingId = ZaiviaListings::save($data);
			}
		}

		echo json_encode(["errors"=>$errors, "listing_id"=>$listingId]);

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