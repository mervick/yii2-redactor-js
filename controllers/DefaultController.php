<?php

namespace mervick\redactorjs\controllers;

use Yii;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use mervick\redactorjs\Module;
use mervick\image\Image;

/**
 * Class DefaultController
 * @package mervick\redactorjs\controllers
 */
class DefaultController extends Controller
{
    /**
     * @var Module
     */
    protected $_module;


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

    /**
     * Upload the image
     */
    public function actionUploadImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!empty($_FILES['file']['tmp_name']))
        {
            if ($image = Image::load($_FILES['file']['tmp_name'], $this->_module->imageDriver)) {
                if (!empty($this->_module->maxImageResolution)) {
                    $resolution = explode('x', strtolower($this->_module->maxImageResolution));
                    $width = empty($resolution[0]) ? null: $resolution[0];
                    $height = empty($resolution[1]) ? null: $resolution[1];
                    $image->resize($width, $height, 'auto');
                }

                $uploadPath = rtrim($this->_module->imageUploadPath, '/');

                $extension = strtolower(image_type_to_extension($image->type, true));
                if (!in_array($extension, ['.jpeg', '.gif', '.png'])) {
                    $extension = '.jpeg';
                }

                do {
                    $filename = Yii::$app->security->generateRandomString(mt_rand(3, 20));
                }
                while (file_exists("{$uploadPath}/{$filename}{$extension}"));

                if ($image->save("{$uploadPath}/{$filename}{$extension}")) {
                    return [
                        'filelink' => rtrim($this->_module->imageBaseUrl, '/') . "/{$filename}{$extension}",
                        'filename' => "{$filename}{$extension}"
                    ];
                }
            }
        }

        return [];
    }

    /**
     * Upload the file
     */
    public function actionUploadFile()
    {

    }

}