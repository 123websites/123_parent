<main class="coupons main" id="coupons">
	<section class="coupons-hero hero">
		<div class="coupons-hero-text hero-text">
			<h1 class="fade fade-in coupons-hero-text-header hero-text-header"><?php echo get_field('coupons-alt-toggle', 'option') ? get_field('coupons-alt', 'option') : 'coupons' ?></h1>
		</div>
	</section>
	<section class="coupons-coupons section">
		<?php 
		
		$the_query = new WP_Query(array(
			'post_type' => 'coupon',
			'posts_per_page' => 6,
			'meta_query' => array(
				array(
					'key' => 'coupon-expiration-date',
					'value' => date("Y-m-d H:i:s"),
					'compare' => '>=',
				),
			),
		));

		if($the_query->have_posts()) : ?>
		<div class="coupons-coupons-grid">
			<?php while($the_query->have_posts()): $the_query->the_post();  ?>
			<div class="fade fade-up coupons-coupons-grid-item">
				<div class="coupons-coupons-grid-item-textcontainer">
					<h2 class="coupons-coupons-grid-item-textcontainer-sitename"><?php echo get_bloginfo('name'); ?></h2>
					<h2 class="coupons-coupons-grid-item-textcontainer-header"><?php echo $post->post_title; ?></h2>
					<div class="coupons-coupons-grid-item-textcontainer-exipiration"><?php echo 'Expires on: ' . get_field('coupon-expiration-date'); ?></div>
					<div class="coupons-coupons-grid-item-textcontainer-code"><?php echo 'Coupon Code: <strong>' . get_field('coupon-code') . '</strong>'; ?></div>
					<a target="_blank" href="<?php echo get_permalink(); ?>" class="coupons-coupons-grid-item-textcontainer-print">Print</a>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
		<a href="<?php echo site_url('coupons'); ?>" class="coupons-coupons-seemore global-recentposts-viewall">View All</a>
		
		<?php endif; ?>
	</section>
</main>