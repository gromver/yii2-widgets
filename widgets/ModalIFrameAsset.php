<?php
/**
 * @link https://github.com/menst/yii2-widgets#readme
 * @copyright Copyright (c) Gayazov Roman, 2014
 * @license https://github.com/menst/yii2-widgets/blob/master/LICENSE
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace menst\widgets;


use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class ModalIFrameAsset
 * @package yii2-widgets
 * @author Gayazov Roman <m.e.n.s.t@yandex.ru>
 */
class ModalIFrameAsset extends AssetBundle {
    public $sourcePath = '@menst/widgets/assets';
    public $js = [
        'js/iframe.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END
    ];
}