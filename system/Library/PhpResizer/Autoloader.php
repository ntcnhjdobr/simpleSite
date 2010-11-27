<?php
/**
 * @version $Revision: 33 $
 * @category PhpResizer
 * @package PhpResizer
 * @author $Author: ktotut83@gmail.com $ $Date: 2010-11-14 23:05:45 +0200 (Вс, 14 ноя 2010) $
 * @license New BSD license
 * @copyright http://phpresizer.org/
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