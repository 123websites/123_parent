<?php 

// register ACF fields & PHPImage Library
require('acf.php');
require('PHPImage.php');

show_admin_bar( false );

// makes the theme support html5 and featured images on posts
add_action( 'after_setup_theme', 'action_after_setup_theme');

if( !function_exists('action_after_setup_theme') ){
	function action_after_setup_theme(){
		add_theme_support( 'html5' );
		add_theme_support( 'post-thumbnails' );
	}
}

// runs clean_head and registers the nav menu
add_action( 'init', 'clean_head_and_register_nav_menu');

if( !function_exists('clean_head_and_register_nav_menu') ){
	function clean_head_and_register_nav_menu(){
		clean_head();
		register_nav_menu( 'main-nav', 'Main Navigation');
	}
}

// loads all the js files and css files to the places they're supposed to be
add_action( 'wp_enqueue_scripts', 'action_wp_enqueue_scripts');

if( !function_exists('action_wp_enqueue_scripts') ){
	function action_wp_enqueue_scripts(){
		register_styles();
		enqueue_styles();
		register_javascript();
		enqueue_javascript();		
	}
}


if( !function_exists('enqueue_javascript') ){
	function enqueue_javascript(){
		wp_enqueue_script( 'theme' );
		wp_enqueue_script( 'exec' );
	}
}
if( !function_exists('enqueue_styles') ){
	function enqueue_styles(){
		wp_enqueue_style( 'theme' );
	}
}

if( !function_exists('register_javascript') ){
	function register_javascript(){
		wp_register_script( 'theme', get_template_directory_uri() . '/build/js/build.js');
		wp_register_script( 'exec', get_template_directory_uri() . '/build/js/exec.js');
	}
}

if( !function_exists('register_styles') ){
	function register_styles(){
		wp_register_style( 'theme', get_template_directory_uri() . '/build/css/build.css' );
	}
}

if( !function_exists('clean_head') ){
	function clean_head(){
		// removes generator tag
		remove_action( 'wp_head' , 'wp_generator' );
		// removes dns pre-fetch
		remove_action( 'wp_head', 'wp_resource_hints', 2 );
		// removes weblog client link
		remove_action( 'wp_head', 'rsd_link' );
		// removes windows live writer manifest link
		remove_action( 'wp_head', 'wlwmanifest_link');	
	}
}

// make areas served zips available to javascript
if( !function_exists('localize_areas_served') ){
	function localize_areas_served(){
		$fields = get_field('locations', 'option');
		$fields_array = [];
		if(!empty($fields)){
			foreach($fields as $field) {
				array_push($fields_array, $field['zip']);
			}	
		}
		wp_localize_script( 'theme', 'AreasServed', $fields_array );
	}
}

// make contact lat lng available to javascript
add_action('wp_enqueue_scripts', 'localize_contact_address');

if( !function_exists('localize_contact_address') ){
	function localize_contact_address(){
		$fields = [];
		$rows = get_field('addresses-repeater', 'option');
		foreach($rows as $row){
			array_push($fields, $row['addresses-gmap']);
		}
		wp_localize_script( 'theme', 'ContactAddresses', $fields );
	}
}


// make nav-fadein-toggle available in javascript
add_action('wp_enqueue_scripts', 'localize_fadein_toggle');

if( !function_exists('localize_fadein_toggle') ){
	function localize_fadein_toggle(){
		$val = var_export(get_field('nav-fadein-toggle', 'option'), true);
		wp_localize_script( 'theme', 'DisableNavTintFadein', $val);
	}
}

// load the custom login scripts
add_action( 'login_enqueue_scripts', 'enqueue_login_scripts' );

if( !function_exists('enqueue_login_scripts') ){
	function enqueue_login_scripts(){
		update_login_styles();
		wp_enqueue_style('custom-login', get_template_directory_uri() . '/build/css/login.css' ); 
	}
}

// load the custom admin scripts
add_action( 'admin_enqueue_scripts', 'enqueue_admin_scripts' );

if( !function_exists('enqueue_admin_scripts') ){
	function enqueue_admin_scripts(){
		wp_enqueue_script( 'custom-login', get_template_directory_uri() . '/build/js/admin.js' );
	}
}

// adds the training ad dashboard widget
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );

if( !function_exists('add_dashboard_widgets') ){
	function add_dashboard_widgets() {
		wp_add_dashboard_widget('dashboard_widget', 'Questions, Comments, Concerns ?', 'dashboard_widget_function');
	}
}

// Function that outputs the contents of the dashboard widget
if( !function_exists('dashboard_widget_function') ){
	function dashboard_widget_function( $post, $callback_args ) {
		?>
			<a target="_blank" href="http://www.123websites.com/training">
				<img style="width: 100%;" src="http://www.123websites.com/images/training-ad-dashboard.png">
			</a>
		<?php
	}
}
if( !function_exists('hex_to_hsl') ){
	function hex_to_hsl($hex) {
	    $hex = array($hex[0].$hex[1], $hex[2].$hex[3], $hex[4].$hex[5]);
	    $rgb = array_map(function($part) {
	        return hexdec($part) / 255;
	    }, $hex);

	    $max = max($rgb);
	    $min = min($rgb);

	    $l = ($max + $min) / 2;

	    if ($max == $min) {
	        $h = $s = 0;
	    } else {
	        $diff = $max - $min;
	        $s = $l > 0.5 ? $diff / (2 - $max - $min) : $diff / ($max + $min);

	        switch($max) {
	            case $rgb[0]:
	                $h = ($rgb[1] - $rgb[2]) / $diff + ($rgb[1] < $rgb[2] ? 6 : 0);
	                break;
	            case $rgb[1]:
	                $h = ($rgb[2] - $rgb[0]) / $diff + 2;
	                break;
	            case $rgb[2]:
	                $h = ($rgb[0] - $rgb[1]) / $diff + 4;
	                break;
	        }

	        $h /= 6;
	    }

	    return array($h, $s, $l);
	}
}

if( !function_exists('hsl_to_hex') ){
	function hsl_to_hex($hsl){
	    list($h, $s, $l) = $hsl;

	    if ($s == 0) {
	        $r = $g = $b = 1;
	    } else {
	        $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
	        $p = 2 * $l - $q;

	        $r = hue2rgb($p, $q, $h + 1/3);
	        $g = hue2rgb($p, $q, $h);
	        $b = hue2rgb($p, $q, $h - 1/3);
	    }

	    return rgb2hex($r) . rgb2hex($g) . rgb2hex($b);
	}
}

if( !function_exists('hue2rgb') ){
	function hue2rgb($p, $q, $t) {
	    if ($t < 0) $t += 1;
	    if ($t > 1) $t -= 1;
	    if ($t < 1/6) return $p + ($q - $p) * 6 * $t;
	    if ($t < 1/2) return $q;
	    if ($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;

	    return $p;
	}
}

if( !function_exists('rgb2hex') ){
	function rgb2hex($rgb) {
	return str_pad(dechex($rgb * 255), 2, '0', STR_PAD_LEFT);
	}
}

if( !function_exists('hex_to_rgb') ){
	function hex_to_rgb($hex){
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		//return implode(",", $rgb); // returns the rgb values separated by commas
		return $rgb; // returns an array with the rgb values
	}
}

if( !function_exists('get_rgba') ){
	function get_rgba($hex, $alpha){
		return 'rgba(' . implode(', ', hex_to_rgb($hex)) . ', ' . $alpha . ');';
	}
}


// make nav-fadein-toggle available in javascript
add_action('wp_enqueue_scripts', 'localize_home_dir');

if( !function_exists('localize_home_dir') ){
	function localize_home_dir(){
		wp_localize_script( 'theme', 'Home_URL', get_site_url());
	}
}

// are we on a login-esque page? 
if( !function_exists('is_login_page') ){
	function is_login_page() {
	    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
	}
}

// add some styles to the login page
if( !function_exists('update_login_styles') ){
	function update_login_styles(){
		if(is_login_page()){?>
			<style type="text/css">
				.login{
					background-image: url('<?php echo get_field('general-admin-bg', 'option'); ?>');
					background-size: cover;
					background-repeat: no-repeat;
				}
				#login h1 a, .login h1 a {	
		            background-image: url('<?php echo get_field('webx-logo', 'option'); ?>');
		            background-size: contain;
		            min-width: 300px;
		        }
			</style>
		<?php }
	}
}


// add gmap to pages that need it
add_action('wp_enqueue_scripts', 'add_gmaps_script');

if( !function_exists('add_gmaps_script') ){
	function add_gmaps_script(){
		if(get_field('gmaps-api-key', 'option') !== '' && is_home()){
			wp_enqueue_script('gmaps','https://maps.googleapis.com/maps/api/js?key=' . get_field('gmaps-api-key', 'option') . '&callback=window._initHomeMap', array(), null, true);	
		}
		else{
			wp_enqueue_script('gmaps','https://maps.googleapis.com/maps/api/js?key=AIzaSyBrRJwJFfNCdVLJwa6yhR8UBZR1m2A018Q&callback=window._initHomeMap', array(), null, true);	
		}
		localize_areas_served();
	}
}

// modify login form bottom
add_action('login_footer', 'action_login_footer');

if( !function_exists('action_login_footer') ){
	function action_login_footer(){
		?>
			<script type="text/javascript">
				document.querySelector('#backtoblog a').innerHTML = '&larr; Back to Theme';
			</script>
		<?php
	}
}


// programatically add pages
if( !function_exists('the_slug_exists') ){
	function the_slug_exists($post_name) {
		global $wpdb;
		if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
			return true;
		} else {
			return false;
		}
	}
}

// register pages
if( !function_exists('action_register_pages') ){
	function action_register_pages(){
		$pages = array(
			array(
				'title' => 'Company',
				'slug' => 'company',
			),
			array(
				'title' => 'Gallery',
				'slug' => 'gallery',
			),
			array(
				'title' => 'Services',
				'slug' => 'services',
			),
			array(
				'title' => 'Testimonials',
				'slug' => 'testimonials',
			),
			array(
				'title' => 'Areas Served',
				'slug' => 'areas-served',
			),
			array(
				'title' => 'Coupons',
				'slug' => 'coupons',
			),
			array(
				'title' => 'Contact',
				'slug' => 'contact',
			),
			array(
				'title' => 'Terms',
				'slug' => 'terms',
			),
			array(
				'title' => 'Menu',
				'slug' => 'menu',
			),
			array(
				'title' => 'Blog',
				'slug' => 'blog',
			),
			array(
				'title' => 'Disabled',
				'slug' => 'disabled',
			),
		);

		foreach ($pages as $page){
			if(!the_slug_exists($page['slug'])){
			    $page_title = $page['title'];
			    $page_content = '';
			    $page_check = get_page_by_title($page_title);
			    $page_args = array(
				    'post_type' => 'page',
				    'post_title' => $page_title,
				    'post_content' => $page_content,
				    'post_status' => 'publish',
				    'post_author' => 1,
				    'post_slug' => $page['slug']
			    );
			    if(!isset($page_check->ID) && !the_slug_exists($page['slug'])){
			        wp_insert_post($page_args);
			    }	
			}
		}
	}
}

add_action( 'init', 'action_register_pages' );


/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
if( !function_exists('register_coupon_cpt') ){
	function register_coupon_cpt() {

		$labels = array(
			'name'                => 'Coupon',
			'singular_name'       => 'Coupon',
			'add_new'             => 'Add Coupon',
			'add_new_item'        => 'Add New Coupon',
			'edit_item'           => 'Edit Coupon',
			'new_item'            => 'New Coupon',
			'view_item'           => 'View Coupon',
			'search_items'        => 'Search Coupons',
			'not_found'           => 'No Coupons Found',
			'not_found_in_trash'  => 'No Coupons Found in Trash',
			'parent_item_colon'   => 'Parent Coupon',
			'menu_name'           => 'Coupons',
			'all_items'           => 'All Coupons',
		);

		$args = array(
			'labels'                   => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 84,
			'menu_icon'           => 'dashicons-tickets',
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => array(
				'slug' => 'coupons',
			),
			'capability_type'     => 'post',
			'supports'            => array(
				'title', 'revisions', 'page-attributes', 'post-formats'
				)
		);

		register_post_type( 'coupon', $args );
	}
}

add_action( 'init', 'register_coupon_cpt' );




// setup editor and author admin backend
if( !function_exists('setup_editor_admin') ){
	function setup_editor_admin(){
	    $user = wp_get_current_user();
	    $allowed_roles = array('editor', 'author');

	    if ( array_intersect($allowed_roles, $user->roles ) ) {
			$user->add_cap('gform_full_access');
			remove_menu_page( 'edit.php?post_type=page' );
			remove_menu_page( 'tools.php' );
			remove_menu_page( 'profile.php' );
			remove_menu_page( 'edit-comments.php' );
			// remove_menu_page( 'edit.php' );

			add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
	    }
	    if ( array_intersect( array('author'), $user->roles ) ) {
	    	remove_menu_page( 'edit.php?post_type=coupon' );
	    	$user->remove_cap('gform_full_access');
	    }
	}
}

add_action('admin_init','setup_editor_admin');

// cleans out the dashboard widgets
if( !function_exists('remove_dashboard_widgets') ){
	function remove_dashboard_widgets() {
		global $wp_meta_boxes;

		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

	}
}

// prevent redirect after login to user.php
add_filter( 'login_redirect', 'handle_user_login_redirect', 10, 3 );

if( !function_exists('handle_user_login_redirect') ){
	function handle_user_login_redirect($url, $query, $user){
		return site_url("wp-admin");
	}
}

// change login screen logo url
add_filter( 'login_headerurl', 'custom_login_logo_url' );

if( !function_exists('custom_login_logo_url') ){
	function custom_login_logo_url() {
	    return home_url();
	}
}


// get the phone number for headers & footers
if( !function_exists('get_the_phone') ){
	function get_the_phone($phonetel = 'phone'){
		$social_phone = get_field('social-phone-number', 'option');
		if( !empty( str_replace( ' ', '', $social_phone) ) ){
			$search_for = array('(',')','-',' ','.');
			$replace_with = array('','','','','');
			$tel = str_replace($search_for, $replace_with, $social_phone);
			if($phonetel == 'tel'){
				return $tel;
			}
			else{
				return $social_phone;
			}
		}
		else{
			return '';
		}
	}
}
// returns tel: href safe (just numbers)
if( !function_exists('get_tel') ){
	function get_tel($the_phone){
		$search_for = array('(',')','-',' ','.');
		$replace_with = array('','','','','');
		$tel = str_replace($search_for, $replace_with, $the_phone);
		return $tel;
	}
}

// get the email address for footers
if( !function_exists('get_the_email') ){
	function get_the_email(){
		$social_email = get_field('social-email-address', 'option');
		$the_email = null;
		if( !empty($social_email) ){
			$the_email = $social_email;
		}
		else{
			$the_email = 'example@domain.com';
		}
		return $the_email;
	}
}

// get the fax number for footers
if( !function_exists('get_the_fax') ){
	function get_the_fax($phonetel = 'phone'){
		$social_fax = get_field('social-fax-number', 'option');

		if(!empty($social_fax)){
			$search_for = array('(',')','-',' ','.');
			$replace_with = array('','','','','');
			$tel = str_replace($search_for, $replace_with, $social_fax);
			if($phonetel == 'tel'){
				return $tel;
			}
			else{
				return $social_fax;
			}
		}
		else{
			return '';
		}
	}
}

// get the address for footers
if( !function_exists('get_the_address') ){
	function get_the_address(){
		
		if( !empty(get_field('social-address-line2', 'option')) && !empty(get_field('social-address', 'option')) ){
			$address_line2 = get_field('social-address-line2', 'option');
			return strstr(get_field('social-address', 'option')['address'],',', true) . ' ' . $address_line2 . strstr(get_field('social-address', 'option')['address'],',');
		}
		else if( !empty( get_field('social-address', 'option') ) ){
			return get_field( 'social-address', 'option' )['address'];
		}
		else{
			return '';
		}
	}
}


// unregisters a post type if found
if ( ! function_exists( 'unregister_post_type' ) ) :
	function unregister_post_type( $post_type ) {
	    global $wp_post_types;
	    if ( isset( $wp_post_types[ $post_type ] ) ) {
	        unset( $wp_post_types[ $post_type ] );
	        return true;
	    }
	    return false;
	}
endif;

// inputs post ID and desired status and changes the post to that status
if( !function_exists('change_post_status') ){
	function change_post_status($post_id, $status){
	    $current_post = get_post( $post_id, 'ARRAY_A' );
	    $current_post['post_status'] = $status;
	    wp_update_post($current_post);
	}
}

// set page statuses based on page toggles in Theme Settings > 4. Main Menu
if( !function_exists('set_page_status') ){
	function set_page_status($page){
		$page_id = get_page_by_path($page['name']);

		$pages = array(
			'company',
			'gallery',
			'services',
			'testimonials',
			'areas-served',
			'contact',
		);

		if(!is_null($page_id)){
			$page_id = $page_id->ID;	
		}

		if(!in_array($page['name'], $pages)){
			if($page['status'] == false || $page['status'] == null){
				change_post_status($page_id, 'private');
			}
			if($page['status'] == true){
				change_post_status($page_id, 'publish');
			}	
		}

	}
}

// get page toggles
if( !function_exists('my_get_page_statuses') ){
	function my_get_page_statuses(){
		$page_statuses = [];
		$page_names = array(
			'company',
			'gallery',
			'services',
			'menu',
			'blog',
			'testimonials',
			'areas-served',
			'coupons',
			'contact',
		);
		foreach($page_names as $page_name){
			
			array_push($page_statuses, array(
				'name' => $page_name,
				'status' => get_field($page_name . '-toggle', 'option'),
			));	
		
		}
		return $page_statuses;
	}
}

add_action('init', 'update_page_statuses');

// updates the page statuses "private/public"
if( !function_exists('update_page_statuses') ){
	function update_page_statuses(){
		$page_statuses = my_get_page_statuses();
		
		foreach($page_statuses as $page_status){
			set_page_status($page_status);
		}
	}
}

// retreives the active pages set by the checkboxes in Theme Settings > 4. Main Menu
if( !function_exists('get_active_pages') ){
	function get_active_pages(){
		$page_statuses = my_get_page_statuses();

		$active_pages = array_filter($page_statuses, function($var){
			if($var['status'] == true){
				return $var;
			}
		});

		return $active_pages;
	}
}

// determines if a page isn't disabled in the Theme Settings > 4. Main Menu section
if( !function_exists('is_active_page') ){
	function is_active_page($name){
		$active_pages = get_active_pages();
		foreach($active_pages as $active_page){
			if($active_page['name'] == $name){
				return true;
			}
		}
		return false;
	}
}

// displays page links
if( !function_exists('render_page_links') ){
	function render_page_links($menu_class = '', $menu_item_class = '', $menu_item_link_class = ''){
		$render_string = '<ul class="' . $menu_class . '">';

		$active_pages = get_active_pages();

		foreach($active_pages as $active_page){

			$link_url = '';

			if( is_home() ){
				$link_url = '#' . $active_page['name'];
			}
			else{
				$link_url = get_site_url() . '/#' . $active_page['name'];
			}

			$page_name =  get_field($active_page['name'].'-alt-toggle', 'option') && !empty(get_field($active_page['name'].'-alt', 'option')) ? get_field($active_page['name'].'-alt', 'option') : str_replace('-', ' ', $active_page['name']);
			$render_string .= '<li class="' . $menu_item_class .'">' . '<a href="' . $link_url . '" class="' . $menu_item_link_class . '">' . $page_name . '</a></li>';
		}

		$render_string .= '</ul>';

		echo $render_string;
	}
}

// displays social links
if( !function_exists('render_post_social_links') ){
	function render_post_social_links($post_id, $link_class, $icon_class){
		$social_links_string = '';
		$permalink = get_permalink($post_id);

		$facebook_url = 'https://www.facebook.com/dialog/feed?app_id=209491889470337&link=' . rawurlencode($permalink);
		$twitter_url = 'https://twitter.com/home?status=' . urlencode($permalink);
		$googleplus_url = 'https://plus.google.com/share?url=' . $permalink;
		$pinterest_url = '//pinterest.com/pin/create/link/?url=' . rawurlencode($permalink) . '&media=' . wp_get_attachment_url( get_post_thumbnail_id($post_id) ) . '&description=' . rawurlencode(get_post($post_id)->post_title);
		$tumblr_url = 'http://www.tumblr.com/share/link?url=' . urlencode($permalink);
		$mailto_url = "mailto:your@friend.com?&body=I%20think%20you'll%20like%20this%20page%3A%20" . rawurlencode($permalink);

		// facebook (doesnt work on localhost but works on production url)
		$social_links_string .= '<a target="_blank" class="sociallink ' . $link_class . '" href="' . $facebook_url . '"><i class="fa fa-facebook ' . $icon_class . ' sociallink-icon"></i></a>';
		// twitter
		$social_links_string .= '<a target="_blank" class="sociallink ' . $link_class . '" href="' . $twitter_url . '"><i class="fa fa-twitter ' . $icon_class . ' sociallink-icon"></i></a>';
		// googleplus (doesnt work on localhost but works on production url)
		$social_links_string .= '<a target="_blank" class="sociallink ' . $link_class . '" href="' . $googleplus_url . '"><i class="fa fa-google-plus ' . $icon_class . ' sociallink-icon"></i></a>';
		// pinterest
		$social_links_string .= '<a target="_blank" class="sociallink ' . $link_class . '" href="' . $pinterest_url . '"><i class="fa fa-pinterest-p ' . $icon_class . ' sociallink-icon"></i></a>';
		// tumblr (doesnt work on localhost but works with production url)
		$social_links_string .= '<a target="_blank" class="sociallink ' . $link_class . '" href="' . $tumblr_url . '"><i class="fa fa-tumblr ' . $icon_class . ' sociallink-icon"></i></a>';
		// mailto
		$social_links_string .= '<a class="sociallink ' . $link_class . '" href="' . $mailto_url . '"><i class="fa fa-envelope ' . $icon_class . ' sociallink-icon"></i></a>';

		echo $social_links_string;
	}
}

// gets the image for the blog post with the placeholder image as the fallback
if( !function_exists('get_blog_image') ){	
	function get_blog_image($post_id){
		$image_url = '';

		if( !empty( wp_get_attachment_url( get_post_thumbnail_id($post_id) ) ) ){
			$image_url = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
		}
		else{
			$image_url = get_field('featured-placeholder', 'option');
		}

		return $image_url;
	}
}


// generates Logo text when logo type switch is set to text
if( !function_exists('update_logo_text_image') ){
	function update_logo_text_image(){
		if( basename($_SERVER['REQUEST_URI']) == 'admin.php?page=general-settings' && get_field('logo-type-switch', 'option') == 'text' ){

			$bg = get_template_directory() . '/library/img/logo-canvas.png';

			$phpimg = new PHPImage();

			$phpimg->setDimensionsFromImage($bg);
			$phpimg->setQuality(9);
			$phpimg->setFont(get_template_directory() . '/library/fonts/GothamHTF-Medium.ttf');

			$text_color = array(255, 255, 255);

			if( get_field('navs-text-toggle', 'option') ){
				$text_color = hex_to_rgb(get_field('navs-text', 'option'));
			}

			$phpimg->setTextColor($text_color);

			$phpimg->text(get_bloginfo('name'), array(
		        'fontSize' => 60, 
		        'x' => 0,
		        'y' => 0,
		        'width' => 560,
		        'height' => 128,
		        'alignHorizontal' => 'center',
		        'alignVertical' => 'center',
		    ));

			$phpimg->imagetrim();

			$phpimg->setOutput('png');

			$phpimg->save(get_template_directory() . '/library/img/logo-text.png');

		}
	}
}

add_action('save_post', 'update_logo_text_image');

// returns the logo based on the logo type switch set in Theme Settings > 1. Company Info
if( !function_exists('get_logo') ){
	function get_logo(){
		if(get_field('logo-type-switch', 'option') == 'text'){
			return get_template_directory_uri() . '/library/img/logo-text.png';
		}
		else{
			return get_field('general-logo', 'option');
		}
	}
}

add_action('init', 'myprefix_unregister_tags');

// removes Post's tag taxonomy
if( !function_exists('myprefix_unregister_tags') ){
	function myprefix_unregister_tags() {
	    unregister_taxonomy_for_object_type('post_tag', 'post');
	}
}

add_action('admin_menu', 'wpse_233129_admin_menu_items');

// rearranges position and name of Posts
if( !function_exists('wpse_233129_admin_menu_items') ){
	function wpse_233129_admin_menu_items() {
	    global $menu;

	    $menu[5][0] = 'Blog Posts';

	    foreach ( $menu as $key => $value ) {
	        if ( 'edit.php' == $value[2] ) {
	            $oldkey = $key;
	        }
	    }
	    
	    // change Posts menu position in the backend

	    $newkey = 83; // use whatever index gets you the position you want
	    // if this key is in use you will write over a menu item!
	    $menu[$newkey]=$menu[$oldkey];
	    $menu[$oldkey]=array();

	}
}

// determines if an acf repeater is empty
if(!function_exists('rows_empty')){
	function rows_empty($key, $src = 'option'){
		try {
			$rows = get_field($key, $src);
			$count = [];
			foreach( $rows as $row ){
				array_values($row)[0] == false ? array_push($count, false) : array_push($count, true);
			}
			if( in_array(true, $count) ){
				return false;
			}
			else{
				return true;
			}
		} catch (Exception $e) {
			echo $e;
		}
	}
}

// constructs parallax backgrounds for homepage from background images set per section
if(!function_exists('the_bg')){
	function the_bg($slug, $useslug = true){
		if(!$useslug){
			$bg = get_field($slug, 'option');
		}
		else{
			$bg = get_field($slug . '-bg', 'option');	
		}
		$output = '';
		if( !empty($bg) ){
			$output .= '<div class="parallax">';
			$output .=     '<img class="parallax-image" src="' . $bg . '">';
			$output .= '</div>';
			echo $output;
		}
	}
}

// recursive strpos returns array of positions of needle in haystack
if( !function_exists('strpos_r') ){
	function strpos_r($haystack, $needle){
		$lastPos = 0;
		$positions = [];
		while ( ( $lastPos = strpos($haystack, $needle, $lastPos) ) !== false ) {
		    $positions[] = $lastPos;
		    $lastPos = $lastPos + strlen($needle);
		}
		return $positions;
	}
}

// sets a notice of site being disabled
if( !function_exists('admin_notify_disabled_site') ){
	function admin_notify_disabled_site() {
	    ?>
	    <div class="notice notice-error" style="background-color: #ffdadf;">
	        <p style="text-transform: uppercase; font-size: 24px; color: red; margin-bottom: 0px;">This site has been disabled!</p>
	        <p style="margin-top: 0px;">To enable it go to the Disable Site tab in Theme Settings</p>
	    </div>
	    <?php
	}
}

add_action('get_header', 'handle_disabled_site');
add_action('admin_head', 'handle_disabled_site');

// setup redirects & notices if site-disabled is active
if( !function_exists('handle_disabled_site') ){
	function handle_disabled_site(){
		if( get_field('disable-site', 'option') == true ){
			global $post;
			$slug = $post->post_name;
			add_action( 'admin_notices', 'admin_notify_disabled_site' );
			if( $slug == 'disabled' || is_admin() ){
				if( is_admin() && !current_user_can('activate_plugins') ){
					wp_logout();
					wp_redirect( home_url( '/disabled/' ), 301 );
				    exit;	
				}
			}
			else{
				wp_redirect( home_url( '/disabled/' ), 301 );
			    exit;	
			}
		}
	}
}


// CUSTOM LOGIN MESSAGES
add_filter('login_message', 'disable_site_login_message');

if( !function_exists('disable_site_login_message') ){
	function disable_site_login_message() {
		if( get_field('disable-site', 'option') ){
	        $message = '<p class="message"><b>Site has been disabled</b><br/>Call ' . get_field("webx-phone", "option") . ' for help.</p>';
	        return $message;
		}
	}
}


add_action('wp_login', 'login_during_disable_site', 10, 2);

// stop user from logging in during site disabled if they're not admin
if( !function_exists('login_during_disable_site') ){
	function login_during_disable_site($user_login, $user){
		if( !$user->has_cap('activate_plugins') ){
			wp_logout();
			wp_redirect( home_url( '/disabled/' ), 301 );
		    exit;	
		}
	}	
}


add_action( 'init', 'set_disabled_page_status' );

// handle disable site page status
if( !function_exists('set_disabled_page_status') ){
	function set_disabled_page_status(){
		if( get_field('disable-site', 'option') == true ){
			change_post_status(get_page_by_path('disabled')->ID, 'public');
		}
		else{
			change_post_status(get_page_by_path('disabled')->ID, 'private');
		}
	}
}


?>