<?php
/**
 * @version $Revision: 62 $
 * @category PhpResizer
 * @package PhpResizer
 * @author $Author: ktotut83@gmail.com $ $Date: 2011-04-20 21:58:21 +0300 (Срд, 20 Апр 2011) $
 * @license New BSD license
 * @copyright http://code.google.com/p/phpresizer/
 */

/**
 *
 */
class PhpResizer_Autoloader
{
    /**
     * @var string
     */
    private $_includePath;

    /**
     * Register autoloader in autoloader stack
     */
    public function __construct()
    {
        $this->_includePath = realpath(dirname(__FILE__) . '/../');
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * Resolve class name to file name.
     *
     * @param string $class
     */
    public function autoload($class)
    {
        $file = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
        $filename = $this->_includePath . DIRECTORY_SEPARATOR . $file;
        if (is_readable($filename)) {
            include $filename;
        }
    }
}