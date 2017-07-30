<?php get_header() ?>
	
	<div class="disabled" style="background-image: url('<?php the_field('general-admin-bg', 'option'); ?>');">
		<div class="disabled-center">
			<h1 class="disabled-center-header">Website Disabled</h1>
			<div class="disabled-center-subheader">
				Sorry it appears we've encountered a problem. <br/>
				Please contact a <?php the_field('webx-name', 'option'); ?> representative to reinstate your service.
			</div>
			<a href="tel:<?php the_field('webx-phone', 'option'); ?>" class="disabled-center-tel"><?php the_field('webx-phone', 'option') ?></a>
			<img src="<?php the_field('webx-logo', 'option'); ?>" class="disabled-center-image">
		</div>
		<div class="disabled-tint"></div>
	</div>

<?php get_footer(); ?>