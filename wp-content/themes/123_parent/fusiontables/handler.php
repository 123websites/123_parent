<?php 

class FusionTableHandler{
	private $table_data = array(
		array(
			'name' => 'states',
			'pair_delimiter' => ',0.0 ',
			'geometry_index' => 2,
		),
		array(
			'name' => 'counties',
			'pair_delimiter' => ' ',
			'geometry_index' => 4,
		),
		array(
			'name' => 'countries',
			'pair_delimiter' => ',0',
			'geometry_index' => 0,
		),
	);

	private $fusion_table_columns = array(
		'states' => ['name', 'id', 'geometry'],
		'counties' => ['county name', 'basic county', 'state abbr', 'State Abbr UC', 'geometry', 'value', 'GEO_ID', 'GEO_ID2', 'Geographic Name', 'STATE num', 'COUNTY num', 'FIPS formula', 'Has error'],
		'countries' => ['geometry', 'geometry_vertex_count', 'OBJECTID', 'ISO_2DIGIT', 'Shape_Leng', 'Shape_Area', 'Name', 'import_notes'],
	);

	private $sql_table_names;

	private $table_prefix;

	public function __construct(){
		global $wpdb;

		$this->table_prefix = $wpdb->prefix . '123ft_';

		$this->sql_table_names = array_map(function($el){
			return $this->table_prefix . $el['name'];
		}, $this->table_data);
	}

	public function build_sql_tables(){
		foreach($this->sql_table_names as $index => $sql_table_name){
			if( $this->sql_table_exists($sql_table_name) == false ){
				$this->create_sql_table($sql_table_name);
				$fusion_table_data = $this->get_fusion_table_data($this->table_data[$index]['name']);
				$this->insert_fusion_table_data($sql_table_name, $fusion_table_data);
			}
		}
	}

	public function get_fusion_table_data($table_name){
		// setup internal vars
		$geometry_index;
		$pair_delimiter;
		foreach($this->table_data as $el){
			if( $el['name'] == $table_name ){
				$geometry_index = $el['geometry_index'];
				$pair_delimiter = $el['pair_delimiter'];
			}
		}

		// get lines
		$csv = [];
		$lines = file(get_template_directory_uri() . '/fusiontables/' . $table_name . '.csv', FILE_IGNORE_NEW_LINES);
		foreach ($lines as $key => $value) {
		    $csv[$key] = str_getcsv($value);
		}

		$contents_arr = [];
		
		// parse rows	
		foreach($csv as $index => $content){
			// ignore first row
			if( $index == 0 ){
				continue;
			}
			else{
				// skip empty rows or rows without geometry
				if( !empty($content) ){
					if( !isset($content[$geometry_index]) ){
						continue;
					}

					// create xml element
					$xml = new SimpleXMLElement($content[$geometry_index]);

					// get all the coordinates elements
					$coords_xml = $xml->xpath('//coordinates');
					// every polygon coordinate element
					$all_coord_pairs = [];
					foreach($coords_xml as $coords_el){
						// convert xml el to string
						$coords_el_str = $coords_el->__toString();
						// apply pair separation delimeter
						$comma_separated_coordinate_pairs = explode($pair_delimiter, $coords_el_str);
						// every coordinate pair - comma separated
						$coord_pairs_array = [];
						foreach($comma_separated_coordinate_pairs as $el){
							// removing white spaces because of countries delimiter
							$el_explode = explode(',', str_replace(' ', '', $el));
							
							//build coordinate pair latlng if a complete latlng is available
							if( isset($el_explode[1]) ){
								$coord_pairs_array[] = array(
									'lat' => utf8_encode($el_explode[1]),
									'lng' => utf8_encode($el_explode[0])
								);
							}
							// cleanup
							unset($el_explode);
							unset($el);
						}
						// add to all coordinate pairs for this polygon coordinate element
						$all_coord_pairs[] = $coord_pairs_array;
					}
					// replace the kml geometry with the arrays of coordinate pairs
					$content[$geometry_index] = $all_coord_pairs;
					// make sure all content besides geometry is utf8 encoded
					foreach($content as $index => &$val){
						if( $index == $geometry_index ) continue;
						$val = utf8_encode($val);
					}
					// build array of rows from csv
					$contents_arr[] = $content;
				}
			}
		}
		return $contents_arr;
	}

	public function get_countries_for_acf_select(){
		global $wpdb;
		$results = $wpdb->get_results('SELECT ISO_2DIGIT, Name FROM ' . $this->table_prefix . 'countries ORDER BY Name;', ARRAY_N);
		$for_return = [];
		foreach($results as $result){
			$for_return[$result[0]] = $result[1];
		}
		return $for_return;
	}

	public function get_states_for_acf_select(){
		global $wpdb;
		$results = $wpdb->get_results('SELECT id, name FROM ' . $this->table_prefix . 'states ORDER BY name;', ARRAY_N);
		$for_return = [];
		foreach($results as $result){
			$for_return[$result[0]] = $result[1];
		}
		return $for_return;
	}

	public function get_states_geometry($states){
		global $wpdb;	
		$sql_states = '';
		foreach($states as $index => $state){
			if( $index !== count($states) - 1 ){
				$sql_states .= '"' . $state . '", ';
			}
			else{
				$sql_states .= '"' . $state . '"';
			}
		}
		$result = $wpdb->get_results('SELECT geometry FROM ' . $this->table_prefix . 'states WHERE id IN (' . $sql_states . ');', ARRAY_A);
		return $result;
	}

	public function get_counties_geometry($counties){
		global $wpdb;	
		$sql_counties = '';
		foreach($counties as $index => $county){
			if( $index !== count($counties) - 1 ){
				$sql_counties .= '"' . $county . '", ';
			}
			else{
				$sql_counties .= '"' . $county . '"';
			}
		}
		$result = $wpdb->get_results('SELECT geometry FROM ' . $this->table_prefix . 'counties WHERE basic_county IN (' . $sql_counties . ');', ARRAY_A);
		return $result;
	}

	public function get_countries_geometry($countries){
		global $wpdb;	
		$sql_countries = '';
		foreach($countries as $index => $country){
			if( $index !== count($countries) - 1 ){
				$sql_countries .= '"' . $country . '", ';
			}
			else{
				$sql_countries .= '"' . $country . '"';
			}
		}
		$result = $wpdb->get_results('SELECT geometry FROM ' . $this->table_prefix . 'countries WHERE ISO_2DIGIT IN (' . $sql_countries . ');', ARRAY_A);
		return $result;
	}

	private function insert_fusion_table_data($sql_table_name, $fusion_table_data){
		global $wpdb;
		$columns = $wpdb->get_results('SHOW COLUMNS FROM ' . $sql_table_name . ';');
		
		if( !empty($columns) ){
			foreach( $fusion_table_data as $row ){
				$insert_data = [];

				foreach( $row as $index => $val ){
					if( gettype($val) == 'array' ){
						$insert_data[$columns[$index]->Field] = json_encode( $val );
					}
					else{
						$insert_data[$columns[$index]->Field] = $val;
					}
				}

				$count = 0;
				$fields = '';

				foreach($insert_data as $col => $val) {
					if($count++ != 0) $fields .= ', ';
					$col = esc_sql($col);
					$val = "'" . esc_sql($val) . "'";
					if(empty($val))	$val = '" "';
					$fields .= "`$col` = $val";
				}
				$query = "INSERT INTO $sql_table_name SET $fields;";

				$wpdb->query($query);
			}
		}
		else{
			return new WP_Error('db', 'Columns can\'t be found in ' . $fusion_table_name);
		}

	}

	private function create_sql_table($sql_table_name){
		global $wpdb;
		// build query_string
		$query_string = 'CREATE TABLE ' . $sql_table_name . ' (';
		foreach( $this->fusion_table_columns[str_replace($this->table_prefix, '', $sql_table_name)] as $index => $col ){
			if( $index !== count($this->fusion_table_columns[str_replace($this->table_prefix, '', $sql_table_name)]) - 1 ){
				$type = 'TEXT';
				if( $col == 'geometry' ){
					$type = 'LONGTEXT';
				}
				$query_string .= str_replace(' ', '_', $col) . " " . $type . ", ";
			}
			else{
				$query_string .= str_replace(' ', '_', $col) . " " . $type . ");";	
			}
		}
		$wpdb->query($query_string);
	}

	private function sql_table_exists($sql_table_name){
		global $wpdb;
		$rows = $wpdb->get_results('SHOW TABLES LIKE "' . $sql_table_name . '"');
		return !empty($rows);
	}
}

$fth = new FusionTableHandler();

$fth->build_sql_tables();

?>