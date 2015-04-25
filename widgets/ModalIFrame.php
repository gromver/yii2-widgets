<?php
/**
 * @link https://github.com/gromver/yii2-widgets#readme
 * @copyright Copyright (c) Gayazov Roman, 2014
 * @license https://github.com/gromver/yii2-widgets/blob/master/LICENSE
 * @package yii2-widgets
 * @version 1.0.0
 */

namespace gromver\widgets;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use Yii;

/**
 * Class ModalIFrame
 * @package yii2-widgets
 * @author Gayazov Roman <gromver5@gmail.com>
 *
 * <a href="/some/url" data-behavior="iframe" data-iframe-method="get" data-iframe-handler="function(data){}" data-params="{a:b}">push</a>
 */
class ModalIFrame extends \yii\base\Widget
{
    public $options;
    /**
     * @var array
     *  - width
     *  - height
     *  - class
     *  - style
     */
    public $popupOptions = [];
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
    public $handler;

    public function run()
    {
        $this->initOptions();

        $tag = ArrayHelper::remove($this->options, 'tag', 'a');

        if ($tag == 'a') {
            echo Html::a($this->label, $this->url, $this->options);
        } else {
            echo Html::tag($tag, $this->label, $this->options);
        }

        $this->getView()->registerAssetBundle(ModalIFrameAsset::className());
    }


    /**
     * @inheritdoc
     */
    protected function initOptions()
    {
        if (is_array($this->popupOptions)) {
            $this->options['data']['popup'] = $this->popupOptions;
        }

        if (is_array($this->iframeOptions)) {
            $this->options['data']['iframe'] = $this->iframeOptions;
        }

        if (is_array($this->formOptions)) {
            $this->options['data']['form'] = $this->formOptions;
        }

        $this->options['data']['behavior'] = 'iframe';
        if (isset($this->handler)) {
            $this->options['data']['handler'] = $this->handler;
        }
    }

    public static function postDataJs($data, $closePopup = true)
    {
        Yii::$app->view->registerAssetBundle(ModalIFrameAsset::className());

        return "yii.gromverIframe.postData(" . Json::encode($data) . ");" . ($closePopup ? "yii.gromverIframe.closePopup();" : "");
    }

    public static function postData($data, $closePopup = true)
    {
        echo self::postMessageFunction();
        echo Html::script("postIframeMessage('send', " . Json::encode($data) . ");");
        if ($closePopup) {
            echo Html::script("postIframeMessage('close');");
        }

        Yii::$app->end();
    }

    public static function refreshParent($closePopup = true)
    {
        echo self::postMessageFunction();
        echo Html::script("postIframeMessage('refresh');");
        if ($closePopup) {
            echo Html::script("postIframeMessage('close')");
        }

        Yii::$app->end();
    }

    private static function postMessageFunction()
    {
        return Html::script(
<<<JS
    function postIframeMessage(name, message, target) {
        var data = {
            name: name + '.iframe.gromver',
            message: message
        };

        (target || window.parent).postMessage(JSON.stringify(data), window.location.origin || window.location.href);
    }
JS
        );
    }
} 