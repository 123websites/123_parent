<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

		<!-- OpenGraph Stuff -->
		<?php if( is_single() ): ?>
		<meta property="og:image" content="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>"/>
		<meta property="og:title" content="<?php the_title(); ?>"/>
		<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>"/>
		<meta property="og:url" content="<?php echo $_SERVER['HTTP_REFERER']; ?>"/>
		<?php else: ?>
		<meta property="og:image" content="<?php echo get_field('general-logo', 'option'); ?>"/>
		<meta property="og:title" content="<?php echo get_bloginfo('name'); ?>"/>
		<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>"/>
		<meta property="og:url" content="<?php echo $_SERVER['HTTP_REFERER']; ?>"/>
		<?php endif; ?>
		<title><?php echo get_bloginfo('name');?></title>
		<?php wp_head(); ?>		
		<?php echo !empty(get_field('custom-css', 'option')) ? '<style type="text/css">' . get_field('custom-css', 'option') . '</style>' : ''; ?>
		<?php include( locate_template( 'partials/color-pickers.php' ) ); ?>
		<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		
		<?php get_template_part('partials/navigation/nav', 'desktop'); ?>
		<?php get_template_part('partials/navigation/nav', 'mobile'); ?>
		