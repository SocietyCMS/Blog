<?php
return [
    'article' => [
        'index' => [
            'blog.article.index',
        ],
        'create' => [
            'blog.article.create',
            'blog.article.store',
        ],
        'edit' => [
            'blog.article.edit',
            'blog.article.update',
            'blog.article.getImage',
            'blog.article.postImage',
            'blog.article.deleteImage'
        ],
        'destroy' => [
            'blog.article.destroy',
        ],
    ],
];
