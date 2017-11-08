<?php 

class FusionTableHandler{
	public function __construct(){

	}
	public function get_table($table_name){
		if( $table_name == 'states' ){
			$contents = file_get_contents_curl(get_template_directory_uri() . '/fusiontables/states.csv');
			$contents = explode(PHP_EOL, $contents);
			$contents_arr = [];
			foreach($contents as $index => $content){
				if( $index == 0 ){
					continue;
				}
				else{
					$row = preg_split('/,(?!\d|-)/', $content);
					if( !empty($row[0]) ){
						$kml = new SimpleXMLElement(str_replace('"', '', $row[2]));
						error_log(print_r($kml, true));
						// array_push($contents_arr, );
					}
				}
			}
			// error_log(print_r($contents_arr, true));
		}
		elseif( $table_name == 'counties' ){

		}
		elseif( $table_name == 'countries' ){

		}
		else{
			return new WP_Error('maps', 'Table name ' . $table_name . ' invalid');
		}
	}
}

$fth = new FusionTableHandler();
$fth->get_table('states');
?>