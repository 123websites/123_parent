<?php 

$primary_color = get_field('primary_color', 'option') == '' ? null : '#' . substr(get_field('primary_color', 'option'), 1);
$background_color = get_field('background_color', 'option') == '' ? null : '#' . substr(get_field('background_color', 'option'), 1);
$master_variable_color = get_field('variable_color', 'option') == '' ? null : substr(get_field('variable_color', 'option'), 1);

$variable_colors = [];
$variable_colors_keyvalues = array(
	'footer_grey' => 0.26,
	'medium_grey' => 0.22,
	'light_grey' => 0.88,
	'estimate_bar' => 0.98,
	'header_tint' => 0.92,
	'footer_bg' => 0.74,
);

if(!empty($master_variable_color)){
	for($i = 0; $i < 6; $i++){
		$hsl = hex_to_hsl($master_variable_color);
		$hsl[2] = array_values( $variable_colors_keyvalues )[$i];
		$variable_colors[ array_keys( $variable_colors_keyvalues )[$i] ] = '#'.hsl_to_hex($hsl);
	}	
}



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

function hsl_to_hex($hsl)
{
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
function hue2rgb($p, $q, $t) {
    if ($t < 0) $t += 1;
    if ($t > 1) $t -= 1;
    if ($t < 1/6) return $p + ($q - $p) * 6 * $t;
    if ($t < 1/2) return $q;
    if ($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;

    return $p;
}
function rgb2hex($rgb) {
    return str_pad(dechex($rgb * 255), 2, '0', STR_PAD_LEFT);
}
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

function get_rgba($hex, $alpha){
	return 'rgba(' . implode(', ', hex_to_rgb($hex)) . ', ' . $alpha . ');';
}

if(get_field('primary_color_toggle', 'option')):
?>
<style type="text/css">
	/* PRIMARY-COLOR STUFF */
	@media only screen {
		.ginput_container textarea:focus{
			outline-color: <?php echo $primary_color; ?>;
		}	
		.gform_footer input[type='submit'],
		.global-contact-content-button,
		.global-recentposts-viewall,
		.sociallink,
		.wp-core-ui .button-group.button-large .button, .wp-core-ui .button.button-large,
		.company-employees-grid-item-socialcontainer-link,
		#baguetteBox-overlay .full-image figure figcaption,
		.home-hero-text-button,
		.home-services-grid-item-header,
		.home-services-viewall,
		.home-testimonials-viewall,
		.mobilefooter-sharebutton,
		.mobilefooter-sociallinks-item,
		.header-content-quickquote{
			background-color: <?php echo $primary_color; ?>;
		}
		.login p.message,
		.login #login #login_error{
			border-left: 5px solid <?php echo $primary_color; ?>;
		}
		.login form .input:focus, 
		.login form input[type=checkbox]:focus, 
		.login input[type=text]:focus,
		.hero-text-header--nobg,
		.blog-blog-sidebar-categories-header,
		.blog-blog-sidebar-archive-header,
		.blog-blog-sidebar-recentposts-header,
		.global-recentposts-grid-item-header:after,
		.section-header,
		.contact-contact-left-locations-header:after{
			border-color: <?php echo $primary_color; ?> !important;
		}
		.mobileheader-menus-social-menu-item-link-icon{
			color: <?php echo $primary_color; ?>;
		}
	}
	@media only screen and (min-width: 1025px){
		.areas-served-areas-grid-imagecontainer-tint,
		a.blog-blog-sidebar-quickquote{
			background-color: <?php echo get_rgba($primary_color, 1); ?>;
		}
		.footer-sociallinks-item{
			background-color: <?php echo $primary_color; ?>;	
		}
	}
	@media only screen and (min-width: 1167px){
		.header-content-quickquote{
			border-color: <?php echo $primary_color; ?>;	
		}
	}
	@media only print{
		.coupons-coupons-grid-item{
			background-color: <?php echo $primary_color; ?>;
		}
	}
</style>
<?php endif; 
if(get_field('variable_color_toggle', 'option')):
?>
<style type="text/css">
	/* FOOTER-GREY STUFF */
	@media only screen {
		.login p.message,
		.login #login #login_error,
		.coupons-coupons-grid-item,
		.mobilefooter{
			background-color: <?php echo $variable_colors['footer_grey'] ?>;	
		}	
		#loginform{
			background-color: <?php echo get_rgba($variable_colors['footer_grey'], 0.85); ?>;
		}
		.login #backtoblog,
		.login #nav{
			background-color: <?php echo get_rgba($variable_colors['footer_grey'], 0.85); ?>;
		}
	}

	@media only screen and (min-width: 1025px){
		.popup{
			background-color: <?php echo $variable_colors['footer_grey'] ?>;
		}	
		.footer{
			background-color: <?php echo $variable_colors['footer_grey']; ?>;
		}
	}
	

	/* MEDIUM-GREY STUFF */
	@media only screen {
		.mobileheader-bar-tint{
			background-color: <?php echo $variable_colors['medium_grey']; ?>;
		}
		.footer-pagelinks:after,
		.footer-pagelinks:before,
		.footer-middlecolumn2:after{
			border-color: <?php echo $variable_colors['medium_grey']; ?>;
		}
	}
	@media only screen and (min-width: 1167px){
		.header-tint{
			background-color: <?php echo $variable_colors['medium_grey']; ?>;	
		}	
	}

	/* LIGHT-GREY STUFF */
	@media only screen {
		.page404-hero,
		.company-employees-grid-item,
		.home-testimonials-grid-item,
		.testimonials-testimonials-grid-item,
		.menu-menu,
		.menu-hero,
		.blog-blog-sidebar{
			background-color: <?php echo $variable_colors['light_grey']; ?>;	
		}	
	}

	@media only screen and (min-width: 1025px){
		.home-testimonials{
			background-color: <?php echo $variable_colors['light_grey']; ?>;		
		}
		.home-testimonials:after{
			border-color: <?php echo $variable_colors['light_grey']; ?> transparent transparent transparent;
		}
	}

	/* ESTIMATE-BAR STUFF */
	@media only screen {
		header.light.mobileheader-estimate{
			background-color: <?php echo $variable_colors['estimate_bar']; ?>;	
		}
	}
	@media only screen and (min-width: 1025px){
		footer.footer.light.footer-copyright{
			background-color: <?php echo $variable_colors['estimate_bar']; ?>;
		}	
	}

	@media only screen and (min-width: 1167px){
		header.light.header-estimate{
			background-color: <?php echo $variable_colors['estimate_bar']; ?>;		
		}
	}

	

	/* HEADER-TINT STUFF */
	@media only screen {
		header.light.mobileheader-bar-tint,
		header.light.mobileheader-tint{
			background-color: <?php echo $variable_colors['header_tint']; ?>;
		}
	}
	@media only screen and (min-width: 1167px){
		header.light.header-tint{
			background-color: <?php echo $variable_colors['header_tint']; ?>;
		}
	}

	/* FOOTER-BG STUFF */
	@media only screen {
		footer.mobilefooter.light{
			background-color: <?php echo $variable_colors['footer_bg']; ?>;
		}
		.coupons-coupons-grid-item{
			border-color: <?php echo $variable_colors['footer_bg']; ?>;
		}
	}
	@media only screen and (min-width: 1025px){
		footer.footer.light{
			background-color: <?php echo $variable_colors['footer_bg']; ?>;
		}
	}
</style>
<?php endif;
if(get_field('background_color_toggle', 'option')): ?>
<style type="text/css">
	@media only screen {
		body{
			background-color: <?php echo $background_color; ?>;
		}
	}	
	@media only screen and (min-width: 1025px){
		.home-testimonials:before{
			border-color: <?php echo $background_color; ?> transparent transparent transparent;
		}	
	}
</style>
<?php endif; ?>








