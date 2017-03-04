<?php get_header(); 

$sections = array(
	'company-toggle',
	'gallery-toggle',
	'services-toggle',
	'menu-toggle',
	'blog-toggle',
	'areas-served-toggle',
	'testimonials-toggle',
	'coupons-toggle',
	'contact-toggle',
);

foreach($sections as $section){
	if(get_field($section, 'option')){
		include(locate_template( 'modules/' . str_replace('-toggle', '', $section) . '.php' ));
	}
}

get_footer(); ?>