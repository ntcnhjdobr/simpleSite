<?php
class PhpResizer_Calculator_Calculator 
	implements PhpResizer_Calculator_Interface
{

    /**
     * @var int
     */
    const DEFAULT_CROP = 100;
    const DEFAULT_ASPECT = true;
    const DEFAULT_QUALITY = 85;		

	/**
     * @var int
     */
    private $maxAvalibleWidth = 1500;
    
    /**
     * @var int
     */
    private $maxAvalibleHeight = 1500;
    
    
    public function checkAndCalculateParams (array $inputParams) {
        $defaultOptions=array(
            'width' => $inputParams['size'][0],
            'height' => $inputParams['size'][1],
            'aspect' => self::DEFAULT_ASPECT,
            'crop' => self::DEFAULT_CROP,
        	'quality' => self::DEFAULT_QUALITY,
            'size' => null, //array, result working function getimagesize()
            'cacheFile' => null,
            'path' => null,
        	'background'=> null
        );
        $this->params = array_merge($defaultOptions, $inputParams);
        
        $this->params['crop'] = (int)$this->params['crop'];
        $this->params['width'] = (int)$this->params['width'];
        $this->params['height'] = (int)$this->params['height'];
        $this->params['aspect'] = (bool)$this->params['aspect'];

        $this->_checkParams();
        
        return $this->_calculateParams();
    }

    /**
     * @throws PhpResizer_PhpResizerException
     */
    protected function _checkParams()
    {
        if ($this->params['width'] < 1
            || $this->params['width'] > $this->maxAvalibleWidth)
        {
            $this->params['width'] = $this->maxAvalibleWidth;
        }

        if ($this->params['height'] < 1
            ||  $this->params['height'] > $this->maxAvalibleHeight)
        {
            $this->params['height'] = $this->maxAvalibleHeight;
        }

        if ($this->params['crop'] <= 0
            || $this->params['crop'] > 100)
        {
            $this->params['crop'] = self::DEFAULT_CROP;
        }

        if (!$this->params['size']
            ||!is_array($this->params['size']))
        {
            throw new PhpResizer_Exception_Basic(sprintf(self::EXC_BAD_PARAM, 'size'));
        }
        
        if($this->params['background']) {		
        /*
         * 
         */
        }
        
		if($this->params['quality'] < 1 || $this->params['quality'] > 100) {		
        	$this->params['quality'] = self::DEFAULT_QUALITY;
        }
    }

    private function _calculateParams()
    {
        extract($this->params);

        $srcX = 0; $srcY = 0;

        if ($aspect) {
            if (($size[1]/$height) > ($size[0]/$width)) {
                $dstWidth = ceil(($size[0]/$size[1]) * $height);
                $dstHeight = $height;
            } else {
                $dstHeight = ceil($width / ($size[0]/$size[1]));
                $dstWidth = $width;
            }
        } else {
			$dstHeight = $height;
			$dstWidth = $width;
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
        	'srcGetImageSize'=> $size,
        	'width' => (int) $width,
        	'height' => (int) $height,
            'srcX' => (int) $srcX,
            'srcY' => (int) $srcY,
            'srcWidth' => (int) $size[0],
            'srcHeight' => (int) $size[1],
            'dstX' => 0,
            'dstY' => 0,
            'dstWidth' => (int) $dstWidth,
            'dstHeight' => (int) $dstHeight,
        	'background'=> $background,
        	'quality' => $quality
        );
    }
}