<?php

namespace mervick\redactorjs;

use Yii;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Widget
 * @package mervick\redactorjs
 */
class Widget extends InputWidget
{
    /**
     * @var string Editor language
     */
    public $lang;

    /**
     * Editor width
     */
    public $width;

    /**
     * Editor height
     */
    public $height;

    /**
     * @var array the HTML attributes for the textarea input
     */
    public $options;

    /**
     * @var array Plugin options that will be passed to the editor
     */
    public $editorOptions;

    /**
     * @var Module
     */
    protected $_module;


    /**
     * Initialize the widget
     */
    public function init()
    {
        parent::init();

        $this->_module = Yii::$app->getModule('redactorjs');
        if ($this->_module === null) {
            throw new InvalidConfigException("The module 'redactorjs' was not found. Ensure you have setup the 'redactorjs' module in your Yii configuration file.");
        }

        foreach (['lang', 'width', 'height', 'options', 'editorOptions'] as $property) {
            if (empty($this->$property)) {
                $this->$property = $this->_module->$property;
            }
        }
        if (empty($this->options)) {
            $this->options = [];
        }
        if (empty($this->editorOptions)) {
            $this->editorOptions = [];
        }
        if (empty($this->editorOptions['lang'])) {
            $this->editorOptions['lang'] = $this->lang;
        }
        if (!empty($this->width)) {
            $this->options['style'] = "width: {$this->width};" . (!empty($this->options['style']) ? $this->options['style'] : '');
        }
        if (!empty($this->height)) {
            $this->options['style'] = "height: {$this->height};" . (!empty($this->options['style']) ? $this->options['style'] : '');
        }

        if (!empty($this->_module->imageUploadPath)) {
            $this->editorOptions['imageUpload'] = Url::toRoute(['/', $this->_module->id, 'default/upload-image']);
        }
        if (!empty($this->_module->fileUploadPath)) {
            $this->editorOptions['fileUpload'] = Url::toRoute(['/', $this->_module->id, 'default/upload-file']);
        }

        $this->generateId();
        $this->registerAssets();
        echo $this->renderInput();
    }

    /**
     * Generate HTML identifiers for elements
     */
    protected function generateId()
    {
        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * Register client assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        AssetBundle::register($view);

        $params = !empty($this->editorOptions) ? Json::encode($this->editorOptions) : '';

        // initialize redactor editor
        $view->registerJs('jQuery("document").ready(function(){jQuery("#' . $this->options['id'] . '").redactor(' . $params . ');});');
    }

    /**
     * Render the text area input
     */
    protected function renderInput()
    {
        if ($this->hasModel()) {
            $input = Html::activeTextArea($this->model, $this->attribute, $this->options);
        } else {
            $input = Html::textArea($this->name, $this->value, $this->options);
        }
        return $input;
    }
}