<?php get_header(); 


$sorted = get_field('section-sort', 'option');
$built_sorted = array();
foreach( $sorted as $item ){
	array_push($built_sorted, str_replace( ' ', '-', strtolower($item['section-sort-text']) ) );
}

$sections = array_merge(array('heroslider'), $built_sorted);

foreach($sections as $section){
	if($section !== 'heroslider'){
		if(get_field($section . '-toggle', 'option')){
			static $count = 0;
			if($count == 0){
				$count++;
				include(locate_template( 'modules/' . $section . '.php' ));
				continue;
			}
			if($section == 'areas-served' || $section == 'contact'){
				
			}
			else{
				if($section == 'blog'){
					the_bg('general-blog-bg', false);	
				}
				else if($section == 'coupons'){
					the_bg('general-coupons-bg', false);
				}
				else{
					the_bg($section);		
				}
				
			}
			include(locate_template( 'modules/' . $section . '.php' ));
			$count++;
		}
	}
	else{
		include(locate_template( 'modules/heroslider.php' ));
	}
}

get_footer(); ?>