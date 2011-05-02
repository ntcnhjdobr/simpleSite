<?php
/**
 * @version $Revision: 66 $
 * @category PhpResizer
 * @package PhpResizer
 * @subpackage Engine
 * @author $Author: ktotut83@gmail.com $ $Date: 2011-05-02 04:05:19 -0500 (Mon, 02 May 2011) $
 * @license New BSD license
 * @copyright http://code.google.com/p/phpresizer/
 */

/**
 *
 */
abstract class PhpResizer_Engine_EngineAbstract
{
	
	const EXC_BAD_PARAM ='param %s is bad';
	const EXC_ENGINE_IS_NOT_AVALIBLE ='engine %s is not avalible';
	const EXC_EXTENSION_IS_NOT_AVALIBLE ='extension  %s is not allowed. Allowed: %s';
    
    /**
     * @var array
     */
    protected $types = array();

    public function checkExtOutputFormat($params){
    	
    	if (!is_string($params['path'])) {
            throw new PhpResizer_Exception_Basic(sprintf(self::EXC_BAD_PARAM,'path'));
        }

    	$ext = PhpResizer_PhpResizer::getExtension($params['path']);
        if (!in_array($ext, $this->types)) {
            throw new PhpResizer_Exception_IncorrectExtension(
            	sprintf(self::EXC_EXTENSION_IS_NOT_AVALIBLE, $ext, implode(',',$this->types)));
        }
        
        if (!$params['cacheFile']
            || !is_string($params['cacheFile']))
        {
            throw new PhpResizer_Exception_Basic(sprintf(self::EXC_BAD_PARAM,'cacheFile'));
        }
        
        
    	
    }
    
    public function __construct()
    {    	
    	$this->_setCalculator(new PhpResizer_Calculator_Calculator());
        $this->checkEngine();
    }
    
    private function _setCalculator (PhpResizer_Calculator_Interface $calculator){
    	$this->calculator = $calculator;
    }
}