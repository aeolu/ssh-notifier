
<?php

include_once dirname(__FILE__) . '/config.php';
include_once dirname(__FILE__) . '/system.php';
include_once dirname(__FILE__) . '/benchmark.php';

class SSHNotifier{

	private static $instance;
	private $pid;
	private $status;
	private $connection_counters = array(
		'started' 	=> 	0,
		'finished' 	=>	0
	);
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
		System::detectSystem();

		//Notify the user
		System::notify("SSH Notifier started", "To kill: kill {$this->pid}");

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
					$this->connection_counters['started']++;
				}else{
					$head = "SSH connection finished";
					$difference = array_values(array_diff_assoc($this->ssh['current'], $this->ssh['update']));
					$this->connection_counters['finished']++;
				}
		
				$difference = $difference[0];
				echo print_r($this->connection_counters, true);			
				// create the message for the notification
				$message = "{$difference['USER']}@{$difference['FROM']} [{$difference['TTY']}]";
				System::notify($head, $message);

				unset($difference);
				// Update persisent information
				$connection_count = $current_count;
				$this->ssh['current'] = $this->ssh['update'];
			}

			Benchmark::getInstance()->execute(RUN_BENCHMARK, $this->connection_counters);
			sleep(INTERVAL);
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

	private function getConnectionHeaders(){
		$headers = array();
		$exec = shell_exec('w');
		
		$row_headers = explode("\n", $exec);
		$headers = preg_split("/\s+/", $row_headers[1]); // explode by indefinite amount of whitespaces

		return $headers;	
	}

}

SSHNotifier::getInstance()->execute();
