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
			if($section == 'areas-served' || $section == 'contact'){
				
			}
			else{
				the_bg($section);	
			}
			if($section == 'blog'){
				the_bg('general-blog-bg', false);	
			}
			if($section == 'coupons'){
				the_bg('general-coupons-bg', false);
			}
			include(locate_template( 'modules/' . $section . '.php' ));
		}
	}
	else{
		include(locate_template( 'modules/heroslider.php' ));
	}
}

get_footer(); ?>