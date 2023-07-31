<?php
$paths = [];
function search_path($from, $arrival_time, $path, $flights){
	foreach( $flights as $key => $value ){
		$date_1 = date( strtotime($value['arrival']));
		$date_2 = date( strtotime($arrival_time));
		if( $value['from'] == $from and $date_1 >= $date_2){
			$obj =  new ArrayObject($path);
			$new_path = $obj->getArrayCopy();
			array_push($new_path, $value);
			search_path($value['to'], $value['arrival'], $new_path, $flights);
		}
	}
	$path['time'] = date( strtotime(end($path)['arrival'])) - date( strtotime($path[0]['depart']));
	array_push($GLOBALS['paths'], $path);
}

$flights = [
	[
		'from' => 'VKO',
		'to' => 'DME',
		'depart' => '01.01.2020 12:44',
		'arrival' => '01.01.2020 13:44',
	],
	[
		'from' => 'DME',
		'to' => 'JFK',
		'depart' => '02.01.2020 23:00',
		'arrival' => '03.01.2020 11:44',
	],
	[
		'from' => 'DME',
		'to' => 'HKT',
		'depart' => '01.01.2020 13:40',
		'arrival' => '01.01.2020 22:22',
	],
];

foreach( $flights as $key => $value ){
	search_path($value['to'], $value['arrival'], [$value], $flights);
}
$long_path = $paths[0];

foreach( $paths as $key => $value ){
	if ($value['time'] > $long_path['time']){
		$long_path = $value;
	}
}

print_r($long_path);
