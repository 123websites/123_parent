<header class="mobileheader<?php echo get_field('general-theme-select', 'option') == 'light' ? ' light' : ''; echo get_field('general-theme-invert-headerfooter-logo-colors', 'option') ? ' invertlogo' : ''; ?>">
	<div class="mobileheader-bar">
		<a class="mobileheader-bar-menutoggle">
			<i class="mobileheader-bar-menutoggle-icon fa fa-bars"></i>
		</a>
		<a href="<?php echo site_url(); ?>" class="mobileheader-bar-logo">
			<img src="<?php echo get_logo(); ?>" class="mobileheader-bar-logo-image">
		</a>
		<div class="mobileheader-bar-tint"></div>
	</div>
	<div class="mobileheader-menus">
		<nav class="mobileheader-menus-pages">
			<?php render_page_links('mobileheader-menus-pages-menu', 'mobileheader-menus-pages-menu-item', 'mobileheader-menus-pages-menu-item-link'); ?>
		</nav>
		<nav class="mobileheader-menus-contact">
			<a href="tel:<?php echo get_the_phone('tel'); ?>" class="mobileheader-menus-contact-phone"><?php echo get_the_phone(); ?></a>
		</nav>
		<?php 

		$facebook_link = get_field('social-facebook-link', 'option');
		$twitter_link = get_field('social-twitter-link', 'option');
		$instagram_link = get_field('social-instagram-link', 'option');
		$youtube_link = get_field('social-youtube-link', 'option');

		?>
		<nav class="mobileheader-menus-social">
			<ul class="mobileheader-menus-social-menu">
				<?php if( !empty($facebook_link) ): ?>
				<li class="mobileheader-menus-social-menu-item">
					<a href="<?php echo $facebook_link; ?>" target="_blank" class="mobileheader-menus-social-menu-item-link">
						<i class="mobileheader-menus-social-menu-item-link-icon fa fa-facebook"></i>
					</a>
				</li>
				<?php endif; ?>
				<?php if( !empty($twitter_link) ): ?>
				<li class="mobileheader-menus-social-menu-item">
					<a href="<?php echo $twitter_link; ?>" target="_blank" class="mobileheader-menus-social-menu-item-link">
						<i class="mobileheader-menus-social-menu-item-link-icon fa fa-twitter"></i>
					</a>
				</li>
				<?php endif; ?>
				<?php if( !empty($instagram_link) ): ?>
				<li class="mobileheader-menus-social-menu-item">
					<a href="<?php echo $instagram_link; ?>" target="_blank" class="mobileheader-menus-social-menu-item-link">
						<i class="mobileheader-menus-social-menu-item-link-icon fa fa-instagram"></i>
					</a>
				</li>
				<?php endif; ?>
				<?php if( !empty($youtube_link) ): ?>
				<li class="mobileheader-menus-social-menu-item">
					<a href="<?php echo $youtube_link; ?>" target="_blank" class="mobileheader-menus-social-menu-item-link">
						<i class="mobileheader-menus-social-menu-item-link-icon fa fa-youtube-play"></i>
					</a>
				</li>
				<?php endif; ?>
			</ul>
		</nav>
	</div>
	<div class="mobileheader-tint"></div>
</header>