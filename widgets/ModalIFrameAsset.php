<?php
/**
 * @link https://github.com/gromver/yii2-widgets#readme
 * @copyright Copyright (c) Gayazov Roman, 2014
 * @license https://github.com/gromver/yii2-widgets/blob/master/LICENSE
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace gromver\widgets;


/**
 * Class ModalIFrameAsset
 * @package yii2-widgets
 * @author Gayazov Roman <gromver5@gmail.com>
 */
class ModalIFrameAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@gromver/widgets/assets/modal-iframe';
    public $js = [
        'js/jquery.browser.js',
        'js/jquery.iframe-auto-height.js',
        'js/iframe.js',
    ];

    public $depends = [
        '\yii\web\YiiAsset',
        '\gromver\widgets\PopupAsset'
    ];
}