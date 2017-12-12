<?php 
if(function_exists('get_field')){

	/**
	 * this function is wrapper of get_field function and RETURNS formatted value from ACF field with $html_open and $html_close, also you can add $esc (read more am_esc function description);
	 * if $post_id will be null it will use current $post
	 * you can use this function without checking if value is empty or not
	 * EXAMPLE:
	 * echo am_get_field('phone_number', '<a href="tel:", '">'.__('Call me', 'am').'</a>', $post->ID 'phone');
	 * if field is not empty it will return <a href="tel:+1758422555222">Call me</a>
	 * if field is empty it will return empty string
	 */
	function am_get_field($field_name, $html_open = '', $html_close = '', $post_id = null, $esc = ''){
        
        global $post;
        
        $toReturn = '';
        
        if(!$post_id){
            $post_id = $post->ID;
        }
        
        if($value = get_field($field_name, $post_id)){
			
            $toReturn = $html_open.am_esc($value, $esc).$html_close;
			
        }
        
        return $toReturn;
        
    }

	/**
	 * this function is wrapper of am_get_field function just prints result so am_the_field('phone_number', '<a href="tel:', '">'.__('Call me', 'am').'</a>', $post->ID, 'phone') == echo am_get_field('phone', '<a href="tel:', '">'.__('Call me', 'am').'</a>', $post->ID, 'phone')
	  * you can use this function without checking if value is empty or not
	 */
    function am_the_field($field_name, $html_open = '', $html_close = '', $post_id = null, $esc = ''){
        
        echo am_get_field($field_name, $html_open, $html_close, $post_id, $esc);
        
    }

	/**
	 * this function is wrapper of get_sub_field function and RETURNS formatted value from ACF sub field with $html_open and $html_close, also you can add $esc (read more am_esc function description);
	 * you can use it in ACF row loop https://www.advancedcustomfields.com/resources/have_rows/
	 * you can use this function without checking if value is empty or not
	 * EXAMPLE:
	 * echo am_get_sub_field('phone_number', '<a href="tel:", '">'.__('Call me', 'am').'</a>', 'phone');
	 * if sub field is not empty it will return <a href="tel:+1758422555222">Call me</a>
	 * if sub field is empty it will return empty string
	 */
	function am_get_sub_field($field_name, $html_open = '', $html_close = '', $esc = ''){
       
        $toReturn = '';
        
        if ($value = get_sub_field($field_name)){
            
            $toReturn = $html_open.am_esc($value, $esc).$html_close;
			
        }
        
        return $toReturn;
        
    }

	/**
	 * this function is wrapper of am_get_sub_field just prints result so am_the_sub_field('phone_number', '<a href="tel:', '">'.__('Call me', 'am').'</a>', 'phone') == echo am_get_sub_field('phone', '<a href="tel:', '">'.__('Call me', 'am').'</a>', 'phone')
	  * you can use this function without checking if value is empty or not
	 */
    function am_the_sub_field($field_name, $html_open = '', $html_close = '', $esc = ''){
        
        echo am_get_sub_field($field_name, $html_open, $html_close, $esc);
        
    }
	
	/**
	 This function is for creating link with ACF Link field type
	 EXMAPLE: 
	 
	 Default:
	 * echo am_get_link($link_array);
	 <a href="http://someurl.com">some title</a>
	 
	 Short:
	 * echo am_get_link($link_array, 'btn');
	 <a class="btn" href="http://someurl.com">some title</a>
	 
	 Full
	 * echo am_get_link($link_array, array('class' => 'btn', 'before' => '<span>Before</span>',  'after' => '<span>After</span>', ));
	 <a class="btn" href="http://someurl.com"><span>Before</span>some title<span>After</span></a>
	 
	 */	
	
	function am_get_link($link = array(), $attrs = array()){
		
		$ready_link = '';
		
		if (!empty($link) && is_array($link) && isset($link['url'])) :
		
			$ready_attr = '';
			$after = '';
			$before = '';
		
			if ($attrs) :
		
				if (is_array($attrs)) : 
		
					foreach ($attrs as $akey => $attr) :
						
						if (!in_array($akey, array('after', 'before'))) : 
							
							$ready_attr .= $akey.'="'.esc_attr($attr).'" ';
		
						endif;
		
					endforeach;
					
					if (isset($attrs['before']) && $attrs['before']) :
		
						$before = $attrs['before'];
					
					endif;
		
					if (isset($attrs['after']) && $attrs['after']) :
		
						$after = $attrs['after'];
					
					endif;
					
				else :
		
					$ready_attr = 'class="'.esc_attr($attrs).'"';
		
				endif;
		
			endif;
		
			$ready_link = '<a href="'.esc_url($link['url']).'" '.$ready_attr.' '.(isset($link['target']) && $link['target']? 'target="'.esc_attr($link['target']).'"' : '').'>'.$before.($link['title']? $link['title'] : $link['url']).$after.'</a>';
		
		endif;
		
		return $ready_link;
		
	}
	
	/**
	 * This function is wrapper of am_get_link just prints result function so am_the_link($link_array, 'btn') == echo am_get_link($image_array, 'btn')
	 */	
	function am_the_link($link = array(), $attrs = array()){
		
		echo am_get_link($link, $attrs);
		
	}
}

/**
 * This function is for escaping strings
 * You can use it everywhere
 * Exmaple:
 * $phone = '+1 (758) 422-555-222';
 <a href="tel:<php echo am_esc($phone, 'phone'); ?>"><php echo $phone; ?></a>
 it will return <a href="tel:+1758422555222">+1 (758) 422-555-222</a>
 */

function am_esc($value = '', $esc = ''){
	if ($esc == 'url')
		$toReturn = esc_url($value);
	elseif ($esc == 'attr')
		$toReturn = esc_attr($value);
	elseif ($esc == 'html')
		$toReturn = esc_html($value);
	elseif ($esc == 'email')
		$toReturn = antispambot($value, true);
	elseif ($esc == 'email2')
		$toReturn = antispambot($value, false);
	elseif ($esc == 'phone')
		$toReturn = str_replace(array('(', ')', ' ', '-', '.', ','), '', $value);
	else
		$toReturn = $value;
	return $toReturn;
}


/**
 * This function is for getting value from array with formatting value
 * you can add $esc (read more am_esc function description)
 * EXMAPLE: 
 * echo am_get_array('phone_number', '<a href="tel:', '">'.__('Call me', 'am').'</a>', $array, 'phone');
 * it will use $array['phone_number] and return <a href="tel:+1758422555222">Call me</a>
 * you can use this function without checking if value is empty or not
 */	
function am_get_array($array_key, $html_open = '', $html_close = '', $array = array(), $esc = ''){
	
	$toReturn = '';
    
    if (is_array($array) && isset($array[$array_key]) && $array[$array_key]){
        
        $toReturn = $html_open.am_esc($array[$array_key], $esc).$html_close;
		
    }
    
    return $toReturn;
}

/**
 * This function is wrapper of am_get_array just prints result function so am_the_array('phone_number', '<a href="tel:', '">'.__('Call me', 'am').'</a>', $array, 'phone') == echo am_get_array('phone_number', '<a href="tel:', '">'.__('Call me', 'am').'</a>', $array, 'phone')
 * you can use this function without checking if value is empty or not
 */

function am_the_array($array_key, $html_open = '', $html_close = '', $array = array(), $esc = ''){
	
	echo am_get_array($array_key, $html_open, $html_close, $array, $esc);
	
}

/**
 * Custom comments for single or page templates
 */

function am_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
		</div>
<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.','am') ?></em>
		<br />
<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __('%1$s at %2$s','am'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)','am'),'  ','' );
			?>
		</div>

		<div class="entry-comment"><?php comment_text() ?></div>

		<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
}

/**
 * Browser detection body_class() output
 */
function am_browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if(wp_is_mobile()) $classes[] = 'mobile';
	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function am_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name.
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary.
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'wfc' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'am_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function am_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'am_render_title' );
endif;

/**
 * Filter for get_the_excerpt
 */
 
function am_excerpt_more( $more ) {
	return '...';
}

function am_has_title($title){
	global $post;
	if($title == ''){
		return get_the_time(get_option( 'date_format' ));
	}else{
		return $title;
	}
}

function am_texturize_shortcode_before($content) {
	$content = preg_replace('/\]\[/im', "]\n[", $content);
	return $content;
}

function am_remove_wpautop( $content ) { 
	$content = do_shortcode( shortcode_unautop( $content ) ); 
	$content = preg_replace('#^<\/p>|^<br \/>|<p>$#', '', $content);
	return $content;
}

// unregister all default WP Widgets
function am_unregister_default_wp_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    //unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Text');
    //unregister_widget('WP_Widget_Categories');
    //unregister_widget('WP_Widget_Recent_Posts');
    //unregister_widget('WP_Widget_Recent_Comments');
    //unregister_widget('WP_Widget_RSS');
    //unregister_widget('WP_Widget_Tag_Cloud');
    //unregister_widget('WP_Nav_Menu_Widget');
}

/**
 * Add JS scripts
 */
function am_add_javascript( ) {
    
    global $am_option;

    if (is_singular() && get_option('thread_comments')) {
//	    wp_enqueue_script( 'comment-reply' );
    }
        
    wp_enqueue_script('jquery');
    if( !is_admin() ) {
	    wp_enqueue_script('am_gmap', "https://maps.googleapis.com/maps/api/js?key=".get_field('google_api_key', 'option'), array( ), '',true );

	    wp_enqueue_script('jquery-ui-datepicker');


        $am_files = array(
	        "vendor_js"=>'includes/js/vendor.js',
	        "general_js"=>'includes/js/general.js',
	        "edit-listing_js"=>'includes/js/edit-listing.js',
	        "map_js"=>'includes/js/map.js',
        );
        foreach($am_files as $key=>$am_file){
            wp_enqueue_script($key, get_theme_file_uri($am_file), array( 'jquery' ),filemtime( get_theme_file_path($am_file)),true );
        }

	    $wp_upload_dir = wp_upload_dir();
	    wp_localize_script('general_js', 'amData', [
		    'ajaxurl' => admin_url('admin-ajax.php'),
		    'template_url' => get_template_directory_uri(),
		    'site_url'=>esc_url(home_url('/')),
		    'upload_dir'=>$wp_upload_dir["basedir"].'/files/',
		    'upload_url'=>$wp_upload_dir["baseurl"].'/files/',
	    ]);

    }
}

/**
 * Add CSS scripts
 */
function am_add_css( ) {
    
    global $am_option;

	wp_enqueue_style('jqueryui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css', false, null );

    // internal CSS
    $am_files = array('style.css','style-wp.css'); // example: array('style1', 'style2');
    foreach($am_files as $am_file){
        wp_enqueue_style('am_'.sanitize_title($am_file), get_theme_file_uri($am_file),array(),filemtime( get_theme_file_path($am_file)));
    }
    
    // external CSS
    $am_links = array(); // example: array('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i');
    foreach($am_links as $am_link){
        wp_enqueue_style('am_'.sanitize_title($am_link), $am_link,array());
    }
}

/**
 * Register widgetized areas
 */
function am_the_widgets_init() {
	
    if ( !function_exists('register_sidebars') )
        return;
    
    $before_widget = '<div id="%1$s" class="widget %2$s"><div class="widget_inner">';
    $after_widget = '</div></div>';
    $before_title = '<h3 class="widgettitle">';
    $after_title = '</h3>';

    register_sidebar(array('name' => __('Default','am'),'id' => 'sidebar-default','before_widget' => $before_widget,'after_widget' => $after_widget,'before_title' => $before_title,'after_title' => $after_title));
}


/**
 * Move Comment textarea to the end of the form
 */
function am_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}

/**
 * Get page id by slag
 */

function am_template_page_id($param) {
   $args = array(
       'meta_key' => '_wp_page_template',
       'meta_value' => 'page-templates/' . $param . '.php',
       'post_type' => 'page',
       'post_status' => 'publish'
   );
   $pages = get_pages($args);
   return $pages[0]->ID;
}

/**
 * Return template HTML
 */

function load_template_part($template_name, $part_name = null) {
   ob_start();
   get_template_part($template_name, $part_name);
   $var = ob_get_contents();
   ob_end_clean();
   return $var;
}

/**
 * Add SVG support
 */

function am_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}

/**
 * Add SVG support - CSS part
 */

function am_svg_thumb_display() {
	echo '<style>
	td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail { 
	 width: 100% !important; 
	 height: auto !important; 
	}
	</style>';
}

/**
 * Add Demo Role for security
 */

function am_demo_role(){
    global $wp_roles;
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    $role_admin = $wp_roles->get_role('administrator');
    //Adding a 'new_role' with all admin caps
    $wp_roles->add_role('demo', __('Demo','am'), $role_admin->capabilities);
    
    $role = get_role( 'demo' );
    $role->remove_cap( 'edit_themes' );
    $role->remove_cap( 'export' );
    $role->remove_cap( 'list_users' );
    $role->remove_cap( 'promote_users' );
    $role->remove_cap( 'switch_themes' );
    $role->remove_cap( 'remove_users' );
    $role->remove_cap( 'delete_themes' );
    $role->remove_cap( 'delete_plugins' );
    $role->remove_cap( 'edit_plugins' );
    $role->remove_cap( 'edit_users' );
    $role->remove_cap( 'create_users' );
    $role->remove_cap( 'delete_users' );
    $role->remove_cap( 'install_themes' );
    $role->remove_cap( 'install_plugins' );
    $role->remove_cap( 'activate_plugins' );
    $role->remove_cap( 'update_plugin' );
    $role->remove_cap( 'update_themes' );
    $role->remove_cap( 'update_core' );
}

/**
 * Change admin logo url
 */

function am_login_logo_url() {
    return home_url('/');
}

// Add Google Map API

function am_acf_google_map_key() {
	$key = get_field('google_map_api', 'option');
	if($key)
    	acf_update_setting('google_api_key', $key);
}
add_action('acf/init', 'am_acf_google_map_key');

/**
 * Retina 2x plugin supprt: get URL
 */

function am_get_retina($url){
    if(!function_exists('wr2x_get_retina_from_url'))
        return $url;

    $url_temp = wr2x_get_retina_from_url( $url );

    if(!empty($url_temp))
        return $url_temp;
    else
        return $url;
}

/**
 * Retina 2x plugin supprt: return IMG
 */

function am_get_retina_img($url_normal, $class='', $w = '', $h = '', $alt = ''){
    $url_retina = am_get_retina($url_normal);
    $srcset = '';
    if($url_retina){
        $srcset = ' srcset="'.esc_url($url_retina).' 2x"';
    }

    $width = '';
    if($w){
        $width = ' width="'.esc_attr($w).'"';
    }
    $height = '';
    if($h){
        $height = ' height="'.esc_attr($h).'"';
    }
    return '<img src="'.esc_url($url_normal).'"'.$srcset.$width.$height.' alt="'.esc_attr($alt).'" class="'.esc_attr($class).'">';
}


/**

	This function is wrapper of am_get_retina_img function.
	EXMAPLE: 

	Default:
	* am_the_retina_img($image_array);
	<img src="$image_array['url]" srcset="am_get_retina($image_array['url']) 2x" alt="$image_array['alt']" width="$image_array['width']" height="$image_array['height']">

	Short:
	* am_the_retina_img($image_array, 'image_size');
	<img src="$image_array['sizes]['image_size']" srcset="am_get_retina($image_array['sizes]['image_size']) 2x" alt="$image_array['alt']" width="$image_array['sizes]['image_size-width']" height="$image_array['sizes]['image_size-height']">

	Full
	* am_the_retina_img($image_array, array('class' => 'main-image', 'size' => 'image_size',  'any-attr' => 'some_value', ));
	<img src="$image_array['sizes]['image_size']" srcset="am_get_retina($image_array['sizes]['image_size']) 2x" alt="$image_array['alt']" width="$image_array['sizes]['image_size-width']" height="$image_array['sizes]['image_size-height']" class="main-image" any-attr="some_value">

	you can override attrs like width, height, alt trough second parametr $args. For example you can remove attr hegiht by setting 'height' => false
*/	

function am_the_retina_img($image = array(), $args = array()){
	
	$ready_img = '';
	
	$url = '';
	$size = 'url';
	$width = '';
	$height = '';
	$alt = '';
	$class = '';
	if ($image) :
	
		if (is_string($args) && $args) : 
			$size = $args;
		elseif (is_array($args) && isset($args['size']) && $args['size']) :
			$size = $args['size'];
		endif;

		if (is_array($image)) :

			if ($size == 'url' && isset($image['url'])) :
				$url = $image['url'];
			elseif (isset($image['sizes'][$size])) :
				$url = $image['sizes'][$size];
			endif;

		elseif (is_string($image) && $image) :
			$url = $image;
		endif;

		if (is_array($args) && isset($args['width'])) :
			$width = $args['width'];
		elseif (is_array($image) && $size == 'url' && isset($image['width'])) :
			$width = $image['width'];
		elseif (is_array($image) && isset($image['sizes'][$size])) :
			$width = $image['sizes'][$size.'-width'];
		endif;

		if (is_array($args) && isset($args['height'])) :
			$height = $args['height'];
		elseif (is_array($image) && $size == 'url' && isset($image['height'])) :
			$height = $image['height'];
		elseif (is_array($image) && isset($image['sizes'][$size])) :
			$height = $image['sizes'][$size.'-height'];
		endif;

		if (is_array($args) && isset($args['alt'])) :
			$alt = $args['alt'];
		elseif (is_array($image) && isset($image['alt'])) :
			$alt = $image['alt'];
		endif;

		if (is_array($args) && isset($args['class'])) :
			$class = $args['class'];
		endif;

		$ready_img = am_get_retina_img($url, $class, $width, $height, $alt);
	
	endif; 
	
	echo $ready_img;
}


/**

	This function returns image htmlfrom given $image_array. You just need to send as first parametr image array, and as second max midth of image, or array where can be maxwidth (Max width), alt or class. By default $args is 100, so that means that max image width by default is 100;
	EXMAPLE: 

	Default:
	* echo am_get_retina_icon($image_array);
	<img src="$image_array['url]" alt="$image_array['alt']" width="lowest ($image_array['width']/ 2) or 100">

	Short:
	* am_the_retina_img($image_array, 85);
	<img src="$image_array['url]" alt="$image_array['alt']" width="lowest ($image_array['width']/ 2) or 85">

	Full
	* am_the_retina_img($image_array, array('class' => 'main-image', 'maxwidth' => 85));
	<img src="$image_array['url]" alt="$image_array['alt']" width="lowest ($image_array['width']/ 2) or 85" class="main-image">

	you can override attrs like width, height, alt trough second parametr $args. For example you can remove attr hegiht by setting 'height' => false
*/	
function am_get_retina_icon($image = array(), $args = array()){
	$max_width = 100;
	
	$ready_img = '';
	
	$url = '';
	$max_width = '';
	$alt = '';
	$class = '';
	if ($image && is_array($image)) :

		if (isset($image['url']) && $image['url']) :
			$url = $image['url'];
		endif;

		if (is_array($args) && isset($args['maxwidth'])) :
			$max_width = $args['maxwidth'];
		elseif (is_array($args) && isset($args['width'])) :
			$max_width = $args['width'];
		elseif ((is_string($args) || is_integer($args)) && $args) :
			$max_width = $args;
		endif;

		if (is_array($args) && isset($args['alt'])) :
			$alt = $args['alt'];
		elseif (is_array($image) && isset($image['alt'])) :
			$alt = $image['alt'];
		endif;

		if (is_array($args) && isset($args['class'])) :
			$class = $args['class'];
		endif;
	
		$ready_img = '<img src="'.esc_url($url).'" width="'.esc_attr(min(round($image['width'] / 2), $max_width)).'" '.($class? ' class="'.esc_attr($class).'" ' : '').' alt="'.($alt? esc_attr($alt) : '').'">';
	
	endif; 
	
	return $ready_img;
	
}

/**
	* This function is wrapper of am_get_retina_icon just prints result function so am_the_retina_icon($image_array, 'btn') == echo am_get_retina_icon($image_array, 'btn')
*/	
function am_the_retina_icon($image, $args){
	
	echo am_get_retina_icon($image, $args);
	
}

/**
 * Chnage admin logo image
 */

function am_login_logo(){  ?>
    <style type="text/css">
        body.login div#login h1 a {
			width: 320px;
			height: 100px;
			display: block;
			cursor: pointer;
			text-indent: -9999em;
			background: url(<?php echo get_bloginfo( 'template_directory' ) ?>/images/logo.png) no-repeat;
            background-size: 100% auto;
			margin: 0 auto 15px;
            background-size: contain;
            background-position-x: center;
        }
    </style>
<?php }
?>