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
class PhpResizer_Engine_GraphicsMagick extends PhpResizer_Engine_EngineAbstract  {

    protected $types=array(1 => "gif", "png","jpg","bmp","tif");

    // linux command to GraphicksMagick
    private $gmPath='gm';

    protected function _checkEngine () {
        $command = $this->gmPath.' version';
        
        exec($command, $stringOutput);

        if (false === strpos($stringOutput[0],'GraphicsMagick')) {
			throw new PhpResizer_Exception_Basic(
            	sprintf(self::EXC_ENGINE_IS_NOT_AVALIBLE,
            	PhpResizer_PhpResizer::ENGINE_GRAPHIKSMAGICK));
        }
    }

    public function resize  (array $params=array()) {
        $this->getParams($params);

        $size = $this->params['size'];
        $path = $this->params['path'];
        $cacheFile = $this->params['cacheFile'];

        extract($this->calculateParams());
        
             $command = $this->gmPath.' convert'
                 . ' ' . escapeshellcmd($path) . ' -crop'
                 . ' ' . $srcWidth . 'x' . $srcHeight . '+' . $srcX . '+' . $srcY
                 . ' -resize ' . $dstWidth . 'x' . $dstHeight
                 . ' -sharpen 1x10'
                 . ' -quality 75'
                 . ' ' . escapeshellcmd($cacheFile);

            exec($command);
        return true;
    }
}
