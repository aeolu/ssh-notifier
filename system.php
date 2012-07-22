<?php

class System{

	private static $system;

	public static function notify($head, $message){
		echo self::$system . "\n";

        switch(self::$system){
            case 'darwin':
                shell_exec("growlnotify -m '$message' '$head'");
                break;
            case 'linux':
                shell_exec("notify-send '$head' '$message'");
                break;
        }

    }

	public static function detectSystem(){
        $operating_systems = array('darwin', 'linux', 'win');
        $uname = strtolower(php_uname()); // get system information

        foreach($operating_systems as $operating_system){
            // find a certain OS identifier
            if(strpos($uname, $operating_system) !== false){
                self::$system = $operating_system;
                break;
            }
        }

    }

}
