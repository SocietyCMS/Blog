<?php

namespace Modules\Blog\Installer;

class RegisterDefaultPermissions
{

    public $defaultPermissions = [

        'manage-article' => [
            'display_name' => 'blog::module-permissions.manage-article.display_name',
            'description' => 'blog::module-permissions.manage-article.description',
        ],

    ];
}