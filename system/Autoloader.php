<?php
class Autoloader {

	/**
	 * @var array
	 */
	private $_includePaths;
	
	/**
	 * Register autoloader in autoloader stack 
	 */
    public function __construct()
    {
        $this->_includePaths = array(
	        SYSTEM_PATH,
	        APP_PATH
        );
        spl_autoload_register(array($this, 'autoload'));
    }
	
    /**
     * 
     * resolve class name to filename
     * @param $class
     */
	public function autoload ($class) 
	{
		$file = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
        foreach ($this->_includePaths as $path) {
        	$filename = $path . DIRECTORY_SEPARATOR . $file;
        	if(is_readable($filename)){
        		include $filename;
        		break;	
        	}
        }
	
		if (class_exists($class)) {
			return;
		};
		
		eval("class $class {
            function __construct() {
                throw new AbstractException('Class $class not found');
            }
        }");
	}
}