<header class="header<?php echo get_field('general-theme-invert-headerfooter-logo-colors', 'option') ? ' invertlogo' : ''; echo get_field('nav-fadein-toggle', 'option') ? ' removefadein' : '';?>">
	<?php if(!get_field('remove-topbar', 'option')): ?>
	<div class="header-topbar">
		<a href="#" class="header-topbar-link"><?php echo get_field('header-bar-text', 'option'); ?></a>
	</div>
	<?php endif; ?>
	<div class="header-content">
		<a href="<?php echo site_url(); ?>" class="header-content-logo">
			<img alt="<?php echo bloginfo('sitename') ?>" src="<?php echo get_logo(); ?>" class="header-content-logo-image">
		</a>
		<div class="header-content-rightwrap">
			<div class="header-content-menus">
				<nav class="header-content-menus-social">
					<ul class="header-content-menus-social-menu">
						<li class="header-content-menus-social-menu-item">
							<a href="tel:<?php echo get_the_phone('tel'); ?>" class="header-content-menus-social-menu-item-link"><?php echo get_the_phone(); ?></a>
						</li>
					</ul>
				</nav>
				<nav class="header-content-menus-pages">
					<?php render_page_links('header-content-menus-pages-menu', 'header-content-menus-pages-menu-item', 'header-content-menus-pages-menu-item-link'); ?>
				</nav>
			</div>
			<?php if( !get_field('quickquote-disable', 'option') ): ?>
				<a href="#" class="header-content-quickquote estimate-toggle"><?php echo get_field('quickquote-button-text', 'option'); ?></a>
			<?php endif; ?>
		</div>
	</div>
	<div class="header-tint<?php echo get_field('remove-topbar', 'option') ? ' topbar-removed' : ''; ?>"></div>
</header>