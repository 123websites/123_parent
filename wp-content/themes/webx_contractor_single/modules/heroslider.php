<section class="home-hero hero">
	<div class="home-hero-text hero-text">
		<h1 class="home-hero-text-header hero-text-header"><?php echo get_field('home-hero-header-text', 'option'); ?></h1>
		<?php if(is_active_page('contact')): ?>
			<a href="<?php echo site_url(); ?>/#company" class="home-hero-text-button">Learn More</a>	
		<?php endif; ?>
	</div>
	<?php $rows = get_field('general-home-slider', 'option'); ?>
	<?php if(have_rows('general-home-slider', 'option') && count($rows) >= 3): ?>
	<div class="home-hero-slides">
		<?php while(have_rows('general-home-slider', 'option')): the_row(); ?>
			<div style="background-image: url('<?php echo get_sub_field('general-home-slider-image'); ?>');" class="home-hero-slides-slide"></div>
		<?php endwhile; ?>
	<?php else: ?>
		<div style="background-image: url('<?php echo get_template_directory_uri(); ?>/library/img/home/slides/slide01.jpg');" class="home-hero-slides-slide"></div>
		<div style="background-image: url('<?php echo get_template_directory_uri(); ?>/library/img/home/slides/slide02.jpg');" class="home-hero-slides-slide"></div>
		<div style="background-image: url('<?php echo get_template_directory_uri(); ?>/library/img/home/slides/slide03.jpg');" class="home-hero-slides-slide"></div>
		<div style="background-image: url('<?php echo get_template_directory_uri(); ?>/library/img/home/slides/slide04.jpg');" class="home-hero-slides-slide"></div>
	</div>
	<?php endif; ?>
	<div class="home-hero-tint hero-tint"></div>
</section>