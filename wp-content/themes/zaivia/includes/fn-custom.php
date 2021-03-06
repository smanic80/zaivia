<?php
    define('RECAPTCHA','6Le5j0sUAAAAAAdb5rywayv-8rFFESAwgCY60rXt');
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

		add_image_size( 'banner', 728, 90, true );
		add_image_size( 'partner_industry', 118, 100, true );

		add_image_size( 'contact_card-profile', 120, 150);
		add_image_size( 'contact_card-logo', 100, 50);
	});



    add_action( 'init', function() {
        $args = [
            'labels'             => [
	            'name'               => __('Contact Cards', 'am'),
	            'singular_name'      => __('Contact Card', 'am'),
	            'menu_name'          => __('Contact Cards', 'am'),
	            'name_admin_bar'     => __('Contact Card', 'am'),
	            'add_new'            => __('Add New Contact Card', 'am'),
	            'add_new_item'       => __('Add New Contact Card', 'am' ),
	            'new_item'           => __( 'New Contact Card', 'am' ),
	            'edit_item'          => __( 'Edit Contact Card', 'am' ),
	            'view_item'          => __( 'View Contact Card', 'am' ),
	            'all_items'          => __( 'All Contact Cards', 'am' ),
	            'search_items'       => __( 'Search Contact Cards', 'am' ),
	            'parent_item_colon'  => __( 'Parent Contact Cards:', 'am' ),
	            'not_found'          => __( 'No Contact Cards found.', 'am' ),
	            'not_found_in_trash' => __( 'No Contact Cards found in Trash.', 'am' )
            ],
            'description'        => __( 'Description.', 'am' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'contact-card'],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'supports'           => ['title', 'editor', 'author', 'thumbnail']
        ];
        register_post_type( ZaiviaBusiness::$posttype_card, $args );

	    $args = [
		    'labels'             => [
			    'name'               => __('Banners', 'am'),
			    'singular_name'      => __('Banner', 'am'),
			    'menu_name'          => __('Banners', 'am'),
			    'name_admin_bar'     => __('Banner', 'am'),
			    'add_new'            => __('Add New Banner', 'am'),
			    'add_new_item'       => __('Add New Banner', 'am' ),
			    'new_item'           => __( 'New Banner', 'am' ),
			    'edit_item'          => __( 'Edit Banner', 'am' ),
			    'view_item'          => __( 'View Banner', 'am' ),
			    'all_items'          => __( 'All Banners', 'am' ),
			    'search_items'       => __( 'Search Banners', 'am' ),
			    'parent_item_colon'  => __( 'Parent Banners:', 'am' ),
			    'not_found'          => __( 'No Banners found.', 'am' ),
			    'not_found_in_trash' => __( 'No Banners found in Trash.', 'am' )
		    ],
		    'description'        => __( 'Description.', 'am' ),
		    'public'             => true,
		    'publicly_queryable' => true,
		    'show_ui'            => true,
		    'show_in_menu'       => true,
		    'query_var'          => true,
		    'rewrite'            => ['slug' => 'banner'],
		    'capability_type'    => 'post',
		    'has_archive'        => true,
		    'hierarchical'       => false,
		    'menu_position'      => 5,
		    'supports'           => ['title', 'author', 'thumbnail']
	    ];
	    register_post_type( ZaiviaBusiness::$posttype_banner, $args );

	    /*$tx_args = array(
		    'hierarchical' => false,
		    'labels' => [
			    'name' => __('Industry', 'am'),
			    'singular_name' => __('Industry', 'am'),
			    'search_items' => __('Search Industry', 'am'),
			    'all_items' => __('All Industries', 'am'),
			    'edit_item' => __('Edit Industry', 'am'),
			    'update_item' => __('Update Industry', 'am'),
			    'add_new_item' => __('Add New Industry', 'am'),
			    'new_item_name' => __('New Industry Name', 'am'),
			    'menu_name' => __('Industry', 'am'),
		    ],
		    'show_ui' => true,
		    'show_admin_column' => true,
		    'query_var' => true,
		    'rewrite' => array('slug' => 'industry-category'),
	    );
	    register_taxonomy('industry-category', ['contact-card'], $tx_args);

	    $tx_args = array(
		    'hierarchical' => false,
		    'labels' => [
			    'name' => __('Section', 'am'),
			    'singular_name' => __('Section', 'am'),
			    'search_items' => __('Search Section', 'am'),
			    'all_items' => __('All Sections', 'am'),
			    'edit_item' => __('Edit Section', 'am'),
			    'update_item' => __('Update Section', 'am'),
			    'add_new_item' => __('Add New Section', 'am'),
			    'new_item_name' => __('New Section Name', 'am'),
			    'menu_name' => __('Section', 'am'),
		    ],
		    'show_ui' => true,
		    'show_admin_column' => true,
		    'query_var' => true,
		    'rewrite' => array('slug' => 'section-category'),
	    );
	    register_taxonomy('section-category', ['banner'], $tx_args);*/


	    $args = [
		    'labels'             => [
			    'name'               => __('Discounts', 'am'),
			    'singular_name'      => __('Discount', 'am'),
			    'menu_name'          => __('Discounts', 'am'),
			    'name_admin_bar'     => __('Discount', 'am'),
			    'add_new'            => __('Add New Discount', 'am'),
			    'add_new_item'       => __('Add New Discount', 'am' ),
			    'new_item'           => __( 'New Discount', 'am' ),
			    'edit_item'          => __( 'Edit Discount', 'am' ),
			    'view_item'          => __( 'View Discount', 'am' ),
			    'all_items'          => __( 'All Discounts', 'am' ),
			    'search_items'       => __( 'Search Discounts', 'am' ),
			    'parent_item_colon'  => __( 'Parent Discounts:', 'am' ),
			    'not_found'          => __( 'No Discounts found.', 'am' ),
			    'not_found_in_trash' => __( 'No Discounts found in Trash.', 'am' )
		    ],
		    'description'        => __( 'Description.', 'am' ),

            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_nav_menus' => true,
		    'show_ui' => true,
		    'rewrite'            => ['slug' => 'discount'],
		    'capability_type'    => 'post',
		    'has_archive'        => false,
		    'hierarchical'       => false,
		    'menu_position'      => 5,
		    'supports'           => ['title', 'editor']
	    ];
	    register_post_type( ZaiviaBusiness::$posttype_discount, $args );
    });

    add_action('template_redirect', function(){
	    if (is_single()) {
		    global $post;

		    if (is_administrator() && $post->post_type === ZaiviaBusiness::$posttype_banner) {
		        wp_redirect(get_field("page_postbanner", "option") . "?edit={$post->ID}");
		        die;
		    }
	    }
    });

    add_action( 'init', 'am_processCron' );
    function am_processCron(){
        $cronKey = get_field("cron_key", "option");
        if(isset($_GET[$cronKey])) {
	        listing_base::maintenance();
        }
    }

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

	add_action( 'wp_ajax_validateListingStep', 'validateListingStep' );
	add_action( 'wp_ajax_nopriv_validateListingStep', 'validateListingStep' );
	function validateListingStep() {
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

			$listingData["contact_profile"] = isset($data['contact_profile']) ? ZaiviaListings::getListingFile((int)$data['contact_profile']) : 0;
			$listingData["contact_logo"] = isset($data['contact_logo']) ? ZaiviaListings::getListingFile((int)$data['contact_logo']) : 0;

			if(!$errors) {
				$listingData = ZaiviaListings::saveListing($data);
			}
		}
        if(is_array($listingData)) {
		    $res = [
			    "errors"=>$errors,
			    "listing_id"=>$listingData['listing_id'],
			    "contact_profile"=>$listingData['contact_profile'],
			    "contact_logo"=>$listingData['contact_logo']
		    ];
        } else {
	        $res = [
		        "errors"=>["common-error"=>$listingData]
            ];
        }

		echo json_encode($res);
		die;
	}

    add_action( 'wp_ajax_calculateTraitDate', 'calculateTraitDate' );
    add_action( 'wp_ajax_nopriv_calculateTraitDate', 'calculateTraitDate' );
    function calculateTraitDate() {
	    $listing_id = (int)$_REQUEST['listing_id'];
	    $trait = $_REQUEST['trait'];
        $ch = $_REQUEST['ch'];

	    $userId = is_administrator() ? false : get_current_user_id();
	    $listing = ZaiviaListings::getListings($listing_id, $userId);
	    $listing[$trait] = $ch ? 1 : 0;
	    $date = ZaiviaListings::calculateTraitDate($trait, $listing);

        echo json_encode(ZaiviaListings::formatDate($date));
        die;
    }

	add_action( 'wp_ajax_processLising', 'processLising' );
	add_action( 'wp_ajax_nopriv_processLising', 'processLising' );
	function processLising() {
		$res = [];

		if($_POST['listing-data']){
			$str = stripslashes_deep($_POST['listing-data']);

			$data = json_decode($str, true);
			if ( !isset( $data['listing_id'] ) ) {
				$res["payment_error"] = __("Listing id not set");
			}

            $saveRes = ZaiviaListings::saveListing($data);
            if(!is_array($saveRes)) {
	            $res["payment_error"] = $saveRes;
            } else {
                $listing_id = intval( $data['listing_id'] );
                if(!is_administrator()) {
	                $proces = ZaiviaListings::calculatePrice( $listing_id );
	                $payed  = am_processPayment( $data, $proces['total'] );
                } else {
	                $payed = true;
                }
	            if ($payed === true ) {
		            update_user_meta(get_current_user_id(), "listing_source", $data['source']);
		            if ( ! ZaiviaListings::activateListing( $listing_id ) ) {
			            $res["payment_error"] = __("Activation Error");
		            }
	            } else {
                    $res = $payed;
                }
            }
		}
		echo json_encode($res);
		die;
	}

    add_action( 'wp_ajax_on_off_listing', 'on_off_listingProcess' );
    add_action( 'wp_ajax_nopriv_on_off_listing', 'on_off_listingProcess' );
    function on_off_listingProcess() {
        $itemId = (int)$_POST['id'];
	    $enable = (int)$_POST['enable'];

        $res = [];
        if(is_administrator()) {
            $res = ZaiviaListings::on_offListing($itemId, $enable);
        }
        echo json_encode($res);
        die;
    }


    add_action( 'wp_ajax_uploadBusinessFile', 'uploadBusinessFile' );
    add_action( 'wp_ajax_nopriv_uploadBusinessFile', 'uploadBusinessFile' );
    function uploadBusinessFile() {
        $list = [];

	    $user_id = (is_administrator() && isset($_POST['user_id'])) ? ((int)$_POST['user_id']) :  get_current_user_id();

        if($_FILES && $user_id) {
            $list = ZaiviaBusiness::addBusinessFile($user_id);
        }

        echo json_encode($list);
        die;
    }

    add_action( 'wp_ajax_add_banner_form', 'add_banner_formProcess' );
    add_action( 'wp_ajax_nopriv_add_banner_form', 'add_banner_formProcess' );
    function add_banner_formProcess() {
        $nonce = $_POST['add_banner_nonce'];
        if ( ! wp_verify_nonce( $nonce, 'zai_add_banner' ) ) {
            echo json_encode(['error'=>'Security checked!']);
            die;
        }
        $res = ZaiviaBusiness::addBanner($_POST);

        if(is_administrator() && is_numeric($res)){
	        ZaiviaBusiness::activateBusiness( $res );
        }

        echo json_encode($res);
        die;
    }

    add_action( 'wp_ajax_add_card_form', 'add_card_formProcess' );
    add_action( 'wp_ajax_nopriv_add_card_form', 'add_card_formProcess' );
    function add_card_formProcess() {
        $nonce = $_POST['add_card_nonce'];
        if ( ! wp_verify_nonce( $nonce, 'zai_add_card' ) ) {
            echo json_encode(['error'=>'Security checked!']);
            die;
        }

        $res = ZaiviaBusiness::addCard($_POST);

	    if(is_administrator() && is_numeric($res)){
		    ZaiviaBusiness::activateBusiness( $res );
	    }

        echo json_encode($res);
        die;
    }


    add_action( 'wp_ajax_delete_business', 'delete_businessProcess' );
    add_action( 'wp_ajax_nopriv_delete_business', 'delete_businessProcess' );
    function delete_businessProcess() {
	    $itemId = (int)$_POST['id'];
        $userId = get_current_user_id();

        $res = [];
        if(ZaiviaBusiness::isOwner($userId, $itemId)) {
            $res = ZaiviaBusiness::deleteEntity($itemId);
        }
        echo json_encode($res);
        die;
    }

    add_action( 'wp_ajax_disable_business', 'disable_businessProcess' );
    add_action( 'wp_ajax_nopriv_disable_business', 'disable_businessProcess' );
    function disable_businessProcess() {
        $itemId = (int)$_POST['id'];

        $res = [];
        if(is_administrator()) {
            $res = ZaiviaBusiness::disableEntity($itemId);
        }
        echo json_encode($res);
        die;
    }

    add_action( 'wp_ajax_enable_business', 'enable_businessProcess' );
    add_action( 'wp_ajax_nopriv_enable_business', 'enable_businessProcess' );
    function enable_businessProcess() {
        $itemId = (int)$_POST['id'];

        $res = [];
        if(is_administrator()) {
            $res = ZaiviaBusiness::publishEntity($itemId);
        }
        echo json_encode($res);
        die;
    }

    add_action( 'wp_ajax_calculateBannerDate', 'calculateBannerDate' );
    add_action( 'wp_ajax_nopriv_calculateBannerDate', 'calculateBannerDate' );
    function calculateBannerDate() {
        $entity_id = (int)$_REQUEST['entity_id'];
        $date = $_REQUEST['date'];

		$res = am_calculateBusinessDate($entity_id, $date, ['date_renewal']);
	    echo json_encode($res);
	    die;
    }

    add_action( 'wp_ajax_calculateCardDate', 'calculateCardDate' );
    add_action( 'wp_ajax_nopriv_calculateCardDate', 'calculateCardDate' );
    function calculateCardDate() {
        $entity_id = (int)$_REQUEST['entity_id'];
        $date = $_REQUEST['date'];

	    $res = am_calculateBusinessDate($entity_id, $date, ["card_sponsor_date", "card_url_show_date", "card_featured_date"]);
	    echo json_encode($res);
	    die;
    }

	function am_calculateBusinessDate($entity_id, $date, $keys){
		$res = ZaiviaBusiness::calculateEndDate($entity_id, $date, $keys);

		foreach($res as $key => $date ) {
		    if(!$date) $date = time();
			$res[$key] = ZaiviaBusiness::formatDate($date);
		}

		return $res;
	}

    add_action( 'wp_ajax_updatePromo', 'updatePromo' );
    add_action( 'wp_ajax_nopriv_updatePromo', 'updatePromo' );
    function updatePromo() {
	    $entity_id = isset($_POST['entity_id']) ? (int)$_POST['entity_id'] : "";
	    $entity_type = isset($_POST['entity_type']) ? $_POST['entity_type'] : "";
	    $coupon_code = isset($_POST['promo_code']) ? $_POST['promo_code'] : "";

	    $userId = get_current_user_id();

	    if(!$entity_id || !in_array($entity_type, ["business", "listing"])) {
		    echo json_encode(["errors"=>__("Wrong entity")]); die;
	    }
		if(!listing_base::isOwner($userId, $entity_id, $entity_type)){
			echo json_encode(["errors"=>__("This is not yours!")]); die;
		}
		if($coupon_code) {
			$couponId = listing_base::validateCoupon($coupon_code, $userId);
			if (!is_numeric($couponId)) {
				echo json_encode(['errors' => $couponId]);
				die;
			}
		}
        if(!listing_base::setCoupon($entity_id, $entity_type, $couponId)) {
	        echo json_encode(['errors'=>__('Promo Code can\'t be updated')]); die;
        }
        echo json_encode("[]"); die;
    }

    add_action( 'wp_ajax_removePromo', 'removePromo' );
    add_action( 'wp_ajax_nopriv_removePromo', 'removePromo' );
    function removePromo() {
	    $entity_id = isset($_POST['entity_id']) ? (int)$_POST['entity_id'] : "";
	    $entity_type = isset($_POST['entity_type']) ? $_POST['entity_type'] : "";

	    $userId = get_current_user_id();

		if(!$entity_id || !in_array($entity_type, ["business", "listing"])) {
			echo json_encode(["errors"=>__("Wrong entity")]); die;
		}
		if(!listing_base::isOwner($userId, $entity_id, $entity_type)){
			echo json_encode(["errors"=>__("This is not yours!")]); die;
		}
	    if(!listing_base::setCoupon($entity_id, $entity_type)) {
		    echo json_encode(['errors'=>__('Promo Code can\'t be removed')]); die;
	    }
	    echo json_encode("[]"); die;
    }

    add_action( 'wp_ajax_activateBusiness', 'activateBusiness' );
    add_action( 'wp_ajax_nopriv_activateBusiness', 'activateBusiness' );
    function activateBusiness() {
        $res = [];

        if($_POST['payment-data']){
	        $entity_id = isset($_POST['entity_id']) ? (int)$_POST['entity_id'] : "";

	        parse_str($_POST['payment-data'], $paymentData);

            if ( !$entity_id || !$paymentData ) {
                $res["payment_error"] = __("Entity not set");
            }
			$prices = ZaiviaBusiness::calculatePrice( $entity_id );
            $payed = am_processPayment( $paymentData, $prices['total']);
            if ($payed === true ) {
                if ( ! ZaiviaBusiness::activateBusiness( $entity_id ) ) {
                    $res["payment_error"] = __("Activation Error");
                }
            } else {
                $res = $payed;
            }
        }
        echo json_encode($res);
        die;
    }

	add_action( 'wp_ajax_prepareCardPreview', 'prepareCardPreview' );
	add_action( 'wp_ajax_nopriv_prepareCardPreview', 'prepareCardPreview' );
	function prepareCardPreview(){
		$entityId = (int)$_POST{'entity_id'};

		$userId = is_administrator() ? false : get_current_user_id();

		$entity = ZaiviaBusiness::getEntities(ZaiviaBusiness::$posttype_card, $entityId, $userId);

		if($entity) {
			echo ZaiviaBusiness::renderCard($entity);
		} else _e('This is not yours!');
		die;
	}

    function am_processPayment($data, $price) {
        if(!$price) return true;

        if(isset($data['saved_card']) && $data['saved_card']){
            $cards = am_getCurrentUserCCs();
            foreach($cards as $card){
                if($card['cc_uid'] == $data['saved_card']){
                    $card_number = $card['cc_number'];
                    $card_name = $card['cardholder_name'];
                    $card_m = $card['cc_date_m'];
                    $card_y = $card['cc_date_y'];
                    $card_cvv = $card['cvv'];
                    break;
                }
            }
        } else {
            $card_number = isset($data['cc_number']) ? $data['cc_number'] : '';
            $card_name = isset($data['cardholder_name']) ? $data['cardholder_name'] : '';
            $card_m = isset($data['cc_date_m']) ? $data['cc_date_m'] : '';
            $card_y = isset($data['cc_date_y']) ? $data['cc_date_y'] : '';
            $card_cvv = isset($data['cvv']) ? $data['cvv'] : '';
        }

        $res = [];

        if(!am_validateCCNumber($card_number))  $res[] = 'cc_number';
        if(!$card_cvv) $res[] = 'cvv';
        if(!$card_m) $res[] = 'cc_date_m';
        if(!$card_y) $res[] = 'cc_date_y';

        if(count($res)){
            return ["errors" => $res];
        }

        $payed = bamboraPayByCard($card_name, $card_number, $card_m, $card_y, $card_cvv, $price);

        if($payed !== true ){
            return ["payment_error"=>$payed];
        }

        return true;
    }

	add_filter( 'wp_nav_menu_items', function( $items, $args ) {
		if ($args->theme_location == 'accountmenu') {
			if (is_user_logged_in()) {
				$items .= '<li class="right"><a href="'. wp_logout_url(home_url()) .'">'. __("Log Out") .'</a></li>';
			}
		}
		return $items;
	}, 10, 2 );


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
		} else {

			$userId = get_current_user_id();

			if($userId) {
				$fav_ids_cookie = isset($_COOKIE['favorite_listing']) ? json_decode(stripslashes($_COOKIE['favorite_listing'])) : [];
				$fav_ids = get_user_meta($userId,'favorite_listing',true);
				$fav_ids = is_array($fav_ids) ? $fav_ids : [];

				$fav_ids = array_merge($fav_ids, $fav_ids_cookie);
				update_user_meta($userId,'favorite_listing', $fav_ids);


				$view_ids_cookie = isset($_COOKIE['recently_listing']) ? json_decode(stripslashes($_COOKIE['recently_listing'])) : [];
				$view_ids = get_user_meta($userId,'recently_listing',true);
				$view_ids = is_array($view_ids) ? $view_ids : [];

				foreach($view_ids_cookie as $listing_id) {
					$view_ids = ZaiviaListings::combineLastViewed($listing_id, $view_ids);
				}
				update_user_meta($userId,'recently_listing', $view_ids);
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
			echo json_encode(['error'=>__('Security checked!')]);
			die;
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

			$subject = __('Password restoration');
			$message = __('Hello, ').$user_info->display_name;
			$message .= "<br>";
			$message .= __('You new password is').' <b>' . $pw . '</b>';

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

	add_action( 'wp_ajax_edit_account_form', 'edit_account_formProcess' );
	add_action( 'wp_ajax_nopriv_edit_account_form', 'edit_account_formProcess' );
	function edit_account_formProcess(){
		$nonce = $_POST['edit_user_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'zai_edit_user' ) ) {
			echo json_encode(['error'=>'Security checked!']);
			die;
		}

		$user_id = get_current_user_id();
		$user_email = stripcslashes($_POST['edit_email']);
		$user_firstname = stripcslashes($_POST['edit_firstname']);
		$user_lastname = stripcslashes($_POST['edit_lastname']);
		$user_nice_name = implode(" ", [$user_firstname, $user_lastname]);

		$user_data = array(
			'ID' => $user_id,
			'user_email' => $user_email,
			'first_name' => $user_firstname,
			'last_name' => $user_lastname,
			'display_name' => $user_nice_name,
		);
		$user_id = wp_update_user($user_data);

		$res = [];
		if (is_wp_error($user_id)) {
			$res['error'] = $user_id->get_error_message();
		} else {
			update_user_meta($user_id,"phone", stripcslashes($_POST['edit_phone']));
			update_user_meta($user_id,"phone_type", stripcslashes($_POST['edit_phonetype']));
		}

		echo json_encode($res);
		die;
	}

	add_action( 'wp_ajax_edit_payment_form', 'edit_payment_formProcess' );
	add_action( 'wp_ajax_nopriv_edit_payment_form', 'edit_payment_formProcess' );
	function edit_payment_formProcess(){
		$nonce = $_POST['edit_user_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'zai_edit_user' ) ) {
			echo json_encode(['error'=>'Security checked!']);
			die;
		}

		$user_id = get_current_user_id();

		$cc_uid = $_POST['cc_uid'];

		$cardholder_name = trim($_POST['cardholder_name']);
		$cc_number = trim($_POST['cc_number']);
		$cc_type = $_POST['cc_type'];
		$cc_date_m = $_POST['cc_date_m'];
		$cc_date_y = $_POST['cc_date_y'];
		$cvv = trim($_POST['cvv']);

		$cc_number_safe = am_validateCCNumber($cc_number);

		if(!$cc_number_safe) {
			echo json_encode(['error'=>'Credit Card number not valid']);
			die;
		}

		$data = [
			'cardholder_name' => $cardholder_name,
			'cc_number'       => $cc_number,
			'cc_number_safe'  => $cc_number_safe,
			'cc_type'         => $cc_type,
			'cc_date_m'       => $cc_date_m,
			'cc_date_y'       => $cc_date_y,
			'cvv'             => $cvv,
		];

		$oldCcs = am_getCurrentUserCCs();

		if($cc_uid) {
			foreach($oldCcs as $key=>$oldCc) {
				if ( $oldCc['cc_uid'] === $cc_uid ) {
					$data['cc_uid'] = $cc_uid;
					$oldCcs[ $key ] = $data;
				}
			}
		} else {
			$data['cc_uid'] = $user_id . time();
			$oldCcs[] = $data;
		}

		update_user_meta($user_id,"ccs", $oldCcs);
		unset($data['cc_number']);
		unset($data['cvv']);

		echo json_encode($data);
		die;
	}

	add_action( 'wp_ajax_edit_cc', 'edit_ccProcess' );
	add_action( 'wp_ajax_nopriv_edit_cc', 'edit_ccProcess' );
	function edit_ccProcess() {
		$cc_uid = $_POST['cc_uid'];

		$oldCcs = am_getCurrentUserCCs();
		foreach($oldCcs as $key=>$oldCc) {

			if ( $oldCc['cc_uid'] === $cc_uid ) {
				echo json_encode($oldCc);
				die;
			}
		}
		echo json_encode(['error'=>'Credit Card not found']);
		die;
	}

	add_action( 'wp_ajax_delete_cc', 'delete_ccProcess' );
	add_action( 'wp_ajax_nopriv_delete_cc', 'delete_ccProcess' );
	function delete_ccProcess() {
		$cc_uid = $_POST['cc_uid'];
		$user_id = get_current_user_id();

		$oldCcs = am_getCurrentUserCCs();
		foreach($oldCcs as $key=>$oldCc) {
			if ( $oldCc['cc_uid'] === $cc_uid ) {
				unset($oldCcs[$key]);
				update_user_meta($user_id,"ccs", $oldCcs);
				echo json_encode([]);
				die;
			}
		}
		echo json_encode(['error'=>'Credit Card not found']);
		die;
	}

	add_action( 'wp_ajax_edit_password_form', 'edit_password_formProcess' );
	add_action( 'wp_ajax_nopriv_edit_password_form', 'edit_password_formProcess' );
	function edit_password_formProcess(){
		$nonce = $_POST['edit_user_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'zai_edit_user' ) ) {
			echo json_encode(['error'=>'Security checked!']);
			die;
		}

		$user_id = get_current_user_id();
		$userdata = wp_get_current_user();

		$old_pass = stripcslashes($_POST['edit_old_password']);
		if(!wp_check_password( $old_pass, $userdata->user_pass, $user_id )) {
			echo json_encode(['error'=>__("Old password is incorrect.")]);
			die;
		}

		$new_pass = stripcslashes($_POST['edit_new_password']);
		$pass_confirm = stripcslashes($_POST['edit_confirm_password']);

		if($new_pass && $new_pass !== $pass_confirm) {
			echo json_encode(['error'=>__("Please enter the same password in both password fields.")]);
			die;
		}

		wp_set_password($new_pass, $user_id);
		wp_set_auth_cookie($user_id);
		wp_set_current_user($user_id);

		$res = [];
		echo json_encode($res);
		die;
	}

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
            } else {
                var_dump('activation_hash_' . $_GET['akey']);
                die;
            }

            wp_redirect(home_url(get_field("page_account_activated", "option")));
            die;
        }
    }


	add_action( 'wp_ajax_getListings', 'getListings' );
	add_action( 'wp_ajax_nopriv_getListings', 'getListings' );
	function getListings() {
		$res = ZaiviaListings::searchListings($_REQUEST);
		ob_start();
		include(get_template_directory() . "/templates/listing-empty.php");
		$res['no_result'] = ob_get_clean();
	    echo json_encode($res);
	    die;
	}

	add_action( 'wp_ajax_getListingItem', 'getListingItem' );
	add_action( 'wp_ajax_nopriv_getListingItem', 'getListingItem' );
	function getListingItem() {
	    echo json_encode(ZaiviaListings::getListings($_REQUEST['listing_id']));
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
		echo json_encode(ZaiviaListings::saveSearch($request));
		die;
	}

	add_action( 'wp_ajax_saveSearchEmail', 'saveSearchEmail' );
	add_action( 'wp_ajax_nopriv_saveSearchEmail', 'saveSearchEmail' );
	function saveSearchEmail() {
		$request = $_REQUEST;

        $post_data = http_build_query(
            array(
                'secret' => RECAPTCHA,
                'response' => $request['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            )
        );
        $context  = stream_context_create($opts);
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $result = json_decode($response);

        if ($result->success) {
            $email = $request['save_email'];

	        unset($request['action']);
	        unset($request['g-recaptcha-response']);
	        unset($request['save_email']);
	        unset($request['send_email']);

	        ZaiviaListings::saveSearch($request, $email);
            echo json_encode('ok');
        } else {
            var_dump($result);
        }
		die;
	}

    add_action( 'wp_ajax_reportListing', 'reportListing' );
    add_action( 'wp_ajax_nopriv_reportListing', 'reportListing' );
    function reportListing() {
        $post_data = http_build_query(
            array(
                'secret' => RECAPTCHA,
                'response' => $_POST['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        );
        $opts = array('http' =>
                          array(
                              'method'  => 'POST',
                              'header'  => 'Content-type: application/x-www-form-urlencoded',
                              'content' => $post_data
                          )
        );
        $context  = stream_context_create($opts);
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $result = json_decode($response);
        if ($result->success) {
            $to = get_field("report_email","option");
	        $report_url = $_REQUEST["report_url"];

	        if(strstr($report_url,"listing")) {
		        $subj = __('Report Listing');
            } else {
		        $subj = __('Report Community Partner');
            }

	        $message = __('URL:', 'am').' '. $report_url;

            $message .= __('From:', 'am').' '. $_REQUEST["report_full_name"];
            $message .= '<br>'. __('Email:', 'am') .' '. $_REQUEST["report_email"];
            if($_REQUEST["report_phone"]){
                $message .= '<br>'. __('Phone:', 'am') .' '. $_REQUEST["report_phone"];
            }
            $message .= '<br>'.__('Reason:', 'am').' ' . $_REQUEST["report_reason"];
            $message .= '<br>'.__('Message:', 'am').' ' . $_REQUEST["report_text"];

            add_filter('wp_mail_content_type', 'am_html_email');

            wp_mail($to, $subj, $message);
            if($_REQUEST["report_send_copy"]){
                $user_info = get_userdata(get_current_user_id());
                if($user_info) {
                    wp_mail($user_info->user_email, $subj, $message);
                }
            }
            remove_filter('wp_mail_content_type', 'am_html_email');
            echo json_encode(array('ok' => true));
        } else {
            echo json_encode(array('error' => 'Captcha fail'));
        }
        die;
    }

	add_action( 'wp_ajax_getMarket', 'getMarket' );
	add_action( 'wp_ajax_nopriv_getMarket', 'getMarket' );
	function getMarket() {
		echo json_encode(ZaiviaListings::getMarket(intval($_REQUEST['id'])));
		die;
	}

    add_action( 'wp_ajax_getMortage', 'getMortage' );
    add_action( 'wp_ajax_nopriv_getMarket', 'getMortage' );
    function getMortage() {
	    $price = (int)str_replace([",","."], "", $_REQUEST['calc_price']);
	    $deposit = (int)str_replace([",","."], "", $_REQUEST['calc_deposit']);
	    $rate = (float)str_replace([","], "", $_REQUEST['calc_rate']);
	    $period = (int)str_replace([",","."], "", $_REQUEST['calc_period']);

	    $price = ZaiviaListings::calculateMortage($price, $deposit, $rate, $period);

        echo json_encode(ZaiviaListings::formatMoney($price));
        die;
    }


	add_action( 'wp_ajax_get_industries', 'getIndustries' );
	add_action( 'wp_ajax_nopriv_get_industries', 'getIndustries' );
	function getIndustries() {
		$lat = (float)$_POST['lat'];
		$lng = (float)$_POST['lng'];
		$industries = ZaiviaBusiness::getIndustryOptionsForLocation($lat, $lng);
		echo json_encode(["industries" => $industries]);
		die;
	}

	add_action( 'wp_ajax_get_partners', 'getPartners' );
	add_action( 'wp_ajax_nopriv_get_partners', 'getPartners' );
	function getPartners() {
		$lat = (float)$_POST['lat'];
		$lng = (float)$_POST['lng'];
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$sort = $_POST['sort'];

		$featuredPartners = ZaiviaBusiness::getFeaturedPartnersForLocation($lat, $lng);
		$featuredPartnersHtml = "";
		foreach($featuredPartners as $itemId){
			$data = ZaiviaBusiness::getEntities(ZaiviaBusiness::$posttype_card, (int)$itemId);
            $featuredPartnersHtml .= ZaiviaBusiness::renderCard(array_merge($data, ["need-wrap"=>true]));
		}

		$partners = ZaiviaBusiness::getPartnersForLocation($lat, $lng, $page, $sort, $featuredPartners);
		$partnersHtml = "";
		foreach($partners as $data){
			$partnersHtml .= ZaiviaBusiness::renderCard(array_merge($data, ["need-wrap"=>true]));
		}

		$paginationHtml = ZaiviaBusiness::buildPagination(count($partners), $page);

		$res = [];
		if($partnersHtml) $res["common"] = $partnersHtml;
		if($featuredPartnersHtml) $res["featured"] = $featuredPartnersHtml;
		if($paginationHtml) $res["pagination"] = $paginationHtml;
		
		echo json_encode($res);
		die;
	}

    add_action( 'wp_ajax_getPaymentForm', 'getPaymentForm' );
    add_action( 'wp_ajax_nopriv_getPaymentForm', 'getPaymentForm' );
    function getPaymentForm() {
        $items = [];
	    $entityId = intval($_REQUEST['id']);
	    $itemType = $_POST['type'];
	    $duration = 0;

	    $item = listing_base::getUserItem($entityId, $itemType);
	    if($item){

		    if($itemType === 'listing'){
			    $keys = ZaiviaListings::getFeatureKeys();
			    $prices = ZaiviaListings::calculatePrice($item);
		    } else {
			    $duration = get_post_meta( $entityId, "duration", true );
			    $keys = ZaiviaBusiness::getFeatureKeys(get_post_type($entityId));
			    $prices = ZaiviaBusiness::calculatePrice($entityId);
		    }

            foreach($keys as $key=>$label) {
		        if(isset($prices[$key])) {
			        $items[] = [
				        'label' => $label . ($duration ? (' ' . $duration . ' ' . __( 'month(s):', 'am' )) : ""),
				        'price' => ZaiviaListings::formatMoney( $prices[$key], 2 )
			        ];
		        }
            }

	    } else {
		    $prices = ["total"=>0, "subtotal"=>0, "discount"=>0];
		    $items[] = [
			    'label' => __( "That's not yours", 'am' ),
			    'price' => ''
		    ];
	    }

        echo json_encode([
                'total_num' => $prices['total'],
                'total'=>ZaiviaListings::formatMoney($prices['total'], 2 ),
                'subtotal'=>ZaiviaListings::formatMoney( $prices['subtotal'], 2 ),
                'discount'=>ZaiviaListings::formatMoney( $prices['discount'], 2 ),
                'coupon_name'=>isset($prices['coupon_name']) ? $prices['coupon_name'] : "",
                'items'=>$items
        ]);
        die;
    }



function am_getCurrentUserCCs(){
	$res = get_user_meta(get_current_user_id(), "ccs", true);
	return $res ? $res : [];
}


function am_validateCCNumber($cc, $extra_check = true){
	$cards = array(
		"visa" => "(4\d{12}(?:\d{3})?)",
		"amex" => "(3[47]\d{13})",
		"jcb" => "(35[2-8][89]\d\d\d{10})",
		"maestro" => "((?:5020|5038|6304|6579|6761)\d{12}(?:\d\d)?)",
		"solo" => "((?:6334|6767)\d{12}(?:\d\d)?\d?)",
		"mastercard" => "(5[1-5]\d{14})",
		"switch" => "(?:(?:(?:4903|4905|4911|4936|6333|6759)\d{12})|(?:(?:564182|633110)\d{10})(\d\d)?\d?)",
	);
	$matches = array();
	$pattern = "#^(?:".implode("|", $cards).")$#";
	$result = preg_match($pattern, str_replace(" ", "", $cc), $matches);
	if($extra_check && $result > 0){
		$result = (validatecard($cc))?1:0;
	}
	if($result > 0) {
		return str_repeat('X', strlen($cc) - 4) . substr($cc, -4);
	} else {
		return false;
	}
}
function validatecard($cardnumber) {
	$cardnumber=preg_replace("/\D|\s/", "", $cardnumber);  # strip any non-digits
	$cardlength=strlen($cardnumber);
	$parity=$cardlength % 2;
	$sum=0;
	for ($i=0; $i<$cardlength; $i++) {
		$digit=$cardnumber[$i];
		if ($i%2==$parity) $digit=$digit*2;
		if ($digit>9) $digit=$digit-9;
		$sum=$sum+$digit;
	}
	$valid=($sum%10==0);
	return $valid;
}

function bamboraPayByCard($card_name, $card_number, $card_m, $card_y, $card_cvv, $amount){
	require_once 'Beanstream/Gateway.php';
	require_once 'Beanstream/Exception.php';

	if($card_m < 10) $card_m = "0".$card_m;
	if($card_y > 2000) $card_y -= 2000;

	$card = [
		'name'=>$card_name,
		'number' => $card_number,
		'expiry_month' => $card_m,
		'expiry_year' => $card_y,
		'cvd' => $card_cvv
	];

	$beanstream = new Beanstream\Gateway(get_field( "bambora_merchant_id", "option" ), get_field( "bambora_api_key", "option" ),'www','v1');
	$payment_data = array(
		'order_number' => bin2hex(random_bytes(10)),
		'amount' => $amount,
		'payment_method' => 'card',
		'card' => $card
	);

	try {
		$result = $beanstream->payments()->makeCardPayment($payment_data);
		if(!is_null($result) and $result['approved'] == '1'){
			return true;
		}
		return "Payment Error";
	} catch (\Beanstream\Exception $e) {
		return $e->getMessage();
	}
}


function am_setAndSendActivation($userId, $pw){
	$hash = wp_generate_password(12, false);

	add_user_meta( $userId, 'activation_hash', $hash );
	add_option('activation_hash_' . $hash, $userId);

	$user_info = get_userdata($userId);

	$activationLink = home_url('/').'activate?akey='.$hash;

	$to = $user_info->user_email;
	$subject = __('Member Verification');
	$message = __('Hello, ').$user_info->display_name;
	$message .= "<br>";
	$message .= __('You password is').' <b>' . $pw . '</b>';
	$message .= "<br><br>";
	$message .= __('Please click this link to activate your account:');
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

function am_renderOtherControl($listing, $key, $additionalClass="") {
	$items = get_field($key, 'option');
	if($items){
		$itemsNames = array_map(function ($i) { return $i['name']; }, $items);
		$other = ($listing && $listing[$key] && !in_array($listing[$key], $itemsNames)) ? true : false;
		?>
        <select name="<?php echo $key ?>" id="<?php echo $key ?>"
                class="tosave have_other <?php echo $additionalClass ?>" title="">
            <option value=""><?php _e('-select-', 'am') ?></option>
			<?php foreach ($items as $item): ?>
                <option value="<?php echo $item['name'] ?>" <?php echo ($listing && $listing[$key] === $item['name']) ? 'selected' : ''; ?>><?php echo $item['name'] ?></option>
			<?php endforeach; ?>
            <option value="other" <?php echo $other ? 'selected' : ''; ?>><?php _e('Other', 'am') ?></option>
        </select>
        <input name="<?php echo $key ?>_other" id="<?php echo $key ?>_other"
               value="<?php echo $other ? $listing[$key] : "" ?>" type="text"
               class="value_other<?php echo $other ? ' active' : ''; ?>" title="">
		<?php
	}
}

function am_renderUploaderControl($item, $key, $uploaderKey="business_upload", $width="", $additionalClass="") {
?>
    <input type="hidden" name="<?php echo $key?>_upload_input_media" id="<?php echo $key?>_upload_input_media" value="<?php echo isset($item[$key.'_id']) ? $item[$key.'_id'] : '';?>">
    <fieldset>
        <img
            id="<?php echo $key?>_upload_input_src"
            src="<?php echo isset($item[$key.'_url']) ? $item['card_profile_image_url'] : '';?>"
            <?php if($width):?>width="<?php echo $width;?>"<?php endif;?> alt="">
    </fieldset>
    <label class="btn btn-secondary mb-15"><?php _e('Upload image', 'am') ?><input type="file" name="E" class="<?php echo $uploaderKey?>" id="<?php echo $key?>_upload_input"></label>
    <p id="<?php echo $key?>_upload_input_file-errors"></p>
<?php
}

function am_url_origin( $s, $use_forwarded_host = false ) {
	$ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
	$sp       = strtolower( $s['SERVER_PROTOCOL'] );
	$protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
	$port     = $s['SERVER_PORT'];
	$port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
	$host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
	$host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
	return $protocol . '://' . $host;
}

function am_full_url($use_forwarded_host = false ) {
	$s = $_SERVER;
	return am_url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
}

function is_administrator() {
	return current_user_can( "edit_posts" );
}