<?php $has_bg = !empty(get_field('general-blog-bg', 'option')); ?>
<main class="blog main<?php echo $has_bg ? ' main--hasbg' : ''; ?>" id="blog" <?php if($has_bg): ?> style="background-image: url('<?php echo get_field('general-blog-bg', 'option'); ?>');" <?php endif; ?>>
	<section class="blog-hero hero">
		<div class="blog-hero-text hero-text">
			<h1 class="fade fade-in blog-hero-text-header hero-text-header<?php echo !$has_bg ? ' hero-text-header--nobg' : ''; ?>"><?php echo get_field('blog-alt-toggle', 'option') ? get_field('blog-alt', 'option') : 'blog' ?></h1>
		</div>
	</section>
	<section class="fade fade-in blog-blog">
		<?php 
		$the_query = new WP_Query(array(
			'post_type' => 'post',
			'posts_per_page' => 1,
		));
		if($the_query->have_posts()) : ?>
		<div class="blog-blog-grid">
			<?php while($the_query->have_posts()): $the_query->the_post();  ?>
			<div class="blog-blog-grid-item">
				<div class="blog-blog-grid-item-textcontainer">
					<a href="<?php echo get_permalink(); ?>" class="blog-blog-grid-item-textcontainer-header"><?php echo $post->post_title; ?></a>
					<div class="blog-blog-grid-item-textcontainer-date"><?php echo 'Posted on: ' . date('M jS Y', strtotime($post->post_date)) . ' at ' . date('g:i A', strtotime($post->post_date)); ?></div>
					<div class="blog-blog-grid-item-socialcontainer"><?php render_post_social_links($post->ID, 'blog-blog-grid-item-socialcontainer-link', 'blog-blog-grid-item-socialcontainer-link-icon'); ?></div>
					<div class="blog-blog-grid-item-textcontainer-description"><?php echo $post->post_content; ?></div>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
		
		<?php get_template_part('partials/navigation/blog', 'sidebar'); ?>

		<?php endif; ?>
	</section>
	<a href="<?php echo site_url('blog'); ?>" class="blog-blog-seemore global-recentposts-viewall">View All</a>
	<div class="main-tint<?php echo !$has_bg ? ' main-tint--nobg' : ''; ?>"></div>
</main>