<?php 


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


if( get_field('navs-bg-toggle', 'option') ):
	$color = get_field('navs-bg', 'option');
	?>
	<style type="text/css">
		header.light .header-tint,
		header .header-tint,
		header.light .mobileheader-bar-tint, 
		header.light .mobileheader-tint,
		header .mobileheader-bar-tint, 
		header .mobileheader-tint,
		footer.mobilefooter.light,
		footer.mobilefooter,
		footer.footer.light,
		footer.footer{
			background-color: <?php echo $color ?>;
		}
	</style>
	<?php
endif;

if( get_field('navs-text-toggle', 'option') ):
	$color = get_field('navs-text', 'option');
	?>
	<style type="text/css">
		.footer-contactlinks-email, 
		.footer-contactlinks-address,
		.footer-contactlinks-fax, 
		.footer-contactlinks-phone,
		.footer-pagelinks-item-link,
		.footer-pagelinks:before, 
		.footer-pagelinks:after,
		.footer-webxlink div,
		.header-content-menus-pages-menu-item-link,
		.header-content-menus-social-menu-item-link,
		.header-content-menus-social-menu-item:last-of-type .header-content-menus-social-menu-item-link,
		.mobilefooter-contactlinks-address,
		.mobilefooter-contactlinks-email, 
		.mobilefooter-contactlinks-fax, 
		.mobilefooter-contactlinks-phone,
		.mobilefooter-pagelinks-item-link,
		.mobilefooter-copyright,
		.mobilefooter-copyright a,
		.mobileheader-menus-pages-menu-item-link,
		.mobileheader-menus-contact-email, 
		.mobileheader-menus-contact-phone,
		.mobileheader-menus-social-menu-item-link-icon
		{ 
			border-color: <?php echo $color; ?>;
			color: <?php echo $color; ?>;
		}
	</style>
	<?php
endif;

if( get_field('buttons-underlines-toggle', 'option') ):
	$color = get_field('buttons-underlines', 'option');
	?>	
		<style type="text/css">
			.main .hero-text-header:after,
			.header-content-quickquote,
			a.blog-blog-sidebar-quickquote,
			.global-recentposts-viewall,
			.sociallink,
			.contact-contact-left-locations-header:after,
			.gform_footer input[type='submit'],
			.footer-sociallinks-item,
			.company-employees-grid-item-socialcontainer-link
			{
				border-color: <?php echo $color; ?>;
				background-color: <?php echo $color; ?>;
			}

			.blog-blog-sidebar-recentposts-header, 
			.blog-blog-sidebar-archive-header, 
			.blog-blog-sidebar-categories-header{
				border-color: <?php echo $color; ?>;	
			}
		</style>
	<?php
endif;

if( get_field('sidebar-coupon-areasserved-bg-toggle', 'option') ):
	$color = get_field('sidebar-coupon-areasserved-bg', 'option'); ?>
		<style type="text/css">
			.blog-blog-sidebar,
			.coupons-coupons-grid-item,
			.areas-served-areas-grid-imagecontainer-citystate{
				background-color: <?php echo $color; ?>;
			}
		</style>
	<?php
endif;

if( get_field('top-bottom-bg-toggle', 'option') ):
	$color = get_field('top-bottom-bg', 'option');?>
		<style type="text/css">
			.header-estimate,
			.footer-copyright{
				background-color: <?php echo $color ?>;
			}
		</style>
	<?php
endif;


