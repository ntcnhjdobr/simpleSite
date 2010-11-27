<?php
/**
 * @version $Revision$
 * @category PhpResizer
 * @package PhpResizer
 * @author $Author$ $Date$
 * @license New BSD license
 * @copyright http://phpresizer.org/
 */

/**
 *
 */
class PhpResizer_PhpResizer {

    const ENGINE_GD2 = 'GD2';
    const ENGINE_IMAGEMAGICK = 'ImageMagic';
    const ENGINE_GRAPHIKSMAGICK = 'GraphicsMagick';

    const EXC_TMPDIR_NOT_EXISTS = 'Path "%s" is not exists or not writtable';
    const EXC_CACHEDIR_NOT_EXISTS =
        'Path "%s" is not exists or not writtable or not executable';
    const EXC_FILE_CRASHED = 'File "%s" is crashed';
    const EXC_ENABLE_CACHE =
        'For "returnOnlyPath" option set "cache" options as TRUE';

    /**
     * Default cache image time to live in minutes
     *
     * @var int
     */
    const DEFAULT_CACHE_TTL = 10080;

    /**
     * @var bool
     */
    protected $_returnOnlyPath = false;

    /**
     * @var bool
     */
    protected $_checkEtag;

    /**
     * @var PhpResizer_Engine_EngineAbstract
     */
    protected $_engine;

    /**
     * @var string
     */
    protected $_cacheDir;

    /**
     * @var string
     */
    protected $_tmpDir;

    /**
     * @var bool
     */
    protected $_useCache = false;

    /**
     * @var bool
     */
    protected $_cacheBrowser = false;

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $config = array_merge(array (
            'engine' => self::ENGINE_GD2,
            'cache' => true,
            'cacheBrowser' => true,
            'cacheDir' => '/tmp/resizerCache/',
            'tmpDir' => '/tmp/'
        ), $options);

        $this->_useCache = (bool)$config['cache'];
        $this->_tmpDir = $config['tmpDir'];
        $this->_cacheDir = $config['cacheDir'];
        $this->_cacheBrowser = (bool)$config['cacheBrowser'];

        $this->_validateTmpDir();
        if ($this->_useCache) {
            $this->_validateCacheDir();
        }

        $this->_engine = $this->_createEngine($config['engine']);
    }

    /**
     * @param string $name
     * @return PhpResizer_Engine_EngineAbstract
     */
    protected function _createEngine($name)
    {
        $class = 'PhpResizer_Engine_' . $name;
        $engine = new $class();
        return $engine;
    }

    /**
     * @throws PhpResizer_Exception_Basic
     */
    protected function _validateTmpDir()
    {
        if (!is_writable($this->_tmpDir)) {
            $message = sprintf(self::EXC_TMPDIR_NOT_EXISTS, $this->_tmpDir);
            throw new PhpResizer_Exception_Basic($message);
        }
    }

    /**
     * @throws PhpResizer_Exception_Basic
     */
    protected function _validateCacheDir()
    {
        $dir = $this->_cacheDir;
        if (!is_writable($dir) || !is_executable($dir)) {
            $message = sprintf(self::EXC_CACHEDIR_NOT_EXISTS, $dir);
            throw new PhpResizer_Exception_Basic($message);
        }
    }

    /**
     *
     * @param string $filename
     * @param array $options
     * @throws PhpResizer_Exception_Basic
     */
    public function resize($filename, array $options = array(),$returnOnlyPath = false)
    {
    	$this->_options = $options;
    	$this->_returnOnlyPath = (bool) $returnOnlyPath;
    	
        if ($this->_returnOnlyPath && !$this->_useCache)
        {
            throw new PhpResizer_Exception_Basic(self::EXC_ENABLE_CACHE);
        } 
        
        if (!is_readable($filename)) {
            return $this->_return404();

        } else if (false === ($size = @getimagesize($filename))) {
            $message = sprintf(self::EXC_FILE_CRASHED, $filename);
            throw new PhpResizer_Exception_Basic($message);
        }

        if (!$this->_options) {
            $this->_returnImageOrPath($filename);
        }

        $this->_options += array(
            'path' => $filename,
			'cacheFile' => $this->_getCacheFileName($filename),
            'size' => $size
        );

        if (!$this->_engine->resize($this->_options)) {
            $this->_return404();
        }

		return $this->_returnImageOrPath($this->_options['cacheFile']);
    }

    /**
     * generete CacheFileName and if cacheFile is exist and valid - return image
     * else return path to uncreated newcacheFile
     *
     * @param $path
     * @param $options
     * @return string
     */
    protected function _getCacheFileName ($path)
    {
        $cacheFile = null;
        $options = $this->_options;
        
        if ($this->_useCache) {
        	
            $cacheFile = $this->generatePath($path);
            
            if (file_exists($cacheFile) && getimagesize($cacheFile) &&
                filemtime($cacheFile)>=filemtime($path)) {
                	return $this->_returnImageOrPath($cacheFile);

            } else if (file_exists($cacheFile)) {
                unlink($cacheFile);
            }

        } else {
            $cacheFile = $this->_tmpDir . '/imageResizerTmpFile_'
                . uniqid() . '.' . $this->getExtension($path);
        }

        return $cacheFile;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getExtension($filename)
    {
        $allowedExtenstions = array('png');
        $defaultExtension = 'jpg';
        $ext = strtolower(substr($filename,-3));

        if (in_array($ext, $allowedExtenstions)) {
            return $ext;

        } else {
            return $defaultExtension;
        }
    }

    /**
     * @param string $path
     * @param array $options
     * @return string
     */
    protected function generatePath($path)
    {
        $hash = md5(serialize($this->_options).$path);
        $cacheFilePath = $this->_cacheDir . '/' . substr($hash, 0,1)
            . '/' . substr($hash, 1, 1) . '/' . substr($hash, 2) . '.'
            . $this->getExtension($path);


        if (!is_dir(dirname($cacheFilePath))){
            mkdir(dirname($cacheFilePath),0777,true);
        }

        return $cacheFilePath;
    }

    /**
     * @param string $filename absolute path to image-file
     */
    protected function _returnImageOrPath($filename)
    {
   	
        if ($this->_returnOnlyPath) {
            return $filename;
        }

        if ($this->_checkEtag($filename)) {
            header('HTTP/1.1 304 Not Modified');

        } else {
            header('Content-type: image/jpeg');
            header('Content-Length: ' . filesize($filename));
            header('ETag: ' . md5_file($filename));
            readfile($filename);
        }

		if (!$this->_useCache){
            unlink($filename);
		}
        exit;
    }

    /**
     * Send 404 HTTP code
     */
    protected function _return404()
    {
        header('HTTP/1.1 404 Not Found');
        exit;
    }

    /**
     * @param string $filename absolute path to image-file
     * @return boolean
     */
    protected function _checkEtag($filename)
    {
        if (!$this->_cacheBrowser) {
            return false;
        }
        if (isset($this->_checkEtag)) {
            return $this->_checkEtag;
        }

        if (isset($_SERVER['HTTP_IF_NONE_MATCH'])
            && md5_file($filename) == $_SERVER['HTTP_IF_NONE_MATCH'])
        {
            $_checkEtag = true;
            return true;
        }

        $this->_checkEtag = false;
        return false;
    }

    /**
     * @param int $ttl
     * @return array
     */
    public function clearCache($ttl = self::DEFAULT_CACHE_TTL)
    {
        $ttl = (int) $ttl;
        $dir = escapeshellcmd($this->_cacheDir);
        $command = "find {$dir} \! -type d -amin +{$ttl} -exec  rm -v '{}' ';'";
        exec($command, $stringOutput);
        return $stringOutput;
    }
}