<?php

include_once dirname(__FILE__) . '/config.php';
include_once dirname(__FILE__) . '/system.php';
class Benchmark{
	
	private static $instance;
	private $cpu = array(
		'current' 	=>	0,
		'peak'		=>	0,
		'total'		=> 	0,
		'average'	=> 	0,
	);
	private $memory = array(
		'current' 	=>	0,
		'peak'		=>	0,
		'total'		=> 	0,
		'average'	=>	0,
	);
	private $counter = 0;

	protected function __construct(){
		$this->onRequestStart();
	}

	public function execute($run, $connection_counters){
		if($run){
			$this->counter++;
			$this->memoryUsage();
			$this->cpuUsage();
		}
		if($this->counter == RUNTIME_COUNT*(60)){
			System::detectSystem();
			System::notify("Benchmark Finished!", "Benchmark written on logs/benchmark.log");
			$this->logResults($connection_counters);
			exit;
		}
	}

	public static function getInstance(){
		if(empty(self::$instance)) self::$instance = new Benchmark();
		return self::$instance;
	}

	private function logResults($connection_counters){
		$file = 'logs/benchmark.log';
		if(!file_exists($file)) fopen($file, 'w');

		$file_write = fopen($file, 'w');

		fwrite($file_write, "Benchmark for " . RUNTIME_COUNT . " minute/s.\n");
		fwrite($file_write, "Connections established: 		{$connection_counters['started']}\n");
		fwrite($file_write, "Connections finished: 			{$connection_counters['finished']}\n\n");
		fwrite($file_write, "-- Memory --\n\n");
        fwrite($file_write, "CURRENT:          {$this->memory['current']}kB\n");
        fwrite($file_write, "PEAK:             {$this->memory['peak']}kB\n");
        fwrite($file_write, "AVERAGE:          {$this->memory['average']}kB\n");
		fwrite($file_write, "-- CPU Usage --\n\n");
        fwrite($file_write, "CURRENT:          {$this->cpu['current']}%\n");
        fwrite($file_write, "PEAK:             {$this->cpu['peak']}%\n");
        fwrite($file_write, "AVERAGE:          {$this->cpu['average']}%\n");

		fclose($file_write);
	}

	private function memoryUsage(){
		$this->memory['current'] = memory_get_usage(1)/1024;
		$this->memory['peak'] = memory_get_peak_usage(1)/1024;
		$this->memory['total'] += $this->memory['current'];
		$this->memory['average'] = $this->memory['total']/$this->counter;

		echo "-- Memory --\n\n";
		echo "CURRENT:			{$this->memory['current']}kB\n";
		echo "PEAK:				{$this->memory['peak']}kB\n";
		echo "AVERAGE:			{$this->memory['average']}kB\n";
	}

	private function cpuUsage(){
		$this->cpu['current'] = $this->getCpuUsage();
		$this->cpu['total'] += $this->cpu['current'];
		$this->cpu['average'] = $this->cpu['total']/$this->counter;
		if($this->cpu['current'] > $this->cpu['peak']) $this->cpu['peak'] = $this->cpu['current'];

		echo "-- CPU Usage --\n\n";
		echo "CURRENT:			{$this->cpu['current']}%\n";
		echo "PEAK:				{$this->cpu['peak']}%\n";
		echo "AVERAGE:			{$this->cpu['average']}%\n";
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
