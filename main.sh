#!/usr/bin/php

<?php


function detectSystem(){
	$operating_systems = array('darwin', 'linux', 'win');
	$uname = strtolower(php_uname());
	$system = '';

	foreach($operating_systems as $operating_system){
		if(strpos($uname, $operating_system) !== false)
			$system = $operating_system;
			break;
	}

	return ($system) ? ucfirst($system) : 'Unkown';
}
