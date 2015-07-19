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
     * Language
     * @var string|null
     */
    private static $language;


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->js = [ !YII_DEBUG ? 'redactor.min.js' : 'redactor.js'];
        $this->css = ['redactor.css'];

        if (!empty(self::$language)) {
            $this->js[] = (!YII_DEBUG ? self::$language . '.min' : self::$language) . '.js';
        }

        parent::init();
    }

    /**
     * Set language
     * @param string $lang
     */
    public static function useLanguage($lang)
    {
        $languages = [
            'ru-Ru' => 'ru-RU',
            'ru' => 'ru-RU',
        ];

        if (isset($languages[$lang])) {
            self::$language = "lang/{$languages[$lang]}";
        }
    }
}