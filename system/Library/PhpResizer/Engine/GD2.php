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
 */
class PhpResizer_Engine_GD2 
	extends PhpResizer_Engine_EngineAbstract  
	implements PhpResizer_Engine_Interface
{
    protected $types=array(
    	IMAGETYPE_GIF => 'gif',
    	IMAGETYPE_JPEG => 'jpeg',    	
    	IMAGETYPE_PNG => 'png',
    	1000 => 'jpg');

    public function checkEngine () {
        if (!extension_loaded('gd')) {
            throw new PhpResizer_Exception_Basic(
            	sprintf(self::EXC_ENGINE_IS_NOT_AVALIBLE,
            		PhpResizer_PhpResizer::ENGINE_GD2));
        }
    }
    
    public function resize  (array $params=array()) {

        $calculateParams = $this->calculator->checkAndCalculateParams($params);
        extract($calculateParams);
        
    	$this->checkExtOutputFormat($params);        
        $path = $params['path'];
        $cacheFile = $params['cacheFile'];
        
		$srcImageType = $srcGetImageSize[2];
        $image = call_user_func('imagecreatefrom' . $this->types[$srcImageType], $path);        

        
        if($background){
        	$temp = imagecreatetruecolor ($width, $height);
        	$dstX = (int) ceil($width - $dstWidth)/2; 
        	$dstY = (int) ceil($height - $dstHeight)/2;
        }else{
        	$temp = imagecreatetruecolor ($dstWidth, $dstHeight);
        }
        

        // save transparent
		if($srcImageType == IMAGETYPE_PNG){			
            imagealphablending($temp, false);
			imagesavealpha($temp, true);
			$transparent = imagecolorallocatealpha($image, 255, 255, 255, 127);
			imagefilledrectangle($temp, $dstX, $dstY, $dstWidth, $dstHeight, $transparent);
		}
		
		
		if ($background){
			imagefill($temp, 0, 0, intval($background, 16));
		}
		
		imagecopyresampled ($temp, $image, $dstX, $dstY, $srcX, $srcY, $dstWidth, $dstHeight, $srcWidth, $srcHeight);
		imagedestroy($image);

    	if ($srcImageType === IMAGETYPE_JPEG) {
        	imagejpeg($temp, $cacheFile, $quality);
    	}elseif ($srcImageType === IMAGETYPE_PNG) {	
    		//calculate compression for png		
    		$pngQuality = ($quality - 100) / (100/9);
			$pngQuality = round(abs($pngQuality));			    		
        	imagepng($temp, $cacheFile, $pngQuality);
    	}else{
    		imagegif($temp, $cacheFile);    		
    	}
        
        imagedestroy($temp);
        return true;
    }
}