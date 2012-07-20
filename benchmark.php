<?php

class Benchmark{
	
	private static $instance;

	protected function __construct(){
		echo "Using Benchmark class\n";
	}

	public static function getInstance(){
		if(empty(self::$instance)) self::$instance = new Benchmark();
		return self::$instance;
	}


}
