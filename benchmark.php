<?php

class Benchmark{
	
	private static $instance;
	private $memory = array(
		'current' 	=>	0,
		'peak'		=>	0,
	);

	protected function __construct(){
		$this->memoryUsage();
	}

	public static function getInstance(){
		if(empty(self::$instance)) self::$instance = new Benchmark();
		return self::$instance;
	}

	private function memoryUsage(){
		$this->memory['current'] = memory_get_usage(1)/1024;
		$this->memory['peak'] = memory_get_peak_usage(1)/1024;
		
		echo "-- Memory --\n\n";
		echo "CURRENT:\t\t{$this->memory['current']}kB\n";
		echo "PEAK:\t\t\t{$this->memory['peak']}kB\n";
	}
}
