<footer class="mobilefooter<?php echo get_field('general-theme-select', 'option') == 'light' ? ' light' : ''; echo get_field('general-theme-invert-headerfooter-logo-colors', 'option') ? ' invertlogo' : ''; ?>">
	<a href="<?php echo site_url(); ?>" class="mobilefooter-logo">
		<img src="<?php echo get_logo(); ?>" class="mobilefooter-logo-image">
	</a>
	<div class="mobilefooter-contactlinks">
		<a href="tel:<?php echo get_the_phone('tel'); ?>" class="mobilefooter-contactlinks-phone"><?php echo 'p: ' . get_the_phone() ?></a>
		<a href="tel:<?php echo get_the_fax('tel'); ?>" class="mobilefooter-contactlinks-fax"><?php echo 'f: ' . get_the_fax() ?></a>
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
	<ul class="mobilefooter-sociallinks">
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
	<div class="mobilefooter-copyright"><?php echo !empty(get_field('general-tclink', 'option')) ? '<a class="mobilefooter-copyright-tclink" href="' .get_field('general-tclink', 'option') . '">Terms &amp; Conditions</a> | ' : '' ?>Copyright &copy; <?php echo Date('Y') ?><br/><br/>Created by</div>
	<a href="http://webxmarketing.com" class="mobilefooter-webxlink">
		<img src="<?php echo get_template_directory_uri() ?>/library/img/webx-logo.png" class="mobilefooter-webxlink-logo">
	</a>
</footer>