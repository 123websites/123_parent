<?php get_header(); ?>

<main class="contact">
	<section class="contact-hero hero">
		<div class="contact-hero-text hero-text">
			<h1 class="contact-hero-text-header hero-text-header">contact</h1>
		</div>
		<div class="contact-hero-tint hero-tint"></div>
		<div class="contact-hero-map"></div>
	</section>
	<section class="contact-contact section">
		<div class="contact-contact-left">
			<div class="contact-contact-left-locations">
				<?php 
					$rows = get_field('addresses-repeater', 'option');
					if(count($rows) > 1):
				?>
				<h3 class="contact-contact-left-locations-header">Locations</h3>
				<?php endif; 

				if(have_rows('addresses-repeater', 'option')):
					while(have_rows('addresses-repeater', 'option')): the_row();
						?>
							<div class="contact-contact-left-locations-location">
								<h4 class="contact-contact-left-locations-location-name"><?php echo get_sub_field('addresses-name', 'option'); ?></h4>
								<?php 

								$address_with_extra = null;

								if( !empty(get_sub_field('addresses-extra', 'option')) ){
									$address_line2 = get_sub_field('addresses-extra', 'option');
									$address_with_extra = strstr(get_sub_field('addresses-gmap')['address'],',', true) . ' ' . $address_line2 . strstr(get_sub_field('addresses-gmap')['address'],',');
								}

								?>
								<div class="contact-contact-left-locations-location-address"><?php echo $address_with_extra != null ? $address_with_extra : get_sub_field('addresses-gmap', 'option')['address']; ?> <a href="http://maps.google.com/?q=<?php echo get_sub_field('addresses-gmap', 'option')['address']; ?>">Get Directions</a></div>

								<div class="contact-contact-left-locations-location-phones">
									<div class="contact-contact-left-locations-location-phones-office"><strong>Office: </strong><a href="mailto:<?php echo get_tel(get_sub_field('contact-office', 'option')) ?>"><?php echo get_sub_field('contact-office', 'option'); ?></a></div>
									<?php if( !empty(get_sub_field('contact-cell', 'option')) ): ?>
									<div class="contact-contact-left-locations-location-phones-cell"><strong>Cell: </strong><a href="mailto:<?php echo get_tel(get_sub_field('contact-cell', 'option')) ?>"><?php echo get_sub_field('contact-cell', 'option'); ?></a></div>
									<?php endif; ?>
									<?php if( !empty(get_sub_field('contact-fax', 'option')) ): ?>
									<div class="contact-contact-left-locations-location-phones-fax"><strong>Fax: </strong><a href="mailto:<?php echo get_tel(get_sub_field('contact-fax', 'option')) ?>"><?php echo get_sub_field('contact-fax', 'option'); ?></a></div>
									<?php endif; ?>
								</div>

								<?php if(!have_rows('addresses-hours-repeater', 'option')): ?>
									<div class="contact-contact-left-locations-location-hours--allday">Open 24/7</div>
								<?php endif; ?>
								<?php 
								if(have_rows('addresses-hours-repeater', 'option')): ?>
									<div class="contact-contact-left-locations-location-hours">
									<?php while(have_rows('addresses-hours-repeater', 'option')): the_row();?>
										<div class="contact-contact-left-locations-location-hours-row">
											<span class="contact-contact-left-locations-location-hours-row-daystart"><?php echo get_sub_field('addresses-hours-day-start', 'option'); ?></span>
											<?php if( !empty(get_sub_field('addresses-hours-day-end', 'option')) ): ?>
												<span class="contact-contact-left-locations-location-hours-row-dayend">- <?php echo get_sub_field('addresses-hours-day-end', 'option'); ?></span>
											<?php endif; ?>
											<?php if( empty(get_sub_field('addresses-hours-time-start', 'option')) && empty(get_sub_field('addresses-hours-time-end', 'option')) && get_sub_field('addresses-hours-closed', 'option') == false): ?>
												<span class="contact-contact-left-locations-location-hours-row-openallday">: all day</span>
											<?php endif; ?>
											<?php if( get_sub_field('addresses-hours-closed') ): ?>
												<span class="contact-contact-left-locations-location-hours-row-closed">: closed</span>
											<?php else: ?>
												<?php if( !empty(get_sub_field('addresses-hours-time-start')) ): ?>
												<span class="contact-contact-left-locations-location-hours-row-timestart">: <?php echo get_sub_field('addresses-hours-time-start', 'option'); ?> -</span>
												<?php endif; ?>
												<?php if( !empty(get_sub_field('addresses-hours-time-end')) ): ?>
												<span class="contact-contact-left-locations-location-hours-row-timeend"> <?php echo get_sub_field('addresses-hours-time-end', 'option'); ?></span>
												<?php endif; ?>
											<?php endif; ?>
										</div>
									<?php endwhile; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php
					endwhile;
				endif;

				?>

			</div>
		</div>
		<div class="contact-contact-right">
			<?php echo do_shortcode('[gravityform id=1 title=false description=false ajax=true]'); ?>
		</div>
	</section>
	<?php

	get_template_part('partials/global', 'recent_posts');

	?>
</main>

<?php get_footer(); ?>