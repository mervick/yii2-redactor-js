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
     * @var array Plugin js options
     */
    public $options;

    /**
     *
     * @var array list of roles that this rule applies to. Two special roles are recognized, and
     * they are checked via [[User::isGuest]]:
     *
     * - `?`: matches a guest user (not authenticated yet)
     * - `@`: matches an authenticated user
     *
     * If you are using RBAC (Role-Based Access Control), you may also specify role or permission names.
     * In this case, [[User::can()]] will be called to check access.
     *
     * If this property is not set or empty, it means this rule applies to all roles.
     */
    public $allowedRoles;
}