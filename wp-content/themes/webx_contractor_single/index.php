<?php get_header(); 

$sections = array(
	'heroslider',
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
	if($section !== 'heroslider'){
		if(get_field($section . '-toggle', 'option')){
			include(locate_template( 'modules/' . $section . '.php' ));
		}
	}
	else{
		include(locate_template( 'modules/heroslider.php' ));
	}
}

get_footer(); ?>