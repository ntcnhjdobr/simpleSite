<?php
/**
 * @version $Revision$
 * @category PhpResizer
 * @package PhpResizer
 * @subpackage Engine
 * @author $Author$ $Date$
 * @license New BSD license
 * @copyright http://phpresizer.org/
 */

/**
 *
 */
abstract class PhpResizer_Engine_EngineAbstract
{
	
	const EXC_BAD_PARAM ='param %s is bad';
	const EXC_ENGINE_IS_NOT_AVALIBLE ='engine %s is not avalible';
    /**
     * @var array
     */
    protected $params = array();

    /**
     * @var int
     */
    private $maxHeight = 1500;

    /**
     * @var int
     */
    private $maxWidth = 1500;

    /**
     * @var int
     */
    private $_defaultCropSize = 100;

    /**
     * @var array
     */
    protected $types = array();

    /**
     *
     */
    public function __construct()
    {
        $this->_checkEngine();
    }

    /**
     * Merge params and check 
     * @param array $params
     * @throws PhpResizer_Exception_Basic
     */
    protected function getParams(array $inputParams)
    {
        $defaultOptions=array(
            'width' => $inputParams['size'][0],
            'height' => $inputParams['size'][1],
            'aspect' => true,
            'crop' => 100,
            'size' => null, //array, result working function getimagesize()
            'cacheFile' => null,
            'path' => null
        );
        $this->params = array_merge($defaultOptions, $inputParams);
        $this->params['crop'] = (int)$this->params['crop'];
        $this->params['width'] = (int)$this->params['width'];
        $this->params['height'] = (int)$this->params['height'];
        $this->params['aspect'] = (bool)$this->params['aspect'];

        $this->_checkParams();
    }

    /**
     * @throws PhpResizer_PhpResizerException
     */
    protected function _checkParams()
    {
        if ($this->params['width'] < 1 
            || $this->maxWidth < $this->params['width'])
        {
            $this->params['width'] = $this->maxWidth;
        }

        if ($this->params['height'] < 1 
            || $this->maxHeight < $this->params['height'])
        {
            $this->params['height'] = $this->maxHeight;
        }

        if ($this->params['crop'] <= 0  
            || $this->_defaultCropSize < $this->params['crop'])
        {
            $this->params['crop'] = $this->_defaultCropSize;
        }

        if (!is_string($this->params['path'])) {
            throw new PhpResizer_Exception_Basic(sprintf(self::EXC_BAD_PARAM,'path'));
        }

        if (!$this->params['cacheFile']
            || !is_string($this->params['cacheFile']))
        {
            throw new PhpResizer_Exception_Basic(sprintf(self::EXC_BAD_PARAM,'cacheFile'));
        }

        if (!$this->params['size']
            ||!is_array($this->params['size']))
        {
            throw new PhpResizer_Exception_Basic(sprintf(self::EXC_BAD_PARAM,'size'));
        }

        $ext = strtolower(substr($this->params['path'], -3));

        if (!in_array($ext, $this->types)) {
            throw new PhpResizer_Exception_IncorrectExtension('extension  '.$ext.' is not allowed');
        }
    }

    /**
     * @return void
     * @throws PhpResizer_Exception_Basic
     */
    abstract protected function _checkEngine();

    /**
     *
     * @return array
     */
    protected function calculateParams()
    {
        extract($this->params);

        $srcX = 0; $srcY = 0;

        if ($aspect and $aspect!="0") {
            if (($size[1]/$height) > ($size[0]/$width)) {
                $width = ceil(($size[0]/$size[1]) * $height);
                $height = $height;

            } else {
                $height = ceil($width / ($size[0]/$size[1]));
                $width = $width;
            }

        } else {
           if (($height/$width) <= ($size[1]/$size[0])) {
                $temp=$height*($size[0]/$width);
                   $srcY=ceil(($size[1]-$temp)/2);
                $size[1]=ceil($temp);
           } else {
                $temp=$width*($size[1]/$height);
                   $srcX=ceil(($size[0]-$temp)/2);
                $size[0]=ceil($temp);
           }
        }

        if (100 != $crop) {
            $crop = $this->params['crop'];
            $srcX += ceil((100-$crop)/200*$size[0]);
            $srcY += ceil((100-$crop)/200*$size[1]);
            $size[0] = ceil($size[0]*$crop/100);
            $size[1] = ceil($size[1]*$crop/100);
        }

        return array(
            'srcX' => $srcX,
            'srcY' => $srcY,
            'srcWidth' => $size[0],
            'srcHeight' => $size[1],
            'dstX' => 0,
            'dstY' => 0,
            'dstWidth' => $width,
            'dstHeight' => $height,
        );
    }

    /**
     * @return boolean
     */
    abstract public function resize ();
}