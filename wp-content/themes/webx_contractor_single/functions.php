<?php 


// configure style/script registration/enqueing, menu registration, after_setup_theme filter
show_admin_bar( false );

add_action( 'after_setup_theme', function(){
	add_theme_support( 'html5' );
	add_theme_support( 'post-thumbnails' );
});

add_action( 'init', function(){
	clean_head();
	register_nav_menu( 'main-nav', 'Main Navigation');
});

add_action( 'wp_enqueue_scripts', function(){
	register_styles();
	enqueue_styles();
	register_javascript();
	enqueue_javascript();		
});

function enqueue_javascript(){
	wp_enqueue_script( 'theme' );
}
function enqueue_styles(){
	wp_enqueue_style( 'theme' );
}

function register_javascript(){
	wp_register_script( 'theme', get_template_directory_uri() . '/build/js/build.js');
}

function register_styles(){
	wp_register_style( 'theme', get_template_directory_uri() . '/build/css/build.css' );
}

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

// make areas served zips available to javascript
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

// make contact lat lng available to javascript
function localize_contact_address(){
	$fields = [];
	$rows = get_field('addresses-repeater', 'option');
	foreach($rows as $row){
		array_push($fields, $row['addresses-gmap']);
	}
	wp_localize_script( 'theme', 'ContactAddresses', $fields );
}
add_action('wp_enqueue_scripts', 'localize_contact_address');

// make nav-fadein-toggle available in javascript
function localize_fadein_toggle(){
	$val = var_export(get_field('nav-fadein-toggle', 'option'), true);
	wp_localize_script( 'theme', 'DisableNavTintFadein', $val);
}
add_action('wp_enqueue_scripts', 'localize_fadein_toggle');

function enqueue_login_scripts(){
	update_login_styles();
	wp_enqueue_style('custom-login', get_template_directory_uri() . '/build/css/login.css' ); 
}
add_action( 'login_enqueue_scripts', 'enqueue_login_scripts' );

// make nav-fadein-toggle available in javascript
function localize_home_dir(){
	wp_localize_script( 'theme', 'Home_URL', get_site_url());
}
add_action('wp_enqueue_scripts', 'localize_home_dir');


function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

function update_login_styles(){
	if(is_login_page()){?>
		<style type="text/css">
			.login{
				background-image: url('<?php echo get_field('general-admin-bg', 'option'); ?>');
				background-size: cover;
				background-repeat: no-repeat;
			}
			#login h1 a, .login h1 a {
	            background-image: url('<?php echo  get_field('general-logo', 'option'); ?>');
	            min-width: 300px;
	            background-size: contain;
	        }
		</style>
	<?php }
}

// add gmap to pages that need it
add_action('wp_enqueue_scripts', 'add_gmaps_script');

function add_gmaps_script(){
	if(get_field('gmaps-api-key', 'option') !== ''){
		wp_enqueue_script('gmaps','https://maps.googleapis.com/maps/api/js?key=' . get_field('gmaps-api-key', 'option') . '&callback=window._initHomeMap', array(), null, true);	
	}
	else{
		wp_enqueue_script('gmaps','https://maps.googleapis.com/maps/api/js?key=AIzaSyBrRJwJFfNCdVLJwa6yhR8UBZR1m2A018Q&callback=window._initHomeMap', array(), null, true);	
	}
	localize_areas_served();
}



// programatically add pages
function the_slug_exists($post_name) {
	global $wpdb;
	if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
		return true;
	} else {
		return false;
	}
}

// register pages
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


/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
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

add_action( 'init', 'register_coupon_cpt' );



// register ACF fields
require('acf.php');


// setup editor and author admin backend
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

add_action('admin_init','setup_editor_admin');


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

// prevent redirect after login to user.php
add_filter( 'login_redirect', create_function( '$url,$query,$user', 'return site_url("wp-admin");' ), 10, 3 );

// change login screen logo url
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );


// get the phone number for headers & footers
function get_the_phone($phonetel = 'phone'){
	$social_phone = get_field('social-phone-number', 'option');
	$contact_office = get_field('contact-office', 'option');

	$the_phone = null;
	if(!empty($social_phone)){
		$the_phone = $social_phone;
	}
	else{
		if(!empty($contact_office)){
			$the_phone = $contact_office;
		}
		else{
			$the_phone = '(555) 555-5555';
		}
	}

	$search_for = array('(',')','-',' ','.');
	$replace_with = array('','','','','');
	$tel = str_replace($search_for, $replace_with, $the_phone);
	if($phonetel == 'tel'){
		return $tel;
	}
	else{
		return $the_phone;
	}
}
function get_tel($the_phone){
	$search_for = array('(',')','-',' ','.');
	$replace_with = array('','','','','');
	$tel = str_replace($search_for, $replace_with, $the_phone);
	return $tel;
}
// get the email address for footers
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

// get the fax number for footers
function get_the_fax($phonetel = 'phone'){
	$social_fax = get_field('social-fax-number', 'option');
	$the_fax = null;

	if(!empty($social_fax)){
		$the_fax = $social_fax;
	}

	$rows = get_field('addresses-repeater', 'option');

	foreach($rows as $row){
		if( !empty($row['contact-fax']) && empty($social_fax) ){
			$the_fax = $row['contact-fax'];
		}
	}

	if($the_fax == null){
		$the_fax = '555-555-5555';
	}

	$search_for = array('(',')','-',' ','.');
	$replace_with = array('','','','','');
	$tel = str_replace($search_for, $replace_with, $the_fax);
	if($phonetel == 'tel'){
		return $tel;
	}
	else{
		return $the_fax;
	}
}

// get the address for footers
function get_the_address(){
	$address_with_extra = null;

	if( !empty(get_field('social-address-line2', 'option')) && !empty(get_field('social-address', 'option')) ){
		$address_line2 = get_field('social-address-line2', 'option');
		$address_with_extra = strstr(get_field('social-address', 'option')['address'],',', true) . ' ' . $address_line2 . strstr(get_field('social-address', 'option')['address'],',');
	}

	if($address_with_extra == null){
		if( !empty(get_field('social-address', 'option')['address']) ){
			return get_field('social-address', 'option')['address'];
		}
		else{
			$rows = get_field('addresses-repeater', 'option');

			foreach($rows as $row){
				$row_address_with_line2 = null;

				if( !empty($row['addresses-gmap']) && !empty($row['addresses-extra']) ){
					$row_address_line2 = $row['addresses-extra'];
					$row_address_with_line2 = strstr($row['addresses-gmap']['address'],',', true) . ' ' . $row_address_line2 . strstr($row['addresses-gmap']['address'],',');
				}

				if($row_address_with_line2 == null){
					if( !empty($row['addresses-gmap']) ){
						return $row['addresses-gmap'];
					}
					else{
						return '123 fake st, anywhere anystate 01234 USA';
					}
				}
				else{
					return $row_address_with_line2;
				}
			}
		}
	}
	else{
		return $address_with_extra;
	}
}



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

function change_post_status($post_id, $status){
    $current_post = get_post( $post_id, 'ARRAY_A' );
    $current_post['post_status'] = $status;
    wp_update_post($current_post);
}
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
function update_page_statuses(){
	$page_statuses = my_get_page_statuses();
	
	foreach($page_statuses as $page_status){
		set_page_status($page_status);
	}
}

add_action('init', 'update_page_statuses');
function get_active_pages(){
	$page_statuses = my_get_page_statuses();

	$active_pages = array_filter($page_statuses, function($var){
		if($var['status'] == true){
			return $var;
		}
	});

	return $active_pages;
}
function is_active_page($name){
	$active_pages = get_active_pages();
	foreach($active_pages as $active_page){
		if($active_page['name'] == $name){
			return true;
		}
	}
	return false;
}
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

include('PHPImage.php');

function update_logo_text_image(){
	if( basename($_SERVER['REQUEST_URI']) == 'admin.php?page=general-settings' && get_field('logo-type-switch', 'option') == 'text' ){

		$bg = get_template_directory() . '/library/img/logo-canvas.png';

		$phpimg = new PHPImage();

		$phpimg->setDimensionsFromImage($bg);
		$phpimg->setQuality(9);
		$phpimg->setFont(get_template_directory() . '/library/fonts/GothamHTF-Book.ttf');
		$phpimg->setTextColor(array(255, 255, 255));

		$phpimg->text(get_bloginfo('name'), array(
		        'fontSize' => 60, 
		        'x' => 0,
		        'y' => 0,
		        'width' => 280,
		        'height' => 64,
		        'alignHorizontal' => 'center',
		        'alignVertical' => 'center',
		    ));

		$phpimg->setOutput('png');

		$phpimg->save(get_template_directory() . '/library/img/logo-text.png');

	}
}

add_action('save_post', 'update_logo_text_image');


function get_logo(){
	if(get_field('logo-type-switch', 'option') == 'text'){
		return get_template_directory_uri() . '/library/img/logo-text.png';
	}
	else{
		return get_field('general-logo', 'option');
	}
}

function myprefix_unregister_tags() {
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'myprefix_unregister_tags');


function wpse_233129_admin_menu_items() {
    global $menu;

    foreach ( $menu as $key => $value ) {
        if ( 'edit.php' == $value[2] ) {
            $oldkey = $key;
        }
    }

    $newkey = 86; // use whatever index gets you the position you want
    // if this key is in use you will write over a menu item!
    $menu[$newkey]=$menu[$oldkey];
    $menu[$oldkey]=array();

}
add_action('admin_menu', 'wpse_233129_admin_menu_items');


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


if(!function_exists('the_bg')){
	function the_bg($slug){
		$bg = get_field($slug . '-bg', 'option');
		$output = '';
		if( !empty($bg) ){
			$output .= '<div class="parallax">';
			$output .=     '<img class="parallax-image" src="' . $bg . '">';
			$output .= '</div>';
			echo $output;
		}
	}
}









?>