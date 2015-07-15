<?php

namespace mervick\redactorjs\controllers;

use Yii;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Class DefaultController
 * @package mervick\redactorjs\controllers
 */
class DefaultController extends Controller
{
    /**
     * @var \mervick\redactorjs\Module
     */
    private $_module;


    /**
     * @inheritdoc
     */
    public function init()
    {
        $module = Yii::$app->getModule('redactorjs');
        if ($module === null) {
            throw new InvalidConfigException("The module 'redactorjs' was not found. Ensure you have setup the 'redactorjs' module in your Yii configuration file.");
        }
        $this->_module = $module;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload-image' => ['post'],
                    'upload-file' => ['post'],
                ],
            ],
        ];

        if (!empty($this->_module->allowedRoles)) {
            $behaviors['access'] = [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['upload-image', 'upload-file'],
                        'allow' => true,
                        'roles' => $this->_module->allowedRoles,
                    ],
                ],
            ];
        }

        return $behaviors;
    }

    public function actionUploadImage()
    {

    }

    public function actionUploadFile()
    {

    }

}