<?php get_header(); ?>

<main class="menu">
	<section class="menu-hero hero" style="background-image: url('<?php echo get_field('menu-bg', 'option'); ?>');">
		<div class="menu-hero-text hero-text">
			<h1 class="menu-hero-text-header hero-text-header">menu</h1>
		</div>
		<div class="menu-hero-tint hero-tint"></div>
	</section>
	<section class="menu-menu">
		<?php if(have_rows('menu-repeater', 'option')) : ?>
			<div class="menu-menu-grid">
				<?php while(have_rows('menu-repeater', 'option')): the_row();  ?>
					<div class="menu-menu-grid-category">
						<?php if( !empty( get_sub_field('menu-category-name', 'option') ) ): ?>
							<h2 class="menu-menu-grid-category-header"><?php echo get_sub_field('menu-category-name', 'option'); ?></h2>
						<?php endif; ?>
						<?php if( !empty( get_sub_field('menu-category-description', 'option') ) ): ?>
							<div class="menu-menu-grid-category-description"><?php echo get_sub_field('menu-category-description', 'option'); ?></div>
						<?php endif;
						if( get_sub_field('menu-category-type', 'option') == 'masonry' ):
							if( have_rows('menu-category-repeater', 'option') ): ?>
							<div class="menu-menu-grid-category-grid">
								<?php while( have_rows('menu-category-repeater', 'option') ): the_row(); ?>
									<?php $has_image = get_sub_field('menu-item-picture-toggle', 'option') ?>
									<div class="menu-menu-grid-category-grid-item<?php echo get_sub_field('menu-item-picture-toggle', 'option') ? ' hasimage' : '';?>">
										<?php if($has_image): ?>
											<div class="menu-menu-grid-category-grid-item-imagecontainer">
												<img src="<?php echo get_sub_field('menu-item-picture', 'option'); ?>" class="menu-menu-grid-category-grid-item-imagecontainer-image">
											</div>
										<?php endif; ?>
										<?php if( !empty(get_sub_field('menu-item-name', 'option')) || 
											!empty(get_sub_field('menu-item-description', 'option')) ||
											!empty(get_sub_field('menu-item-price', 'option'))
										 ): ?>
											<div class="menu-menu-grid-category-grid-item-textcontainer">
												<?php if( !empty(get_sub_field('menu-item-name', 'option')) ): ?>	
													<h3 class="menu-menu-grid-category-grid-item-textcontainer-header"><?php echo get_sub_field('menu-item-name', 'option'); ?></h3>
												<?php endif; ?>
												<?php if( !empty(get_sub_field('menu-item-description', 'option')) ): ?>	
													<div class="menu-menu-grid-category-grid-item-textcontainer-description"><?php echo get_sub_field('menu-item-description', 'option'); ?></div>
												<?php endif; ?>
												<?php if( !empty(get_sub_field('menu-item-price', 'option')) ): ?>	
													<div class="menu-menu-grid-category-grid-item-textcontainer-price"><?php echo get_sub_field('menu-item-price', 'option'); ?></div>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endwhile; ?>
							</div>
							<?php endif; ?>
						<?php else: 
							if( have_rows('menu-category-list-repeater', 'option') ): ?>
								<div class="menu-menu-grid-category-listgrid">
									<?php while( have_rows('menu-category-list-repeater', 'option') ): the_row();  ?>
										<?php if( !empty(get_sub_field('menu-list-item-name', 'option')) || 
											!empty(get_sub_field('menu-list-item-description', 'option')) ||
											!empty(get_sub_field('menu-list-item-price', 'option'))
										 ): ?>
											<div class="menu-menu-grid-category-listgrid-item">
												<?php if( !empty(get_sub_field('menu-list-item-name', 'option')) ): ?>	
													<h3 class="menu-menu-grid-category-listgrid-item-header"><?php echo get_sub_field('menu-list-item-name', 'option'); ?></h3>
												<?php endif; ?>
												<?php if( !empty(get_sub_field('menu-list-item-price', 'option')) ): ?>	
													<div class="menu-menu-grid-category-listgrid-item-price"><?php echo get_sub_field('menu-list-item-price', 'option'); ?></div>
												<?php endif; ?>
												<?php if( !empty(get_sub_field('menu-list-item-description', 'option')) ): ?>	
													<div class="menu-menu-grid-category-listgrid-item-description"><?php echo get_sub_field('menu-list-item-description', 'option'); ?></div>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									<?php endwhile; ?>
								</div>
							<?php endif; ?>

						<?php endif; ?>
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