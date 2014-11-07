<?php
/**
 * @link https://github.com/gromver/yii2-widgets#readme
 * @copyright Copyright (c) Gayazov Roman, 2014
 * @license https://github.com/gromver/yii2-widgets/blob/master/LICENSE
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace gromver\widgets;


use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class ModalIFrameAsset
 * @package yii2-widgets
 * @author Gayazov Roman <gromver5@gmail.com>
 */
class ModalIFrameAsset extends AssetBundle {
    public $sourcePath = '@gromver/widgets/assets';
    public $js = [
        'js/iframe.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END
    ];
}