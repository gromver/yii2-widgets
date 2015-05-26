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
 * Парсер и модификатор урлов на базе https://github.com/medialize/URI.js
 * Class ParseUrlAsset
 * @package yii2-widgets
 * @author Gayazov Roman <gromver5@gmail.com>
 */
class ParseUrlAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@gromver/widgets/assets/modal-iframe';
    public $js = [
        'js/URI.min.js',
    ];
}