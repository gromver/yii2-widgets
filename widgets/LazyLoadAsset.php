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
 * Class LazyLoadAsset
 * @package yii2-widgets
 */
class LazyLoadAsset extends AssetBundle {
    public $sourcePath = '@gromver/widgets/assets/lazy-load';
    public $js = [
        'dist/jquery.lazyloadxt.extra.min.js',
    ];
    public $css = [
        'dist/jquery.lazyloadxt.fadein.min.css',
        'dist/jquery.lazyloadxt.spinner.min.css',
    ];
    public $jsOptions = [
        'position' => View::POS_END
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
} 