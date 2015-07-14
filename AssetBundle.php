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
    public function init()
    {
        $this->setSourcePath('@vendor/mervick/redactor-js-mit/redactor');
        $this->setupAssets('js', [
            YII_DEBUG ? 'redactor.js' : 'redactor.min.js'
        ]);
        $this->setupAssets('css', ['redactor.css']);
        parent::init();
    }
}