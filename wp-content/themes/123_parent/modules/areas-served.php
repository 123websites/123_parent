<main class="areas-served main" id="areas-served">
	<section class="areas-served-hero hero"">
		<div class="areas-served-hero-text hero-text">
			<h1 class="fade fade-up areas-served-hero-text-header hero-text-header"><?php echo get_field('areas-served-alt-toggle', 'option') ? get_field('areas-served-alt', 'option') : 'areas served' ?></h1>
		</div>
		<div class="areas-served-hero-tint hero-tint"></div>
		<div class="areas-served-hero-map" id="map"></div>
	</section>
	<section class="areas-served-areas">
			<div class="areas-served-areas-grid">
				<?php 
				$rows = [];
				if( get_field('areas_served_select', 'option') == 'zips' ){
					if(have_rows('locations', 'option')) :
						$rows = get_field('locations', 'option'); 
						foreach($rows as $index => $row): 
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/xml?latlng=' . $row['zip']['lat'] . ',' . $row['zip']['lng'] . '&sensor=true');
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							$curl_return = curl_exec($ch);
							$contents = simplexml_load_string($curl_return);
						?>
							<a href="https://www.google.com/maps/@<?php echo $contents->result->geometry->location->lat . ',' . $contents->result->geometry->location->lng . ',14z'; ?>" class="fade fade-up areas-served-areas-grid-imagecontainer" target="_blank">
								<div style="background-image: url('<?php echo $row['area-image']; ?>');" class="areas-served-areas-grid-imagecontainer-image"></div>
								<div class="areas-served-areas-grid-imagecontainer-citystate"><?php 
									preg_match_all('/\d{5}(?=\,)/', $contents->result->formatted_address, $preg_match_all_matches); 
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/xml?address=' . $preg_match_all_matches[0][0] . '&sensor=true&key=' . get_gmap_api_key());
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
									$curl_return = curl_exec($ch);
									$contents = simplexml_load_string($curl_return);
									preg_match_all('/^.*?(?=(\d))/', $contents->result->formatted_address, $preg_match_all_matches); 
									echo $preg_match_all_matches[0][0];
								?></div>
							</a>
					<?php 
						endforeach;
					endif;
				}
				elseif( get_field('areas_served_select', 'option') == 'states' ){
					if( have_rows('states', 'option') ):
						$rows = get_field('states', 'option');
						foreach($rows as $index => $row): 
							
						?>
							<a href="<?php echo 'https://www.google.com/maps/search/' . rawurlencode($row['state']['label']) . '?hl=en&source=opensearch' ?>" class="fade fade-up areas-served-areas-grid-imagecontainer" target="_blank">
								<div style="background-image: url('<?php echo $row['image']; ?>');" class="areas-served-areas-grid-imagecontainer-image"></div>
								<div class="areas-served-areas-grid-imagecontainer-citystate"><?php echo $row['state']['label'] ?></div>
							</a>
					<?php 
						endforeach;	
					endif;
				}
				else{
					if( have_rows('countries', 'option') ):
						$rows = get_field('countries', 'option');
						foreach($rows as $index => $row): 
							
						?>
							<a href="<?php echo 'https://www.google.com/maps/search/' . rawurlencode($row['country']['label']) . '?hl=en&source=opensearch' ?>" class="fade fade-up areas-served-areas-grid-imagecontainer" target="_blank">
								<div style="background-image: url('<?php echo $row['country_image']; ?>');" class="areas-served-areas-grid-imagecontainer-image"></div>
								<div class="areas-served-areas-grid-imagecontainer-citystate"><?php echo $row['country']['label'] ?></div>
							</a>
					<?php 
						endforeach;	
					endif;
				}
				?>
			</div>
	</section>
</main>