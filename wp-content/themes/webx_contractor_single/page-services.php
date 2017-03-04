<?php get_header(); ?>

<main class="services">
	<section class="services-hero hero" style="background-image: url('<?php echo get_field('services-bg', 'option'); ?>');">
		<div class="services-hero-text hero-text">
			<h1 class="services-hero-text-header hero-text-header">services</h1>
		</div>
		<div class="services-hero-tint hero-tint"></div>
	</section>
	<section class="services-services">
		<?php if(have_rows('services-repeater', 'option')) : ?>
		<div class="services-services-grid">
			<?php while(have_rows('services-repeater', 'option')): the_row();  ?>
			<div class="services-services-grid-item">
				<h3 class="services-services-grid-item-header"><?php echo get_sub_field('service-name', 'option'); ?></h3>
				<div class="services-services-grid-item-wrapper">
					<div class="services-services-grid-item-imagecontainer">
						<img src="<?php echo get_sub_field('service-image', 'option'); ?>" class="services-services-grid-item-imagecontainer-image">
					</div>
					<div class="services-services-grid-item-descriptioncontainer">
						<div class="services-services-grid-item-descriptioncontainer-description"><?php echo get_sub_field('service-description', 'option'); ?></div>
					</div>
					<div class="services-services-grid-item-pricecontainer">
						<div class="services-services-grid-item-pricecontainer-price"><?php echo get_sub_field('service-price', 'option'); ?></div>
					</div>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
		<?php endif; ?>
	</section>
	<?php

	get_template_part('partials/global', 'recent_posts');
	get_template_part('partials/global', 'contact');

	?>
</main>

<?php get_footer(); ?>