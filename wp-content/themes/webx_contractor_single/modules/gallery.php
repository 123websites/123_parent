<?php $has_bg = !empty(get_field('gallery-bg', 'option')); ?>
<main class="gallery main<?php echo $has_bg ? ' main--hasbg' : ''; ?>" id="gallery" <?php if($has_bg): ?> style="background-image: url('<?php echo get_field('gallery-bg', 'option'); ?>');" <?php endif; ?>>
	<section class="gallery-hero hero">
		<div class="gallery-hero-text hero-text">
			<h1 class="gallery-hero-text-header hero-text-header<?php echo !$has_bg ? ' hero-text-header--nobg' : ''; ?>"><?php echo get_field('gallery-alt-toggle', 'option') ? get_field('gallery-alt', 'option') : 'gallery' ?></h1>
		</div>
	</section>
	<section class="gallery-galleries">
		<?php if(have_rows('gallery-repeater', 'option')) : while(have_rows('gallery-repeater', 'option')) :  the_row();?>
			<div class="gallery-galleries-gallery">
				<h2 class="gallery-galleries-gallery-header"><?php echo get_sub_field('gallery-name','option') ?></h2>
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
					<a href="<?php echo $image['url']; ?>" class=" gallery-galleries-gallery-imagecontainer<?php echo !empty($classes) ? ' ' . $classes : '';  ?>" data-caption="<?php echo get_sub_field('gallery-name', 'option'); ?>">
						<div style="background-image: url('<?php echo $image['url']; ?>');" class="gallery-galleries-gallery-imagecontainer-image"></div>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</section>
	<div class="main-tint<?php echo !$has_bg ? ' main-tint--nobg' : ''; ?>"></div>
</main>