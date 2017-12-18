<?php
	add_filter('show_admin_bar', '__return_false');


    function createThumbnail( $imageName, $thumbWidth, $quality = 100)
    {
        $editor = wp_get_image_editor( $imageName );
        if ( is_wp_error( $editor ) )
            return $editor;
        $editor->set_quality( $quality );

        $resized = $editor->resize( $thumbWidth, $thumbWidth );
        if ( is_wp_error( $resized ) )
            return $resized;

        $dest_file = $editor->generate_filename();
        $saved = $editor->save( $dest_file );

        if ( is_wp_error( $saved ) )
            return $saved;

        $uploads = wp_upload_dir();

        return $uploads['url'].'/'.wp_basename($dest_file);
    }

	add_action( 'wp_ajax_uploadImageFile', 'uploadImageFile' );
	add_action( 'wp_ajax_nopriv_uploadImageFile', 'uploadImageFile' );
	function uploadImageFile() {
        if(isset($_REQUEST['delete']))
        {
            $id = $_REQUEST['id'];
            $file = ZaiviaListings::getListingFile($id);
            $media_id = $file['media_id'];
            $media_url = $_REQUEST['delete'];
            $url = wp_get_attachment_url($media_id);
            if($media_url == $url){
                wp_delete_attachment($media_id);
                //todo delete thumbnails
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
            $list = ZaiviaListings::addListingFile($listingId, ($_REQUEST["type"]?ZaiviaListings::$file_image:ZaiviaListings::$file_blueprint));

            if((int)$_REQUEST["thumbnail_size"] > 0){
                $list['thumb'] = createThumbnail($list['path'], $_REQUEST["thumbnail_size"], 100);
            }
        }
        echo json_encode($list);
        die;
    }

	add_action( 'wp_ajax_uploadLisingFile', 'uploadLisingFile' );
	add_action( 'wp_ajax_nopriv_uploadLisingFile', 'uploadLisingFile' );
	function uploadLisingFile() {
		$list = [];
		$listingId = isset($_POST['listing_id']) ? (int)$_POST['listing_id'] : 0;
		if($listingId && $_FILES) {
			$list = ZaiviaListings::addListingFile($listingId, ZaiviaListings::$file_rent);
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