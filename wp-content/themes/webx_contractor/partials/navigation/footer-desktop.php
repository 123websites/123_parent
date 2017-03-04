<footer class="footer<?php echo get_field('general-theme-select', 'option') == 'light' ? ' light' : ''; echo get_field('general-theme-invert-headerfooter-logo-colors', 'option') ? ' invertlogo' : ''; ?>">
	<div class="footer-wrap">
		<div class="footer-leftcolumn">
			<a href="<?php echo site_url(); ?>" class="footer-logo">
				<img src="<?php echo get_logo(); ?>" class="footer-logo-image">
			</a>
			<div class="footer-contactlinks">
				<a href="tel:<?php echo get_the_phone('tel'); ?>" class="footer-contactlinks-phone"><?php echo 'p: ' . get_the_phone() ?></a>
				<a href="tel:<?php echo get_the_fax('tel'); ?>" class="footer-contactlinks-fax"><?php echo 'f: ' . get_the_fax() ?></a>
				<div class="footer-contactlinks-address"><?php echo get_the_address(); ?></div>
			</div>
		</div>
		<div class="footer-middlecolumn1">
			<div class="footer-middlecolumn1-sitemap">sitemap</div>
			<?php render_page_links('footer-pagelinks', 'footer-pagelinks-item', 'footer-pagelinks-item-link'); ?>
		</div>
		<div class="footer-middlecolumn2">
			<div class="footer-middlecolumn2-payment">payment</div>
			<div class="footer-middlecolumn2-payment-type"></div>
			<div class="footer-middlecolumn2-payment-type"></div>
			<div class="footer-middlecolumn2-payment-type"></div>
			<div class="footer-middlecolumn2-payment-type"></div>
			<div class="footer-middlecolumn2-payment-type"></div>
		</div>
		<div class="footer-rightcolumn">
			<?php  

			$facebook_link = get_field('social-facebook-link', 'option');
			$twitter_link = get_field('social-twitter-link', 'option');
			$instagram_link = get_field('social-instagram-link', 'option');
			$youtube_link = get_field('social-youtube-link', 'option');
			$googleplus_link = get_field('social-googleplus-link', 'option');

			if( !empty($facebook_link) ||  !empty($twitter_link) || !empty($instagram_link) || !empty($youtube_link) || !empty($googleplus_link)):
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
			</ul>
			<?php endif; ?>
			
			
			<a href="<?php !empty( get_field( 'webx-url' ) ) ? get_field( 'webx-url' ) : 'http://webxmarketing.com'; ?>" class="footer-webxlink">
				<div>Created by: </div>
				<img src="<?php echo get_field('webx-logo', 'option'); ?>" class="footer-webxlink-logo">
			</a>
		</div>	
	</div>
</footer>
<div class="footer-copyright"><a target="_blank" class="footer-copyright-tclink" href="<?php echo site_url() ?>/terms">Terms &amp; Conditions</a> Copyright &copy; <?php echo Date('Y') ?></div>