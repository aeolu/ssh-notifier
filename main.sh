#!/usr/bin/php

<?php

define('INTERVAL', 1);

class SSHNotifier{

	private static $instance;
	private $system;
	private $pid;
	private $status;
	private $ssh = array(
		'current'	=> 	array(),
		'update' 	=> 	array()
	);
	

	public static function getInstance(){
		if(empty(self::$instance)) self::$instance = new SSHNotifier();
		return self::$instance;
	}

	public function execute(){

		// Initialize global variables
		$this->pid = getmypid();
		$this->system = $this->detectSystem(); // Set the user's operating system

		//Notify the user
		$this->notify("SSH Notifier started", "To kill: kill {$this->pid}");

		$exec = shell_exec("w -h"); // get all connections
		
		$connections = $this->filterData($exec);
		$ssh_connections = $this->filterSSH($connections);
		$connection_count = count($ssh_connections); 
		$difference = array();

		$ssh['current'] = $ssh_connections;

		while(true){
			$exec = shell_exec("w -h"); // get all connections
			$connections = $this->filterData($exec);
			$ssh_connections = $this->filterSSH($connections);
			$current_count = count($ssh_connections);		

			if($connection_count != $current_count){
				$this->ssh['update'] = $ssh_connections;
				
				// Trace the connection difference
				if($current_count > $connection_count){
					$head = "SSH connection started";
					$difference = array_values(array_diff_assoc($this->ssh['update'], $this->ssh['current']));
				}else{
					$head = "SSH connection finished";
					$difference = array_values(array_diff_assoc($this->ssh['current'], $this->ssh['update']));
				}
		
				$difference = $difference[0];
				
				// create the message for the notification
				$message = "{$difference['USER']}@{$difference['FROM']} [{$difference['TTY']}]";
				$this->notify($head, $message);

				unset($difference);
				// Update persisent information
				$connection_count = $current_count;
				$this->ssh['current'] = $this->ssh['update'];
			}

			sleep(INTERVAL);
		}
		


	}

	private function notify($head, $message){

		switch($this->system){
			case 'Darwin':
				shell_exec("growlnotify -m '$message' '$head'");
				break;
			case 'Linux':
				shell_exec("notify-send '$head' '$message'");
				break;
		}

	}

	private function filterSSH($connections){
		
		$ssh_connections = array();

		for($i = 0; $i < count($connections); $i++){
			if($connections[$i]['FROM'] != '-') $ssh_connections[] = $connections[$i];
		}

		return $ssh_connections;
	}

	private function filterData($data){

		$connections = array();
		$headers = $this->getConnectionHeaders();
	    $data = array_filter(explode("\n", $data));

	    foreach($data as $datum){
			$temp = array();
	    	$values = preg_split("/\s+/", $datum);
			for($i = 0; $i < count($values); $i++){

				// Appends the excess to the job header
				if(isset($headers[$i]))
					$temp[$headers[$i]] = $values[$i];
				else
					$temp[$headers[count($headers)-1]] .= " " . $values[$i];

			}
			$connections[] = $temp;
		}

	    return $connections;
	}

	private function detectSystem(){
		$operating_systems = array('darwin', 'linux', 'win');
		$uname = strtolower(php_uname()); // get system information
		$system = '';

		foreach($operating_systems as $operating_system){
			// find a certain OS identifier
			if(strpos($uname, $operating_system) !== false){
				$system = $operating_system;
				break;
			}
		}

		return ($system) ? ucfirst($system) : 'Unkown';
	}

	private function getConnectionHeaders(){
		$headers = array();
		$exec = shell_exec('w');
		
		$row_headers = explode("\n", $exec);
		$headers = preg_split("/\s+/", $row_headers[1]); // explode by indefinite amount of whitespaces

		return $headers;	
	}

}

SSHNotifier::getInstance()->execute();
