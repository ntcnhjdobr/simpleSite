<?php
/**
 * @version $Revision: 67 $
 * @category PhpResizer
 * @package PhpResizer
 * @subpackage Engine
 * @author $Author: ktotut83@gmail.com $ $Date: 2011-05-02 08:28:36 -0500 (Mon, 02 May 2011) $
 * @license New BSD license
 * @copyright http://code.google.com/p/phpresizer/
 */

/**
 *
 *
 */
class PhpResizer_Engine_ImageMagic 	
	extends PhpResizer_Engine_EngineAbstract 
	implements PhpResizer_Engine_Interface 
{ 
	   	
    protected $types=array(IMAGETYPE_GIF => 'gif', 
	    IMAGETYPE_JPEG=>'jpeg',
	    IMAGETYPE_PNG=>'png', 
	    1000 => 'jpg', 
	    'bmp', 
	    'tif',  
	    'tiff');

    // linux command to ImageMagick convert
    private $convertPath='convert';

    public function checkEngine () {
        $command = $this->convertPath.' -version';
       
        exec($command, $stringOutput);

        if (false === strpos($stringOutput[0],'ImageMagick')) {
            throw new PhpResizer_Exception_Basic(
            	sprintf(self::EXC_ENGINE_IS_NOT_AVALIBLE,
            	PhpResizer_PhpResizer::ENGINE_IMAGEMAGICK));
        }
    }

    public function resize  (array $params=array()) {

    	$calculateParams = $this->calculator->checkAndCalculateParams($params);
        extract($calculateParams);
        
    	$this->checkExtOutputFormat($params);        
        $path = $params['path'];
        $cacheFile = $params['cacheFile'];

        
        $oldLocale = setlocale(LC_CTYPE, null);
        // need for use russian symbols in path (escapeshellarg)
        setlocale(LC_CTYPE, "en_US.UTF-8"); 
        
		$command = $this->convertPath
        	. ' ' . escapeshellarg($path) . ' -crop'
            . ' ' . $srcWidth.'x'.$srcHeight . '+' . $srcX . '+' . $srcY
            . ' -resize ' . $dstWidth . 'x' . $dstHeight
            . ' -sharpen 1x10'
            //.' -colorspace GRAY'
            //.' -posterize 32'
            //.' -depth 8'
            //.' -contrast'
            //.' -equalize'
            //.' -normalize'
            //.' -gamma 1.2'
            . ' -quality '.$quality
            //.' -blur 2x4'
            //.' -unsharp 0.2x0+300+0'
            //.' -font arial.ttf -fill white -box "#000000100" -pointsize 12 -annotate +0+10 "  '.$path.' "'
            //.' -charcoal 2'
            //.' -colorize 180'
            //.' -implode 4'
            //.' -solarize 10' ???
            //.' -spread 5'
            ;
			if ($background) {
				$command .= '  -background "#'.$background.'" -gravity center -extent '.$width.'x'.$height;              	
			}
            $command .= ' ' . escapeshellarg($cacheFile);
			setlocale(LC_CTYPE, $oldLocale);
			exec($command);
            return true;
    }
}
