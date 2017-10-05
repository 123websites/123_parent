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
							curl_setopt($ch, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/xml?latlng=' . $row['zip']['lat'] . ',' . $row['zip']['lng'] . '&sensor=true&key=' . get_gmap_api_key());
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							$curl_return = curl_exec($ch);
							$contents = simplexml_load_string($curl_return);
							$city_name = $contents->xpath('/GeocodeResponse/result/address_component[type = "locality"]/long_name/text()')[0]->__toString();
							$state_name = $contents->xpath('/GeocodeResponse/result/address_component[type = "administrative_area_level_1"]/short_name/text()')[0]->__toString();
						?>
							<div class="fade fade-up areas-served-areas-grid-imagecontainer" target="_blank">
								<div style="background-image: url('<?php echo $row['area-image']; ?>');" class="areas-served-areas-grid-imagecontainer-image"></div>
								<div class="areas-served-areas-grid-imagecontainer-citystate"><?php 
									echo $city_name . ', ' . $state_name;
								?></div>
							</div>
					<?php 
						endforeach;
					endif;
				}
				elseif( get_field('areas_served_select', 'option') == 'states' ){
					if( have_rows('states', 'option') ):
						$rows = get_field('states', 'option');
						foreach($rows as $index => $row): 
							
						?>
							<div class="fade fade-up areas-served-areas-grid-imagecontainer" target="_blank">
								<div style="background-image: url('<?php echo $row['image']; ?>');" class="areas-served-areas-grid-imagecontainer-image"></div>
								<div class="areas-served-areas-grid-imagecontainer-citystate"><?php echo $row['state']['label'] ?></div>
							</div>
					<?php 
						endforeach;	
					endif;
				}
				elseif( get_field('areas_served_select', 'option') == 'counties' ){
					if( have_rows('counties', 'option') ):
						$rows = get_field('counties', 'option');
						foreach($rows as $index => $row): 
						?>
							<div class="fade fade-up areas-served-areas-grid-imagecontainer" target="_blank">
								<div style="background-image: url('<?php echo $row['image']; ?>');" class="areas-served-areas-grid-imagecontainer-image"></div>
								<div class="areas-served-areas-grid-imagecontainer-citystate"><?php 
									preg_match_all('/(.*)(?=\,)/', $row['county']['address'], $matches);
									echo $matches[0][0];
								?></div>
							</div>
					<?php 
						endforeach;	
					endif;
				}
				else{
					if( have_rows('countries', 'option') ):
						$rows = get_field('countries', 'option');
						foreach($rows as $index => $row): 
							
						?>
							<div class="fade fade-up areas-served-areas-grid-imagecontainer" target="_blank">
								<div style="background-image: url('<?php echo $row['country_image']; ?>');" class="areas-served-areas-grid-imagecontainer-image"></div>
								<div class="areas-served-areas-grid-imagecontainer-citystate"><?php echo $row['country']['label'] ?></div>
							</div>
					<?php 
						endforeach;	
					endif;
				}
				?>
			</div>
	</section>
</main>