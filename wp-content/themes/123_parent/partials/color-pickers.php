<?php 




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
			.company-employees-grid-item-socialcontainer-link,
			.home-hero-text-button
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

if( get_field('bold-title-text-toggle', 'option') ):
	$color = get_field('bold-title-text', 'option');?>
	<style type="text/css">
		section:not(.home-hero):not(#coupons):not(#blog) .hero-text-header{
			color: <?php echo $color ?>;
		}
		.section-header{
			border-color: <?php echo $color ?>;
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
			.header-topbar,
			.footer-copyright{
				background-color: <?php echo $color ?>;
			}
		</style>
	<?php
endif;


