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
     * Html options that will be assigned to the text area
     */
    public $htmlOptions;

    /**
     * @var array Plugin options that will be passed to the editor
     */
    public $options;

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