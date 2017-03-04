<?php get_header(); ?>

<main class="areas-served">
	<section class="areas-served-hero hero"">
		<div class="areas-served-hero-text hero-text">
			<h1 class="areas-served-hero-text-header hero-text-header">areas served</h1>
		</div>
		<div class="areas-served-hero-tint hero-tint"></div>
		<div class="areas-served-hero-map" id="map"></div>
	</section>
	<section class="areas-served-areas">
		<?php if(have_rows('locations', 'option')) : ?>
			<div class="areas-served-areas-grid">
				<?php 
				$rows = get_field('locations', 'option'); 
				$medium_remainder = count($rows) % 2;
				$large_remainder = count($rows) % 4;
				foreach($rows as $index => $row): 
					$classes = '';
					if(!empty($medium_remainder) && $index >= count($rows) - $medium_remainder){
						$classes .= 'medium-' . (string) $medium_remainder . ' ';
					}
					if(!empty($large_remainder) && $index >= count($rows) - $large_remainder){
						$classes .= 'large-' . (string) $large_remainder . ' ';
					}
					?>
					<?php $contents = simplexml_load_file('http://maps.googleapis.com/maps/api/geocode/xml?address='.$row['zip'].'@&sensor=true'); ?>
					<a href="https://www.google.com/maps/@<?php echo $contents->result->geometry->location->lat . ',' . $contents->result->geometry->location->lng . ',14z'; ?>" class="areas-served-areas-grid-imagecontainer<?php echo !empty($classes) ? ' ' . $classes : '';  ?>" target="_blank">
						<div class="areas-served-areas-grid-imagecontainer-citystate"><?php 
							preg_match_all('/^.*?(?=(\d))/', $contents->result->formatted_address, $preg_match_all_matches);
							echo $preg_match_all_matches[0][0];
						?></div>
						<div class="areas-served-areas-grid-imagecontainer-tint"></div>
						<div style="background-image: url('<?php echo $row['area-image']; ?>');" class="areas-served-areas-grid-imagecontainer-image"></div>
					</a>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</section>
	<?php

	get_template_part('partials/global', 'recent_posts');
	get_template_part('partials/global', 'contact');

	?>
</main>

<?php get_footer(); ?>