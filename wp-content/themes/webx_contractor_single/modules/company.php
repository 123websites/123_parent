<?php $has_bg = !empty(get_field('company-bg', 'option')); ?>
<main class="company main<?php echo $has_bg ? ' main--hasbg' : ''; ?>" id="company" <?php if($has_bg): ?> style="background-image: url('<?php echo get_field('company-bg', 'option'); ?>');" <?php endif; ?>>
	<section class="company-hero hero">
		<div class="company-hero-text hero-text">
			<h1 class="fade fade-in company-hero-text-header hero-text-header<?php echo !$has_bg ? ' hero-text-header--nobg' : ''; ?>"><?php echo get_field('company-header', 'option'); ?></h1>
			<?php 
				$selected_option = get_field('company-page-option-toggle', 'option');
			?>
		</div>
	</section>
	<?php if($selected_option == 'option1'): 

		if( !empty(get_field('company-subheader', 'option')) ):
			?>
			<div class="company-hero-text-subheader hero-text-subheader"><?php echo get_field('company-subheader', 'option') ?></div>					
			<?php
		endif;
	?>

	
		<?php
			echo '<div class="fade fade-up">' . get_field('company-content', 'option') . '</div>'; 
		?>
	
	<?php endif; ?>
	<?php if($selected_option == 'option2'): ?>
	<?php if(have_rows('company-employee-repeater', 'option')): ?>
	<section class="company-employees section">
		<div class="company-employees-grid">
			<?php while(have_rows('company-employee-repeater', 'option')): the_row();?>
				<div class="company-employees-grid-item fade fade-up">
					<div class="company-employees-grid-item-imagecontainer">
						<img src="<?php echo !empty(get_sub_field('company-employee-image', 'option')) ? get_sub_field('company-employee-image', 'option') : get_template_directory_uri() . '/library/img/blank-profile.png'; ?>" class="company-employees-grid-item-imagecontainer-image">
					</div>
					<div class="company-employees-grid-item-imagecontainer--desktop fade fade-up" style="background-image: url('<?php echo !empty(get_sub_field('company-employee-image', 'option')) ? get_sub_field('company-employee-image', 'option') : get_template_directory_uri() . '/library/img/blank-profile.png'; ?>');">
						<div class="company-employees-grid-item-imagecontainer-tint--desktop"></div>
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
	<div class="main-tint<?php echo !$has_bg ? ' main-tint--nobg' : ''; ?>"></div>
</main>