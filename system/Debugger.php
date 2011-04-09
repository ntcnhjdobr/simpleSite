<?php
class Debugger {
	
	static private $instance = null; 
	
	private $isDisabled = true;
	
	private $debug = array(
		'timer'=>array(),
		'memory'=>array(),
		'sql'=>array()
	);
	
	const START_APP = 'от начала до конца';
		
	private function __construct ($params) {
		$this->isDisabled = !(bool) $params['enabled'];
		$this->timerStart(self::START_APP);
		$this->memoryStart(self::START_APP);
	}
	
	/**
	 * 
	 * singletone pattern
	 * @param array
	 * @return Debugger instance  
	 */
	static public function getInstance (array $params=array()) {
		if(!self::$instance){
			self::$instance = new self($params);
		}
		return self::$instance;
	}

	public static function addDebugInfo($info) {
		if ($this->isDisabled()){return;}
		$this->debug[]=	$info;
	}
	
	/**
	 * 
	 * render DebugInfo
	 * @return string
	 */
	public function render() {
		if ($this->isDisabled()){return;}
		$this->isDisabled = true;
		
		$this->timerEnd(self::START_APP);
		$this->memoryEnd(self::START_APP);

		$output = '';
		
		//Timer
		$output.='<h4>Timer</h4>';
		foreach ($this->debug['timer'] as $timer) {
			$output.=$timer.'<br/>';
		}

		//SQL
		$output.='<h4>SQL</h4>';
		
		$output.='<table>';
		foreach ($this->debug['sql'] as $sql) {
			$output.=sprintf('<tr><td>%s</td><td>%d</td><td>%.2f</td></tr>', $sql[0], $sql[1], $sql[2]);
		}
		$output.='</table>';

		//Memory
		$output.= '<h4>Memory</h4>';
		$output.= 'Пик использования памяти: '.round((memory_get_peak_usage()/1000),0).' Кб<br/>';
		foreach ($this->debug['memory'] as $memory) {
			$output.=$memory.'<br/>';
		}
		return $output;
	}


	/**
	 * Add SQL
	 * @param string $key
	 */
	public function addSql ($sql) {
    	if ($this->isDisabled()){return;}
        $this->debug['sql'][]=$sql;
    }
    
    
	/**
	 * Start test memory for key
	 * @param string $key
	 */
	public function memoryStart ($key) {
    	if ($this->isDisabled()){return;}
        $memory = memory_get_usage();
        $this->debug['memory'][$key]=$memory;
    }
    
    /**
	 * End test memory for key
	 * @param string $key
	 */
 	public function memoryEnd ($key) {
    	$this->isDisabled();
        if (!isset($this->debug['memory'][$key]))  {
            return;
        }
        
        $start = $this->debug['memory'][$key];
        $end = memory_get_usage();

        $result = $end - $start;
        if ($result >= 1000000) {
        	$return = round($result/1000000,1).' Мб';
        }elseif ($result >= 1000) {
        	$return = round($result/1000,0).' Кб';
        }else{
            $return = $result.' байт';
 		}
        
        $this->debug['memory'][$key]=$key.': '.$return;
     }
     
	
	
	
			
 	/**
	 * Start test Time for key
	 * @param string $key
	 */
    public function timerStart ($key) {
    	if ($this->isDisabled()){return;}
        $time = $this->getCurrTime();
        $this->debug['timer'][$key]=$time;
    }

     /**
	 * End test Time for key
	 * @param string $key
	 */
    public function timerEnd ($key, $addStack = true) {
    	$this->isDisabled();
    	
        if (!isset($this->debug['timer'][$key]))  {
            return;
        }

        $start = $this->debug['timer'][$key];
        $end = $this->getCurrTime();

        $s = $end[1]-$start[1];
        $m = $end[0]-$start[0];
        $return = round(($s + $m)*1000,3);
        
        if ($addStack) {
        	$this->debug['timer'][$key] = $key.': '.$return.' ms';
        }else{
        	unset($this->debug['timer'][$key]);
        }
        
        return $return;
     }
     
    private function getCurrTime () {
        return explode(' ',microtime());
    }
	
    private function isDisabled() {
    	if ($this->isDisabled) {
    		return true;
    	}
    	return false;
    }
}