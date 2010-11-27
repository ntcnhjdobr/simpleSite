<?php
/**
 * @version $Revision: 41 $
 * @category PhpResizer
 * @package PhpResizer
 * @subpackage Engine
 * @author $Author: ktotut83@gmail.com $ $Date: 2010-11-17 21:58:08 +0200 (Ср, 17 ноя 2010) $
 * @license New BSD license
 * @copyright http://phpresizer.org/
 */

/**
 *
 */
class PhpResizer_Engine_GD2 extends PhpResizer_Engine_EngineAbstract  
{
    protected $types=array(1 => "gif", "jpeg","png","jpg","tif");

    protected function _checkEngine () {
        if (!extension_loaded('gd')) {
            throw new PhpResizer_Exception_Basic(
            	sprintf(self::EXC_ENGINE_IS_NOT_AVALIBLE,
            	PhpResizer_PhpResizer::ENGINE_GD2));
        }
    }

    public function resize  (array $params=array()) {
        $this->getParams($params);
        $size = $this->params['size'];
        $path = $this->params['path'];
        $cacheFile = $this->params['cacheFile'];

        extract($this->calculateParams());

        $image = call_user_func('imagecreatefrom' . $this->types[$size[2]], $path);

        if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor ($dstWidth, $dstHeight))) {
			if(($size[2] == 1) OR ($size[2] == 3)){
            	imagealphablending($temp, false);
                imagesavealpha($temp, true);
                $transparent = imagecolorallocatealpha($image, 255, 255, 255, 127);
                imagefilledrectangle($temp, $dstX, $dstY, $dstWidth, $dstHeight, $transparent);
			}
         	imagecopyresampled ($temp, $image, $dstX, $dstY, $srcX, $srcY, $dstWidth, $dstHeight, $srcWidth, $srcHeight);
        } else {
			$temp = imagecreate ($dstWidth, $dstHeight);
            imagecopyresized ($temp, $image, $dstX, $dstY, $srcX, $srcY, $dstWidth, $dstHeight, $srcWidth, $srcHeight);
        }

        call_user_func("image" . $this->types[$size[2]], $temp, $cacheFile);
        imagedestroy($image);
        imagedestroy($temp);
        return true;
    }
}