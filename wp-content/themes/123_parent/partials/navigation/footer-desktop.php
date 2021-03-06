<footer class="footer<?php echo get_field('general-theme-invert-headerfooter-logo-colors', 'option') ? ' invertlogo' : ''; ?>">
	<div class="fade fade-in footer-wrap">
		<div class="footer-leftcolumn">
			<a href="<?php echo site_url(); ?>" class="footer-logo">
				<img src="<?php echo get_logo(); ?>" class="footer-logo-image">
			</a>
			<div class="footer-contactlinks">
				<?php if( !empty(get_the_phone()) ): ?>
					<a href="tel:<?php echo get_the_phone('tel'); ?>" class="footer-contactlinks-phone"><?php echo 'P: ' . get_the_phone() ?></a>
				<?php endif; ?>
				<?php if( !empty(get_the_fax()) ): ?>
					<a href="tel:<?php echo get_the_fax('tel'); ?>" class="footer-contactlinks-fax"><?php echo 'F: ' . get_the_fax() ?></a>
				<?php endif; ?>
				<?php if( !empty(get_the_address()) ): ?>
					<div class="footer-contactlinks-address"><?php echo get_the_address(); ?></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="footer-middlecolumn1">
			<div class="footer-middlecolumn1-sitemap">sitemap</div>
			<?php do_action('123_before_desktop_footer_social_links'); ?>
			<?php render_page_links('footer-pagelinks', 'footer-pagelinks-item', 'footer-pagelinks-item-link'); ?>
		</div>
		<?php if( !empty(get_field('mastercard', 'option')) || !empty(get_field('visa', 'option')) || !empty(get_field('amex', 'option')) || !empty(get_field('discover', 'option')) || !empty(get_field('paypal', 'option')) ): ?>
			<div class="footer-middlecolumn2">
				<div class="footer-middlecolumn2-payment">payment</div>
				<?php 
					$payment_types = array('mastercard', 'visa', 'amex', 'discover', 'paypal', 'cash', 'check');

					foreach($payment_types as $payment_type){
						if( get_field($payment_type, 'option') == true ){
							?>
								<div class="footer-middlecolumn2-payment-type <?php echo $payment_type ?><?php echo !empty(get_field($payment_type . '-image', 'option')) ? ' hasimage' : ''; ?>">
									<?php if( !empty(get_field($payment_type . '-image', 'option')) ): ?>
										<img class="footer-middlecolumn2-payment-type-image" src="<?php the_field($payment_type . '-image', 'option'); ?>">
									<?php endif; ?>
								</div>
							<?php
						}
					}
				?>
			</div>
		<?php endif; ?>
		<div class="footer-rightcolumn">
			<?php  

			$facebook_link = get_field('social-facebook-link', 'option');
			$twitter_link = get_field('social-twitter-link', 'option');
			$instagram_link = get_field('social-instagram-link', 'option');
			$youtube_link = get_field('social-youtube-link', 'option');
			$googleplus_link = get_field('social-googleplus-link', 'option');
			$yelp_link = get_field('social-yelp-link', 'option');

			if( !empty($facebook_link) ||  !empty($twitter_link) || !empty($instagram_link) || !empty($youtube_link) || !empty($googleplus_link)|| !empty($yelp_link)):
			?>
			<ul class="footer-sociallinks">
				<?php if( !empty($facebook_link) ): ?>
				<li class="footer-sociallinks-item">
					<a href="<?php echo $facebook_link ?>" target="_blank" class="footer-sociallinks-item-link">
						<i class="footer-sociallinks-item-link-icon fa fa-facebook"></i>
					</a>
				</li>
				<?php endif; ?>
				<?php if( !empty($twitter_link) ): ?>
				<li class="footer-sociallinks-item">
					<a href="<?php echo $twitter_link ?>" target="_blank" class="footer-sociallinks-item-link">
						<i class="footer-sociallinks-item-link-icon fa fa-twitter"></i>
					</a>
				</li>
				<?php endif; ?>
				<?php if( !empty($instagram_link) ): ?>
				<li class="footer-sociallinks-item">
					<a href="<?php echo $instagram_link ?>" target="_blank" class="footer-sociallinks-item-link">
						<i class="footer-sociallinks-item-link-icon fa fa-instagram"></i>
					</a>
				</li>
				<?php endif; ?>
				<?php if( !empty($youtube_link) ): ?>
				<li class="footer-sociallinks-item">
					<a href="<?php echo $youtube_link ?>" target="_blank" class="footer-sociallinks-item-link">
						<i class="footer-sociallinks-item-link-icon fa fa-youtube-play"></i>
					</a>
				</li>
				<?php endif; ?>
				<?php if( !empty($googleplus_link) ): ?>
				<li class="footer-sociallinks-item">
					<a href="<?php echo $googleplus_link ?>" target="_blank" class="footer-sociallinks-item-link">
						<i class="footer-sociallinks-item-link-icon fa fa-google-plus"></i>
					</a>
				</li>
				<?php endif; ?>
				<?php if( !empty($yelp_link) ): ?>
				<li class="footer-sociallinks-item">
					<a href="<?php echo $yelp_link ?>" target="_blank" class="footer-sociallinks-item-link">
						<i class="footer-sociallinks-item-link-icon fa fa-yelp"></i>
					</a>
				</li>
				<?php endif; ?>
			</ul>
			<?php endif; ?>
			
			
			<a href="<?php echo !empty( get_field( 'webx-url', 'option' ) ) ? get_field( 'webx-url', 'option' ) : 'http://webxmarketing.com'; ?>" class="footer-webxlink">
				<div>Powered by: </div>
				<img src="<?php echo get_field('webx-logo', 'option'); ?>" class="footer-webxlink-logo">
			</a>
		</div>	
	</div>
</footer>
<div class="footer-copyright">
	Powered by <a target="_blank" class="footer-copyright-tclink" href="<?php the_field('webx-url', 'option') ?>"><?php the_field('webx-name', 'option'); ?></a> 
	<?php if( !get_field('terms-disable', 'option') ): ?>
		| <a class="footer-copyright-tclink" href="<?php echo site_url() ?>/terms">Terms &amp; Conditions</a> 
	<?php endif; ?>
	| Copyright &copy; <?php echo Date('Y') ?></div>


