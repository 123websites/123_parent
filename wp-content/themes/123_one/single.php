<?php 

if( !get_field('blog-toggle', 'option') ){
	header( "Location: " . site_url() . "/404.php" );
}

get_header(); 

?>

<main class="single">
	<section class="single-hero" style="background-image: url('<?php echo get_blog_image($post->ID); ?>');">
		<h1 class="single-hero-header"><?php the_title(); ?></h1>
		<div class="single-hero-tint"></div>
	</section>
	<section class="single-single section">
		<div class="single-single-date"><?php echo 'Posted on: ' . date('n/j/Y', strtotime(get_the_date())) . ' at ' . date('g:i A', strtotime(get_the_date())); ?></div>
		<div class="single-single-content"><?php echo $post->post_content; ?></div>
		<div class="single-single-socialcontainer"><?php render_post_social_links($post->ID, 'single-single-socialcontainer-link', 'single-single-socialcontainer-link-icon'); ?></div>
	</section>
</main>

<?php get_footer(); ?>