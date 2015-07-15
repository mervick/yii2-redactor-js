<?php

namespace mervick\redactorjs\controllers;

use Yii;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\Controller;
use yii\web\Response;
use mervick\redactorjs\Module;
use mervick\image\Image;
use yii\web\UploadedFile;


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
     * Generates random filename
     * @param $path
     * @param string $extension
     * @return string
     */
    protected function uniqueRandomFilename($path, $extension='')
    {
        do {
            $filename = Yii::$app->security->generateRandomString(mt_rand(3, 20));
        }
        while (file_exists("{$path}/{$filename}{$extension}"));

        return $filename;
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

                $extension = strtolower(image_type_to_extension($image->type, true));
                if (!in_array($extension, ['.jpg', '.gif', '.png'])) {
                    $extension = '.jpg';
                }

                $filename = $this->uniqueRandomFilename($this->_module->imageUploadPath, $extension);

                if ($image->save("{$this->_module->imageUploadPath}/{$filename}{$extension}")) {
                    return [
                        'filelink' => "{$this->_module->imageBaseUrl}/{$filename}{$extension}"
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
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_FILES['file'])) {
            $file = UploadedFile::getInstanceByName('file');

            $extension = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
            if (!empty($extension)) {
                $extension = ".$extension";
            }

            $filename = $this->uniqueRandomFilename($this->_module->fileUploadPath, $extension);

            if ($file->saveAs("{$this->_module->imageUploadPath}/{$filename}{$extension}")) {
                return [
                    'filelink' => "{$this->_module->fileBaseUrl}/{$filename}{$extension}",
                    'filename' => $file['name'],
                ];
            }
        }

        return [];
    }

}