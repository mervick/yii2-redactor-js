<?php

namespace mervick\redactorjs;

use Yii;

/**
 * Class Module
 * @package mervick\redactorjs
 */
class Module extends \yii\base\Module
{
    /**
     * @var string Editor language
     */
    public $lang = 'en';

    /**
     * @var string Path to upload images
     */
    public $imageUploadPath;

    /**
     * @var string Base url to images
     */
    public $imageBaseUrl;

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
}