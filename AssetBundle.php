<?php

namespace mervick\redactorjs;

/**
 * Class AssetBundle
 * @package mervick\redactorjs
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/mervick/redactor-js-mit/redactor';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->js = [ YII_DEBUG ? 'redactor.js' : 'redactor.min.js'];
        $this->css = ['redactor.css'];

        parent::init();
    }
}