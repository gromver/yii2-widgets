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
 * Class ModalIFrame2
 * @package yii2-widgets
 * @author Gayazov Roman <gromver5@gmail.com>
 *
 * Замечен один баг - если в качестве кнопки использовать форму, то форма созданная через виджет ActiveForm работает криво, так как изза yii скриптов валидии
 * первое нажатие кнопки будет дважды обрабатыватся бутстрапом, тем самым сразу закрывая модальное окно, только после 2го сабмита виджет будет работь как предполагалось
 * поэтому надо использовать Html::beginForm() ... Html::endForm(), что впринципе и логично)
 *
 * <a href="/some/url" data-behavior="iframe" data-iframe-method="get" data-iframe-handler="function(data){}" data-params="{a:b}">push</a>
 */
class ModalIFrame2 extends \yii\base\Widget
{
    /**
     * @var array
     *  - width
     *  - height auto
     *  - dataHandler
     */
    public $iframeOptions = [];
    /**
     * @var array
     *  - method
     *  - params
     */
    public $formOptions;

    public $url;
    public $label = 'Show';
    public $options;

    public function run()
    {
        $this->initOptions();

        $tag = ArrayHelper::remove($this->options, 'tag', 'a');

        if ($tag == 'a') {
            echo Html::a($this->label, $this->url, $this->options);
        } else {
            echo Html::tag($tag, $this->label, $this->options);
        }

        parent::run();

        //$this->getView()->on(View::EVENT_END_BODY, [$this, 'renderModal']);

        /*$this->getView()->registerJs("$(document).on('data', '#{$this->iframeOptions["id"]}', function(e, data){
            var handler = {$this->iframeHandler}
            handler(data)
            $('#{$this->modalOptions["id"]}').modal('hide')
        })");*/
        //$this->getView()->registerJs("$('#{$this->buttonOptions["id"]} a').popup()");
        $this->getView()->registerAssetBundle(ModalIFrameAsset::className());
    }


    /**
     * @inheritdoc
     */
    protected function initOptions()
    {
/*        $this->iframeOptions = array_merge([
            'height' => '500px',
            'width' => '100%',
            'style' => 'border: 0',
        ], $this->iframeOptions);
        $this->iframeOptions['id'] = $this->getIFrameId();

        $this->modalOptions['id'] = $this->getModalId();
        $this->modalOptions['toggleButton'] = false;

        $this->buttonOptions['id'] = $this->getButtonId();
        $this->buttonOptions['data-behavior'] = 'iframe';
        /*$this->buttonOptions['data-iframe'] = '#' . $this->iframeOptions['id'];
        $this->buttonOptions['data-toggle'] = 'modal';
        $this->buttonOptions['data-target'] = '#' . $this->modalOptions['id'];*/

        if (is_array($this->iframeOptions)) {
            $this->options['data']['iframe'] = $this->iframeOptions;
        }

        if (is_array($this->formOptions)) {
            $this->options['data']['form'] = $this->formOptions;
        }

        $this->options['data']['behavior'] = 'iframe';
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