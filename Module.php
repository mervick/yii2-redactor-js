<?php

namespace mervick\redactorjs;

use Yii;
use yii\base\BootstrapInterface;

/**
 * Class Module
 * @package mervick\redactorjs
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @var string Editor language
     */
    public $lang = 'en-US';

    /**
     * @var string Path to upload images
     */
    public $imageUploadPath;

    /**
     * @var string Base url to images
     */
    public $imageBaseUrl;

    /**
     * @var string the maximum image resolution
     */
    public $maxImageResolution = '600x400';

    /**
     * @var string Image driver
     */
    public $imageDriver;

    /**
     * @var string Path to upload files
     */
    public $fileUploadPath;

    /**
     * @var string Base url to files
     */
    public $fileBaseUrl;

    /**
     * Editor width
     */
    public $width = '100%';

    /**
     * Editor height
     */
    public $height = '400px';

    /**
     * @var array the HTML attributes for the textarea input
     */
    public $options;

    /**
     * @var array Plugin options that will be passed to the editor
     */
    public $editorOptions;

    /**
     * @var array list of roles that will have allow to upload files. Two special roles are recognized, and
     * they are checked via [[User::isGuest]]:
     *
     * - `?`: matches a guest user (not authenticated yet)
     * - `@`: matches an authenticated user
     *
     * If you are using RBAC (Role-Based Access Control), you may also specify role or permission names.
     * In this case, [[User::can()]] will be called to check access.
     *
     * If this property is not set or empty, it will allow access to all roles.
     */
    public $allowedRoles;


    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $app->getUrlManager()->addRules([
                $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>' => $this->id . '/<controller>/<action>',
            ], false);
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->imageUploadPath = rtrim(Yii::getAlias($this->imageUploadPath), '/');
        $this->fileUploadPath = rtrim(Yii::getAlias($this->fileUploadPath), '/');
        $this->imageBaseUrl = rtrim(Yii::getAlias($this->imageBaseUrl), '/');
        $this->fileBaseUrl = rtrim(Yii::getAlias($this->fileBaseUrl), '/');

        parent::init();
    }
}