<?php get_header(); ?>

<main class="company">
	<section class="company-hero hero" style="background-image: url('<?php echo get_field('company-bg', 'option'); ?>');">
		<div class="company-hero-text hero-text">
			<h1 class="company-hero-text-header hero-text-header"><?php echo get_field('company-header', 'option'); ?></h1>
			<?php 
			$selected_option = get_field('company-page-option-toggle', 'option');
			if($selected_option == 'option1'):
				?>
				<div class="company-hero-text-subheader hero-text-subheader"><?php echo get_field('company-subheader', 'option') ?></div>					
				<?php
			endif;
			?>
		</div>
		<div class="company-hero-tint hero-tint"></div>
	</section>
	<?php if($selected_option == 'option1'): ?>
	<section class="company-wysiwyg">
		<?php echo get_field('company-content', 'option'); ?>
	</section>
	<?php endif; ?>
	<?php if($selected_option == 'option2'): ?>
	<?php if(have_rows('company-employee-repeater', 'option')): ?>
	<section class="company-employees section">
		<div class="company-employees-grid">
			<?php while(have_rows('company-employee-repeater', 'option')): the_row();?>
				<div class="company-employees-grid-item">
					<div class="company-employees-grid-item-imagecontainer">
						<img src="<?php echo get_sub_field('company-employee-image', 'option'); ?>" class="company-employees-grid-item-imagecontainer-image">
					</div>
					<?php 

					$facebook_url = null;
					$twitter_url = null;
					$linkedin_url = null;
					$googleplus_url = null;

					if( get_sub_field('company-employee-facebook-toggle') == true && ( get_sub_field('company-employee-facebook-url') !== null || get_sub_field('company-employee-facebook-url') !== '' ) ){
						$facebook_url = get_sub_field('company-employee-facebook-url');
					}
					if( get_sub_field('company-employee-twitter-toggle') == true && ( get_sub_field('company-employee-twitter-url') !== null || get_sub_field('company-employee-twitter-url') !== '' ) ){
						$twitter_url = get_sub_field('company-employee-twitter-url');
					}
					if( get_sub_field('company-employee-linkedin-toggle') == true && ( get_sub_field('company-employee-linkedin-url') !== null || get_sub_field('company-employee-linkedin-url') !== '' ) ){
						$linkedin_url = get_sub_field('company-employee-linkedin-url');
					}
					if( get_sub_field('company-employee-googleplus-toggle') == true && ( get_sub_field('company-employee-googleplus-url') !== null || get_sub_field('company-employee-googleplus-url') !== '' ) ){
						$googleplus_url = get_sub_field('company-employee-googleplus-url');
					}
					?>
					<div class="company-employees-grid-item-rightwrap">
						
						<div class="company-employees-grid-item-textcontainer">
							<h3 class="company-employees-grid-item-textcontainer-name"><?php echo get_sub_field('company-employee-name'); ?></h3>
							<div class="company-employees-grid-item-textcontainer-title"><?php echo get_sub_field('company-employee-title'); ?></div>
							<div class="company-employees-grid-item-textcontainer-description"><?php echo get_sub_field('company-employee-description'); ?></div>	
						</div>
						<?php
						if( $facebook_url !== null || $twitter_url !== null || $linkedin_url !== null || $googleplus_url !== null ):

						?>
						
						<div class="company-employees-grid-item-socialcontainer">
							<?php if($facebook_url !== null): ?>
							<a target="_blank" href="<?php echo $facebook_url ?>" class="company-employees-grid-item-socialcontainer-link">
								<i class="company-employees-grid-item-socialcontainer-link-icon fa fa-facebook"></i>
							</a>
							<?php endif; ?>
							<?php if($twitter_url !== null): ?>
							<a target="_blank" href="<?php echo $twitter_url ?>" class="company-employees-grid-item-socialcontainer-link">
								<i class="company-employees-grid-item-socialcontainer-link-icon fa fa-twitter"></i>
							</a>
							<?php endif; ?>
							<?php if($linkedin_url !== null): ?>
							<a target="_blank" href="<?php echo $linkedin_url ?>" class="company-employees-grid-item-socialcontainer-link">
								<i class="company-employees-grid-item-socialcontainer-link-icon fa fa-linkedin"></i>
							</a>
							<?php endif; ?>
							<?php if($googleplus_url !== null): ?>
							<a target="_blank" href="<?php echo $googleplus_url ?>" class="company-employees-grid-item-socialcontainer-link">
								<i class="company-employees-grid-item-socialcontainer-link-icon fa fa-google-plus"></i>
							</a>
							<?php endif; ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	</section>
	<?php endif; ?>
	<?php endif; ?>
	<?php

	get_template_part('partials/global', 'recent_posts');
	get_template_part('partials/global', 'contact');

	?>
</main>

<?php get_footer(); ?>