<?php get_header(); 

$sections = array(
	'company',
	'gallery',
	'services',
	'menu',
	'blog',
	'areas-served',
	'testimonials',
	'coupons',
	'contact',
);

foreach($sections as $section){
	if(get_field($section . '-toggle', 'option')){
		include(locate_template( 'modules/' . $section . '.php' ));
	}
}

get_footer(); ?>