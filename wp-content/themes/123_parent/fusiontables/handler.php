<?php 

class FusionTableHandler{
	public function __construct(){

	}
	public function get_table($table_name){
		if( $table_name == 'states' ){
			// get states fusiontable from csv over cURL
			$contents = file_get_contents_curl(get_template_directory_uri() . '/fusiontables/states.csv');
			// split by every end of line character
			$contents = explode(PHP_EOL, $contents);
			$contents_arr = [];
			foreach($contents as $index => $content){
				if( $index == 0 ){
					continue;
				}
				else{
					// split each row into name, id, geometry
					$row = preg_split('/,(?!\d|-)/', $content);
					if( !empty($row[0]) ){
						// turn kml string into xml
						$xml = new SimpleXMLElement(str_replace('"', '', $row[2]));
						// get all the coordinates elements
						$coords_xml = $xml->xpath('//coordinates');
						$all_coord_pairs = [];
						// every polygon coordinate element
						foreach($coords_xml as $coords_el){
							$coords_el_str = $coords_el->__toString();
							$comma_separated_coordinate_pairs = explode(',0.0 ', $coords_el_str);
							$coord_pairs_array = [];
							// every coordinate pair - comma separated
							foreach($comma_separated_coordinate_pairs as $el){
								$el_explode = explode(',', $el);
								// build coordinate pair latlng
								array_push($coord_pairs_array, array(
									'lat' => $el_explode[0],
									'lng' => $el_explode[1]
								));
							}
							array_push($all_coord_pairs, $coord_pairs_array);
						}
						// replace the kml geometry
						$row[2] = $all_coord_pairs;
						// build contents_arr
						array_push($contents_arr, $row);
					}
				}
			}
			return $contents_arr;
		}
		elseif( $table_name == 'counties' ){
			// get states fusiontable from csv over cURL
			$contents = file_get_contents_curl(get_template_directory_uri() . '/fusiontables/counties.csv');
			// split by every end of line character
			$contents = explode(PHP_EOL, $contents);
			$contents_arr = [];
			foreach($contents as $index => $content){
				if( $index == 0 ){
					continue;
				}
				else{
					// split each row into name, id, geometry
					$row = preg_split('/,(?!\d|-)/', $content);
					if( !empty($row[0]) ){
						if( !isset($row[4]) ){
							continue;
						}
						preg_match('/".*"/', $row[4], $matches);
						if( empty($matches[0]) ){
							continue;
						}
						$xml = new SimpleXMLElement(str_replace('"','', $matches[0]));
						// get all the coordinates elements
						$coords_xml = $xml->xpath('//coordinates');
						$all_coord_pairs = [];
						// every polygon coordinate element
						foreach($coords_xml as $coords_el){
							$coords_el_str = $coords_el->__toString();
							$comma_separated_coordinate_pairs = explode(' ', $coords_el_str);
							$coord_pairs_array = [];
							// every coordinate pair - comma separated
							foreach($comma_separated_coordinate_pairs as $el){
								$el_explode = explode(',', $el);
								
								//build coordinate pair latlng
								$coord_pairs_array[] = array(
									'lat' => $el_explode[0],
									'lng' => $el_explode[1]
								);
							}
							$all_coord_pairs[] = $coord_pairs_array;
						}
						// replace the kml geometry
						$row[4] = $all_coord_pairs;
						// build contents_arr
						$contents_arr[] = $row;
					}
				}
			}
			return $contents_arr;
		}
		elseif( $table_name == 'countries' ){
			// get states fusiontable from csv over cURL
			$contents = file_get_contents_curl(get_template_directory_uri() . '/fusiontables/countries.csv');
			// split by every end of line character
			$contents = explode(PHP_EOL, $contents);
			$contents_arr = [];
			foreach($contents as $index => $content){
				if( $index == 0 ){
					continue;
				}
				else{
					
					// split each row into geometry, geometry_vertex_count, OBJECTID, ISO_2DIGIT, Shape_Leng, Shape_Area, Name, import_notes
					$row = [];
					preg_match_all('/[^"]*,[^"]*/', $content, $matches);
					if( !is_array_empty($matches) ){
						$explosion = explode(',', str_replace($matches[0][0], '', $content));
						if( !is_null($explosion) ){
							$row[0] = str_replace('"', '', $matches[0][0]);
							foreach($explosion as $el){
								if( !empty($el) && $el !== '""' ){
									$row[] = str_replace('"', '', $el);
								}
							}
						}
					}

					if( !empty($row[0]) ){
						$xml = new SimpleXMLElement($row[0]);
						// get all the coordinates elements
						$coords_xml = $xml->xpath('//coordinates');
						$all_coord_pairs = [];
						// every polygon coordinate element
						foreach($coords_xml as $coords_el){
							$coords_el_str = $coords_el->__toString();
							
							$comma_separated_coordinate_pairs = array_filter(explode(',0', $coords_el_str), function($arr){
								if( !empty($arr) ){
									return $arr;
								}
							});

							$coord_pairs_array = [];
							// every coordinate pair - comma separated
							foreach($comma_separated_coordinate_pairs as $pair_index => $el){
								
								$el_explode = explode(',', str_replace(' ', '', $el));
								
								// build coordinate pair latlng
								if( isset($el_explode[1]) ){
									array_push($coord_pairs_array, array(
										'lat' => $el_explode[0],
										'lng' => $el_explode[1]
									));
								}
								$el_explode = null;
							
							}
							array_push($all_coord_pairs, $coord_pairs_array);
						}
						// replace the kml geometry
						$row[0] = $all_coord_pairs;
						// build contents_arr
						array_push($contents_arr, $row);
					}
				}
			}
			return $contents_arr;
		}
		else{
			return new WP_Error('maps', 'Table name ' . $table_name . ' invalid');
		}
	}
}

$fth = new FusionTableHandler();
// $fth->get_table('countries');
error_log(print_r($fth->get_table('countries'), true));

?>