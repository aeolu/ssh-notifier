<?php

class Benchmark{
	
	private static $instance;
	private $cpu = array(
		'current' 	=>	0,
		'peak'		=>	0,
	);
	private $memory = array(
		'current' 	=>	0,
		'peak'		=>	0,
	);

	protected function __construct(){
		$this->onRequestStart();
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

	private function cpuUsage(){
		$this->cpu['current'] = $this->getCpuUsage();
		if($this->cpu['current'] > $this->cpu['peak'])
			$this->cpu['peak'] = $this->cpu['current'];

		echo "-- CPU Usage --\n\n";
		echo "CURRENT:\t\t{$this->cpu['current']}%\n";
		echo "PEAK:\t\t\t{$this->cpu['peak']}%\n";
	}

	private function onRequestStart() {
		$dat = getrusage();
		define('PHP_TUSAGE', microtime(true));
		define('PHP_RUSAGE', $dat["ru_utime.tv_sec"]*1e6+$dat["ru_utime.tv_usec"]);
	}
 
	private function getCpuUsage() {
	    $dat = getrusage();
	    $dat["ru_utime.tv_usec"] = ($dat["ru_utime.tv_sec"]*1e6 + $dat["ru_utime.tv_usec"]) - PHP_RUSAGE;
	    $time = (microtime(true) - PHP_TUSAGE) * 1000000;
 
	    // cpu per request
	    if($time > 0) {
	        $cpu = sprintf("%01.2f", ($dat["ru_utime.tv_usec"] / $time) * 100);
	    } else {
	        $cpu = '0.00';
	    }
	 
	    return $cpu;
	}
}
