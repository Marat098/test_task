<?php
class FlightsInfo
{
    
    public $paths = []; 
    public $flights = []; 
    public $long_path = []; 
    
    public function __construct($flights){
	    $this->flights = $flights;
	}

    public function search_path($from, $arrival_time, $path){
        foreach( $this->flights as $key => $value ){
			$date_1 = date( strtotime($value['arrival']));
			$date_2 = date( strtotime($arrival_time));
			if( $value['from'] == $from and $date_1 >= $date_2){
				$obj =  new ArrayObject($path);
				$new_path = $obj->getArrayCopy();
				array_push($new_path, $value);
				$this->search_path($value['to'], $value['arrival'], $new_path);
			}
		}
		$path['time'] = date( strtotime(end($path)['arrival'])) - date( strtotime($path[0]['depart']));
		array_push($this->paths, $path);
    }
    
    public function search_longest_path(){
    	$this->long_path = $this->paths[0];

		foreach( $this->paths as $key => $value ){
			if ($value['time'] > $this->long_path['time']){
				$this->long_path = $value;
			}
		}
    }
    
    public function start_search(){
    	foreach( $this->flights as $key => $value ){
			$this->search_path($value['to'], $value['arrival'], [$value]);
		}
    }
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

$flightsInfo = new FlightsInfo($flights);
$flightsInfo->start_search();
$flightsInfo->search_longest_path();


print_r($flightsInfo->long_path);