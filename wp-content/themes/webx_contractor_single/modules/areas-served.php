<main class="areas-served main" id="areas-served">
	<section class="areas-served-hero hero"">
		<div class="areas-served-hero-text hero-text">
			<h1 class="fade fade-up areas-served-hero-text-header hero-text-header"><?php echo get_field('areas-served-alt-toggle', 'option') ? get_field('areas-served-alt', 'option') : 'areas served' ?></h1>
		</div>
		<div class="areas-served-hero-tint hero-tint"></div>
		<div class="areas-served-hero-map" id="map"></div>
	</section>
	<section class="areas-served-areas">
		<?php if(have_rows('locations', 'option')) : ?>
			<div class="areas-served-areas-grid">
				<?php 
				$rows = get_field('locations', 'option'); 
				foreach($rows as $index => $row): 
					$contents = simplexml_load_file('http://maps.googleapis.com/maps/api/geocode/xml?address='.$row['zip'].'@&sensor=true'); ?>
					<a href="https://www.google.com/maps/@<?php echo $contents->result->geometry->location->lat . ',' . $contents->result->geometry->location->lng . ',14z'; ?>" class="fade fade-up areas-served-areas-grid-imagecontainer" target="_blank">
						<div style="background-image: url('<?php echo $row['area-image']; ?>');" class="areas-served-areas-grid-imagecontainer-image"></div>
						<div class="areas-served-areas-grid-imagecontainer-citystate"><?php 
							preg_match_all('/^.*?(?=(\d))/', $contents->result->formatted_address, $preg_match_all_matches);
							echo $preg_match_all_matches[0][0];
						?></div>
					</a>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</section>
</main>