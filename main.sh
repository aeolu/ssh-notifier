#!/usr/bin/php

<?php

$exec = shell_exec("w -h"); // get all connections
$connections = filterData($exec);
$ssh_connections = filterSSH($connections);

echo print_r($ssh_connections, true);

function filterSSH($connections){
	
	$ssh_connections = array();

	for($i = 0; $i < count($connections); $i++){
		if($connections[$i]['FROM'] != '-') $ssh_connections[] = $connections[$i];
	}

	return $ssh_connections;
}

function filterData($data){

	$connections = array();
	$headers = getConnectionHeaders();
    $data = array_filter(explode("\n", $data));

    foreach($data as $datum){
		$temp = array();
    	$values = preg_split("/\s+/", $datum);
		for($i = 0; $i < count($values); $i++){

			// Appends the excess to the job header
			if($headers[$i])
				$temp[$headers[$i]] = $values[$i];
			else
				$temp[$headers[count($headers)-1]] .= " " . $values[$i];

		}
		$connections[] = $temp;
	}

    return $connections;
}

function detectSystem(){
	$operating_systems = array('darwin', 'linux', 'win');
	$uname = strtolower(php_uname()); // get system information
	$system = '';

	foreach($operating_systems as $operating_system){
		// find a certain OS identifier
		if(strpos($uname, $operating_system) !== false)
			$system = $operating_system;
			break;
	}

	return ($system) ? ucfirst($system) : 'Unkown';
}

function getConnectionHeaders(){
	$headers = array();
	$exec = shell_exec('w');
	
	$row_headers = explode("\n", $exec);
	$headers = preg_split("/\s+/", $row_headers[1]); // explode by indefinite amount of whitespaces

	return $headers;	
}

