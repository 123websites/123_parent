<main class="services main" id="services">
	<section class="services-hero hero">
		<div class="services-hero-text hero-text">
			<h1 class="fade fade-in services-hero-text-header hero-text-header"><?php echo get_field('services-alt-toggle', 'option') ? get_field('services-alt', 'option') : 'services' ?></h1>
		</div>
	</section>
	<section class="services-services">
		<?php if(have_rows('services-repeater', 'option')) : 
			$counter = 0;
		?>
		<div class="services-services-grid">
			<?php while(have_rows('services-repeater', 'option')): 
				$counter++;
				the_row();  ?>
			<div class="fade fade-in services-services-grid-item<?php echo $counter % 2 == 0 ? ' services-services-grid-item--invert' : ''; ?>">
				<div class="services-services-grid-item-imagecontainer">
					<img src="<?php echo !empty(get_sub_field('service-image', 'option')) ? get_sub_field('service-image', 'option') : get_field('featured-placeholder', 'option'); ?>" class="services-services-grid-item-imagecontainer-image">
				</div>
				<div class="services-services-grid-item-wrapper">
					<h3 class="services-services-grid-item-header"><?php echo get_sub_field('service-name', 'option'); ?></h3>
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
</main>