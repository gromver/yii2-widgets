<?php
/**
 * @link https://github.com/gromver/yii2-widgets#readme
 * @copyright Copyright (c) Gayazov Roman, 2014
 * @license https://github.com/gromver/yii2-widgets/blob/master/LICENSE
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace gromver\widgets;


use yii\helpers\Html;
use Yii;

/**
 * Class Popup
 *
 *  Popup::begin([
 *      'label' => 'open popup',
 *      'options' => ['class' => 'btn btn-default'],
 *      'popupOptions' => ['width' => '400', 'modal' => true]
 *  ]);
 *
 *  echo 'Popup content here';
 *
 *  Popup::end();
 *
 * @package yii2-widgets
 * @author Gayazov Roman <gromver5@gmail.com>
 */
class Popup extends \yii\base\Widget
{
    public $options;
    public $label = 'Show';
    /**
     * @var array
     *  - width
     *  - height
     *  - class
     *  - style
     */
    public $popupOptions = [];

    public function init()
    {
        $this->options['id'] = $this->getId();
        $this->options['data']['behavior'] = 'grom-popup';
        Html::addCssClass($this->options, 'btn-popup');

        if (is_array($this->popupOptions) && !empty($this->popupOptions)) {
            $this->options['data']['popup'] = $this->popupOptions;
        }

        echo Html::beginTag('span', $this->options);
        echo $this->label;

        echo Html::beginTag('div', ['class' => 'btn-popup_content', 'style' => 'display: none']);
    }

    public function run()
    {
        echo Html::endTag('div');
        echo Html::endTag('span');

        $this->getView()->registerAssetBundle(PopupAsset::className());
    }
}