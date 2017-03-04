<?php get_header(); ?>

<main class="testimonials">
	<section class="testimonials-hero hero" style="background-image: url('<?php echo get_field('testimonials-bg', 'option'); ?>');">
		<div class="testimonials-hero-text hero-text">
			<h1 class="testimonials-hero-text-header hero-text-header">Testimonials</h1>
		</div>
		<div class="testimonials-hero-tint hero-tint"></div>
	</section>
	<section class="testimonials-testimonials">
		<?php if(have_rows('testimonials-repeater', 'option')): ?>
			<div class="testimonials-testimonials-grid">
			<?php while(have_rows('testimonials-repeater', 'option')): the_row(); ?>
				<?php 
				$select = get_sub_field('testimonials-repeater-select', 'option');
				$grid_item_class = $select == 'youtube' ? 'testimonials-youtubegriditem' : ''; 
				?>
				<div class="testimonials-testimonials-grid-item <?php echo $grid_item_class; ?>">
					<?php if( get_sub_field('testimonials-repeater-select', 'option') == 'personal' ): ?>
					<div class="testimonials-testimonials-grid-item-quote">“<?php echo get_sub_field('testimonials-repeater-quote'); ?>”</div>
					<div class="testimonials-testimonials-grid-item-personinfo">
						<div class="testimonials-testimonials-grid-item-personinfo-name">- <?php echo get_sub_field('testimonials-repeater-name'); ?></div>
					</div>
					<img src="<?php echo get_template_directory_uri(); ?>/library/img/home/testimonials/quotemark.png" class="testimonials-testimonials-grid-item-quotemark">
					<img src="<?php echo get_sub_field('testimonials-repeater-image') ?>" class="testimonials-testimonials-grid-item-image">
					<?php endif; ?>
					<?php if( get_sub_field('testimonials-repeater-select', 'option') == 'youtube' ): ?>
						<div class="testimonials-testimonials-grid-item-youtubecontainer"><iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo get_sub_field('testimonials-repeater-youtube', 'option'); ?>" frameborder="0" allowfullscreen></iframe></div>
					<?php endif; ?>

				</div>
			<?php endwhile; ?>
		<?php endif; ?>
	</section>
	<?php

	get_template_part('partials/global', 'recent_posts');
	get_template_part('partials/global', 'contact');

	?>
</main>

<?php get_footer(); ?>