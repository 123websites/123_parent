<main class="gallery main" id="gallery">
	<section class="gallery-hero hero">
		<div class="gallery-hero-text hero-text">
			<h1 class="fade fade-in gallery-hero-text-header hero-text-header"><?php echo get_field('gallery-alt-toggle', 'option') ? get_field('gallery-alt', 'option') : 'gallery' ?></h1>
		</div>
	</section>
	<section class="gallery-galleries">
		<?php if(have_rows('gallery-repeater', 'option')) : while(have_rows('gallery-repeater', 'option')) :  the_row();?>
			<div class="gallery-galleries-gallery">
				<h2 class="fade fade-in gallery-galleries-gallery-header"><?php echo get_sub_field('gallery-name','option') ?></h2>
				<?php 
				$images = get_sub_field('gallery-gallery', 'option'); 
				$medium_remainder = count($images) % 2;
				$large_remainder = count($images) % 4;
				foreach($images as $index => $image): 
					$classes = '';
					if(!empty($medium_remainder) && $index >= count($images) - $medium_remainder){
						$classes .= 'medium-' . (string) $medium_remainder . ' ';
					}
					if(!empty($large_remainder) && $index >= count($images) - $large_remainder){
						$classes .= 'large-' . (string) $large_remainder . ' ';
					}
					?>
					<a href="<?php echo $image['url']; ?>" class="fade fade-up gallery-galleries-gallery-imagecontainer<?php echo !empty($classes) ? ' ' . $classes : '';  ?>" data-caption="<?php echo get_sub_field('gallery-name', 'option'); ?>">
						<div style="background-image: url('<?php echo $image['url']; ?>');" class="gallery-galleries-gallery-imagecontainer-image"></div>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</section>
</main>