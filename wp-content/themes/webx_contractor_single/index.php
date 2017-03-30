<?php get_header(); 

$sections = array(
	'heroslider',
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

foreach($sections as $section){
	if($section !== 'heroslider'){
		if(get_field($section . '-toggle', 'option')){
			if($section !== 'areas-served'){
				the_bg($section);	
			}
			include(locate_template( 'modules/' . $section . '.php' ));
		}
	}
	else{
		include(locate_template( 'modules/heroslider.php' ));
	}
}

get_footer(); ?>