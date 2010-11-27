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
 *
 */
class PhpResizer_Engine_ImageMagic extends PhpResizer_Engine_EngineAbstract  {

    protected $types=array(1 => "gif", "png","jpg","bmp","tif");

    // linux command to ImageMagick convert
    private $convertPath='convert';

    protected function _checkEngine () {
        $command = $this->convertPath.' -version';
       
        exec($command, $stringOutput);

        if (false === strpos($stringOutput[0],'ImageMagick')) {
            throw new PhpResizer_Exception_Basic(
            	sprintf(self::EXC_ENGINE_IS_NOT_AVALIBLE,
            	PhpResizer_PhpResizer::ENGINE_IMAGEMAGICK));
        }
    }

    public function resize  (array $params=array()) {
        $this->getParams($params);
        $size = $this->params['size'];
        $path = $this->params['path'];
        $cacheFile = $this->params['cacheFile'];
        
        extract($this->calculateParams());
        
             $command = $this->convertPath
                 . ' ' . escapeshellcmd($path) . ' -crop'
                 . ' ' . $srcWidth.'x'.$srcHeight . '+' . $srcX . '+' . $srcY
                 . ' -resize ' . $dstWidth . 'x' . $dstHeight
                 .' -sharpen 1x10'
                 //.' -colorspace GRAY'
                //.' -posterize 32'
                //.' -depth 8'
                //.' -contrast'
                //.' -equalize'
                //.' -normalize'
                //.' -gamma 1.2'
                 . ' -quality 85'
                 //.' -blur 2x4'
                 //.' -unsharp 0.2x0+300+0'
                //.' -font arial.ttf -fill white -box "#000000100" -pointsize 12 -annotate +0+10 "  '.$path.' "'
                //.' -charcoal 2'
                //.' -colorize 180'
                //.' -implode 4'
                //.' -solarize 10' ???
                //.' -spread 5'
                 . ' ' . escapeshellcmd($cacheFile);

			exec($command);
            return true;
    }
}
