<?php
/**
 * @link https://github.com/gromver/yii2-widgets#readme
 * @copyright Copyright (c) Gayazov Roman, 2014
 * @license https://github.com/gromver/yii2-widgets/blob/master/LICENSE
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace gromver\widgets;


use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use Yii;

/**
 * Class ModalIFrame
 * @package yii2-widgets
 * @author Gayazov Roman <gromver5@gmail.com>
 *
 * Замечен один баг - если в качестве кнопки использовать форму, то форма созданная через виджет ActiveForm работает криво, так как изза yii скриптов валидии
 * первое нажатие кнопки будет дважды обрабатыватся бутстрапом, тем самым сразу закрывая модальное окно, только после 2го сабмита виджет будет работь как предполагалось
 * поэтому надо использовать Html::beginForm() ... Html::endForm(), что впринципе и логично)
 */
class ModalIFrame extends \yii\base\Widget
{
    public $iframeOptions = [];
    public $iframeHandler = 'function(data){}';
    public $modalOptions = [];
    public $buttonOptions = [];
    public $buttonContent;
    private $_containerTag;

    public function renderModal()
    {
        Modal::begin($this->modalOptions);

        echo Html::tag('iframe', '', $this->iframeOptions);

        Modal::end();
    }

    public function init()
    {
        $this->initOptions();
        $this->_containerTag = ArrayHelper::remove($this->buttonOptions, 'tag', 'span');
        echo Html::beginTag($this->_containerTag, $this->buttonOptions);
    }


    public function run()
    {
        echo $this->buttonContent;
        echo Html::endTag($this->_containerTag);

        parent::run();

        $this->getView()->on(View::EVENT_END_BODY, [$this, 'renderModal']);

        $this->getView()->registerJs("$(document).on('data', '#{$this->iframeOptions["id"]}', function(e, data){
            var handler = {$this->iframeHandler}
            handler(data)
            $('#{$this->modalOptions["id"]}').modal('hide')
        })");

        $this->getView()->registerAssetBundle(ModalIFrameAsset::className());
    }


    /**
     * @inheritdoc
     */
    protected function initOptions()
    {
        $this->iframeOptions = array_merge([
            'height' => '500px',
            'width' => '100%',
            'style' => 'border: 0',
        ], $this->iframeOptions);
        $this->iframeOptions['id'] = $this->getIFrameId();

        $this->modalOptions['id'] = $this->getModalId();
        $this->modalOptions['toggleButton'] = false;

        $this->buttonOptions['id'] = $this->getButtonId();
        $this->buttonOptions['data-behavior'] = 'iframe';
        $this->buttonOptions['data-iframe'] = '#' . $this->iframeOptions['id'];
        $this->buttonOptions['data-toggle'] = 'modal';
        $this->buttonOptions['data-target'] = '#' . $this->modalOptions['id'];
    }

    public function getModalId()
    {
        return $this->getId() . '-modal';
    }

    public function getButtonId()
    {
        return $this->getId() . '-button';
    }

    public function getIFrameId()
    {
        return $this->getId() . '-iframe';
    }


    public static function emitDataJs($data)
    {
        return "parent.$(window.frameElement).trigger('data', " . Json::encode($data) . ")";
    }

    public static function emitData($data)
    {
        echo Html::script(self::emitDataJs($data));

        Yii::$app->end();
    }

    public static function refreshPage()
    {
        echo Html::script('parent.location.reload(true)');

        Yii::$app->end();
    }
} 