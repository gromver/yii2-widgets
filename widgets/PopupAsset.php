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
 * Class PopupAsset
 * @package yii2-widgets
 * @author Gayazov Roman <gromver5@gmail.com>
 */
class PopupAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@gromver/widgets/assets/popup';
    public $js = [
        //'js/jquery.popup.min.js'
        //'js/jquery.ba-postmessage.min.js',
        'js/my.popup.js',
    ];
    public $css = [
        'css/popup.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}