<?php

namespace mervick\redactorjs\controllers;

use Yii;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use mervick\redactorjs\Module;

/**
 * Class DefaultController
 * @package mervick\redactorjs\controllers
 */
class DefaultController extends Controller
{
    /**
     * @var Module
     */
    private $_module;


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->_module = Yii::$app->getModule('redactorjs');
        if ($this->_module === null) {
            throw new InvalidConfigException("The module 'redactorjs' was not found. Ensure you have setup the 'redactorjs' module in your Yii configuration file.");
        }

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