<?php

	if($_SERVER['HTTP_HOST'] === 'localhost') {
		add_action('phpmailer_init', 'mailtrap');
		function mailtrap($phpmailer) {
			$phpmailer->isSMTP();
			$phpmailer->Host = 'smtp.mailtrap.io';
			$phpmailer->SMTPAuth = true;
			$phpmailer->Port = 2525;
			$phpmailer->Username = '7b8da690b1c391';
			$phpmailer->Password = 'f9c40d374467d0';
		}
	}




	add_filter('show_admin_bar', '__return_false');

	add_action( 'after_setup_theme', function() {
		add_image_size( 'listing-big', 801, 534 );
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
            ZaiviaListings::saveListing($data);
			if(isset($data['listing_id'])) {
				$res = ZaiviaListings::activateListing((int)$data['listing_id']);
			}
		}
		echo json_encode($res);
		die;
	}





	add_filter( 'wp_nav_menu_items', function( $items, $args ) {
		if ($args->theme_location == 'accountmenu') {
			if (is_user_logged_in()) {
				$items .= '<li class="right"><a href="'. wp_logout_url(home_url()) .'">'. __("Log Out") .'</a></li>';
			}
		}
		return $items;
	}, 10, 2 );

	add_filter('wp_authenticate_user', function($user) {
		$data = get_user_meta($user->ID, 'activation_hash', true);
		if (!$data) {
			return $user;
		}
		return new WP_Error('ERROR','Please, activate account first' );
	}, 10, 2);


	add_action( 'init', 'am_processActivation' );
	function am_processActivation(){
		if(isset($_GET['akey'])){
			$hash = $_GET['akey'];

			$userId = (int)get_option('activation_hash_' . $_GET['akey']);
			if($userId) {
				delete_user_meta( $userId, 'activation_hash' );
				delete_option('activation_hash_' . $hash);
			}
			wp_redirect(home_url(get_field("page_account_activated", "option")));
			die;
		}
	}

	add_action( 'wp_ajax_login_form', 'login_formProcess' );
	add_action( 'wp_ajax_nopriv_login_form', 'login_formProcess' );
	function login_formProcess(){
		$creds = array(
			'user_login'    => $_POST['login_email'],
			'user_password' => $_POST['login_password'],
			'remember'      => true
		);
		$user = wp_signon( $creds, false );

		$res = [];
		if ( is_wp_error( $user ) ) {
			if('invalid_username' === $user->get_error_code()) {
				$res['error'] = __("Invalid username or password");
			} else {
				$res['error'] = $user->get_error_message();
			}
		}
		echo json_encode($res);
		die;
	}

	add_action( 'wp_ajax_create_form', 'create_formProcess' );
	add_action( 'wp_ajax_nopriv_create_form', 'create_formProcess' );
	function create_formProcess(){
		$nonce = $_POST['create_user_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'zai_create_user' ) ) {
			echo json_encode(['error'=>'Security checked!']);
		}

		$user_login = stripcslashes($_POST['create_email']);
		$user_email = stripcslashes($_POST['create_email']);
		$user_pass = stripcslashes($_POST['create_pass']);
		$create_pass_confirm = stripcslashes($_POST['create_pass_confirm']);
		$user_nice_name = implode(" ", [stripcslashes($_POST['create_firstname']), stripcslashes($_POST['create_lastname'])]);

		if($user_pass && $user_pass !== $create_pass_confirm) {
			echo json_encode(['error'=>__("Please enter the same password in both password fields.")]);
			die;
		}

		$user_data = array(
			'user_login' => $user_login,
			'user_email' => $user_email,
			'user_pass' => $user_pass,//wp_hash_password($user_pass),
			'user_nicename' => $user_login,
			'display_name' => $user_nice_name,

			'show_admin_bar_front' => 'false'
		);

		$res = [];
		$user_id = wp_insert_user($user_data);

		add_user_meta($user_id,"phone", stripcslashes($_POST['create_phone']));
		add_user_meta($user_id,"phone_type", stripcslashes($_POST['create_phonetype']));
		add_user_meta($user_id,"subscribe", isset($_POST['create_subscribe'])?1:0);

		add_user_meta($user_id,"first_name", $_POST['create_firstname']);
		add_user_meta($user_id,"last_name", $_POST['create_lastname']);

		if (is_wp_error($user_id)) {
			$res['error'] = $user_id->get_error_message();
		} else {
			am_setAndSendActivation($user_id, $user_pass);
		}

		echo json_encode($res);
		die;
	}

	add_action( 'wp_ajax_restore_form', 'restore_formProcess' );
	add_action( 'wp_ajax_nopriv_restore_form', 'restore_formProcess' );
	function restore_formProcess() {
		$res = [];

		$user_info = get_user_by("email", $_POST['restore_email']);
		if($user_info) {
			$to = $user_info->user_email;

			$pw = wp_generate_password(6);
			wp_update_user([
				"ID" => $user_info->user_id,
				"user_pass" => $pw
			]);

			$subject = 'Password restoration';
			$message = 'Hello, '.$user_info->display_name;
			$message .= "<br>";
			$message .= 'You new password is <b>' . $pw . '</b>';

			$headers = '';
			add_filter('wp_mail_content_type', 'am_html_email');
			wp_mail( $to, $subject, $message, $headers );
			remove_filter('wp_mail_content_type', 'am_html_email');
		} else {
			$res['error'] = __("Email not found.");
		}

		echo json_encode($res);
		die;
	}


	add_action( 'wp_ajax_getListings', 'getListings' );
	add_action( 'wp_ajax_nopriv_getListings', 'getListings' );
	function getListings() {
	    echo json_encode(ZaiviaListings::search($_REQUEST));
	    die;
	}

	add_action( 'wp_ajax_getFavListings', 'getFavListings' );
	add_action( 'wp_ajax_nopriv_getFavListings', 'getFavListings' );
	function getFavListings() {
	    echo json_encode(ZaiviaListings::favorite($_REQUEST));
	    die;
	}

	add_action( 'wp_ajax_saveSearch', 'saveSearch' );
	add_action( 'wp_ajax_nopriv_saveSearch', 'saveSearch' );
	function saveSearch() {
		$request = $_REQUEST;
		unset($request['action']);
		echo json_encode(update_user_meta(get_current_user_id(),'saved_search',$request));
		die;
	}

	add_action( 'wp_ajax_getMarket', 'getMarket' );
	add_action( 'wp_ajax_nopriv_getMarket', 'getMarket' );
	function getMarket() {
		echo json_encode(ZaiviaListings::getMarket(intval($_REQUEST['id'])));
		die;
	}


	function am_setAndSendActivation($userId, $pw){
		$hash = wp_generate_password();

		add_user_meta( $userId, 'activation_hash', $hash );
		add_option('activation_hash_' . $hash, $userId);

		$user_info = get_userdata($userId);

		$activationLink = home_url('/').'activate?akey='.$hash;

		$to = $user_info->user_email;
		$subject = 'Member Verification';
		$message = 'Hello, '.$user_info->display_name;
		$message .= "<br>";
		$message .= 'You password is <b>' . $pw . '</b>';
		$message .= "<br><br>";
		$message .= 'Please click this link to activate your account:';
		$message .= '<a href="' . $activationLink . '">'. $activationLink .'</a>';

		$headers = '';
		add_filter('wp_mail_content_type', 'am_html_email');
		wp_mail( $to, $subject, $message, $headers );
		remove_filter('wp_mail_content_type', 'am_html_email');
	}


	function am_html_email(){ return "text/html"; }

	function am_array_search($search, $field, $array) {
		foreach ($array as $key => $val) {
			if ($val[$field] === $search) {
				return $key;
			}
		}
		return null;
	}
