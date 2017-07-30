<footer class="mobilefooter<?php echo get_field('general-theme-select', 'option') == 'light' ? ' light' : ''; echo get_field('general-theme-invert-headerfooter-logo-colors', 'option') ? ' invertlogo' : ''; ?>">
	<a href="<?php echo site_url(); ?>" class="fade fade-up mobilefooter-logo">
		<img src="<?php echo get_logo(); ?>" class="mobilefooter-logo-image">
	</a>
	<div class="fade fade-up mobilefooter-contactlinks">
		<?php if( !empty( get_the_phone() ) ): ?>
			<a href="tel:<?php echo get_the_phone('tel'); ?>" class="mobilefooter-contactlinks-phone"><?php echo 'p: ' . get_the_phone() ?></a>
		<?php endif; ?>
		<?php if( !empty( get_the_fax() ) ): ?>
			<a href="tel:<?php echo get_the_fax('tel'); ?>" class="mobilefooter-contactlinks-fax"><?php echo 'f: ' . get_the_fax() ?></a>
		<?php endif; ?>
		<div class="mobilefooter-contactlinks-address"><?php echo get_the_address(); ?></div>
	</div>
	<?php  

	$facebook_link = get_field('social-facebook-link', 'option');
	$twitter_link = get_field('social-twitter-link', 'option');
	$instagram_link = get_field('social-instagram-link', 'option');
	$youtube_link = get_field('social-youtube-link', 'option');
	$googleplus_link = get_field('social-googleplus-link', 'option');

	if( !empty($facebook_link) ||  !empty($twitter_link) || !empty($instagram_link) || !empty($youtube_link || !empty($googleplus_link))):
	?>
	<ul class="fade fade-up mobilefooter-sociallinks">
		<?php if( !empty($facebook_link) ): ?>
		<li class="mobilefooter-sociallinks-item">
			<a href="<?php echo $facebook_link ?>" target="_blank" class="mobilefooter-sociallinks-item-link">
				<i class="mobilefooter-sociallinks-item-link-icon fa fa-facebook"></i>
			</a>
		</li>
		<?php endif; ?>
		<?php if( !empty($twitter_link) ): ?>
		<li class="mobilefooter-sociallinks-item">
			<a href="<?php echo $twitter_link ?>" target="_blank" class="mobilefooter-sociallinks-item-link">
				<i class="mobilefooter-sociallinks-item-link-icon fa fa-twitter"></i>
			</a>
		</li>
		<?php endif; ?>
		<?php if( !empty($instagram_link) ): ?>
		<li class="mobilefooter-sociallinks-item">
			<a href="<?php echo $instagram_link ?>" target="_blank" class="mobilefooter-sociallinks-item-link">
				<i class="mobilefooter-sociallinks-item-link-icon fa fa-instagram"></i>
			</a>
		</li>
		<?php endif; ?>
		<?php if( !empty($youtube_link) ): ?>
		<li class="mobilefooter-sociallinks-item">
			<a href="<?php echo $youtube_link ?>" target="_blank" class="mobilefooter-sociallinks-item-link">
				<i class="mobilefooter-sociallinks-item-link-icon fa fa-youtube-play"></i>
			</a>
		</li>
		<?php endif; ?>
		<?php if( !empty($googleplus_link) ): ?>
		<li class="mobilefooter-sociallinks-item">
			<a href="<?php echo $googleplus_link ?>" target="_blank" class="mobilefooter-sociallinks-item-link">
				<i class="mobilefooter-sociallinks-item-link-icon fa fa-google-plus"></i>
			</a>
		</li>
		<?php endif; ?>
	</ul>
	<?php endif; ?>
	<?php render_page_links('mobilefooter-pagelinks', 'mobilefooter-pagelinks-item', 'mobilefooter-pagelinks-item-link'); ?>
	<div class="fade fade-up mobilefooter-copyright">Powered by <a target="_blank" class="mobilefooter-copyright-tclink" href="<?php the_field('webx-url', 'option') ?>"><?php the_field('webx-name', 'option'); ?></a> <br/><br/> <a class="mobilefooter-copyright-tclink" href="<?php echo site_url() ?>/terms">Terms &amp; Conditions</a> <br/><br/> Copyright &copy; <?php echo Date('Y') ?><br/><br/>Created by</div>
	<a href="http://webxmarketing.com" class="fade fade-up mobilefooter-webxlink">
		<img src="<?php echo get_field('webx-logo', 'option'); ?>" class="mobilefooter-webxlink-logo">
	</a>
</footer>