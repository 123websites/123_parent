<div class="blog-blog-sidebar">
	<div class="blog-blog-sidebar-recentposts">
		<h3 class="blog-blog-sidebar-recentposts-header">Recent Posts</h3>
		<div class="blog-blog-sidebar-recentposts-grid">
			<?php 
			
			$posts = get_posts(array(
				'numposts' => 5,
				'post_type' => 'post',
			)); 

			foreach($posts as $post):
				?>
				<div class="blog-blog-sidebar-recentposts-grid-item">
					<a href="<?php echo get_the_permalink($post->ID); ?>" class="blog-blog-sidebar-recentposts-grid-item-header"><?php echo $post->post_title ?></a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="blog-blog-sidebar-categories">
		<h3 class="blog-blog-sidebar-categories-header">Categories</h3>
		<div class="blog-blog-sidebar-categories-grid">
			<?php 
			// terms with highest count returned first
			$terms = get_terms(array(
				'taxonomy' => 'category',
				'orderby' => 'count',
				'number' => 5,
				'order' => 'DESC',
			));

			foreach($terms as $term):
				?>
					<div class="blog-blog-sidebar-categories-grid-item">
						<a href="<?php echo get_term_link($term, 'category'); ?>" class="blog-blog-sidebar-categories-grid-item-header"><?php echo $term->name ?></a>
					</div>								
				<?php
			endforeach;

			?>
		</div>
	</div>
	<div class="blog-blog-sidebar-archive">
		<h3 class="blog-blog-sidebar-archive-header">Archive</h3>
		<div class='blog-blog-sidebar-archive-grid'>
			<?php 

			echo wp_get_archives(array(
				'post_type' => 'post',
			    'type' => 'monthly',
			    'echo' => 0,
			    'format' => 'custom',
			    'before' => '<div class="blog-blog-sidebar-archive-grid-item">',
			    'after' => '</div>',
			));

			?>
		</div>
	</div>
	<a href="#" class="header-content-quickquote blog-blog-sidebar-quickquote"><?php echo get_field('quickquote-button-text', 'option'); ?></a>
</div>