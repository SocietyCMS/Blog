<?php

$api->version('v1', function ($api) {
    $api->group([
        'prefix'     => 'blog',
        'namespace'  => $this->namespace.'\api',
        'middleware' => config('society.core.core.middleware.api.backend', []),
        'providers'  => ['jwt'],
    ], function ($api) {

        $api->resource('article', 'ArticleController', ['only' => ['index', 'store', 'show', 'destroy']]);
        
        $api->post('article/{slug}/autosave', ['as' => 'api.blog.article.autosave', 'uses' => 'ArticleController@autosave']);

        $api->post('article/{slug}/image', ['as' => 'api.blog.article.image.upload', 'uses' => 'ArticleController@uploadImage']);
        $api->delete('article/{slug}/image', ['as' => 'api.blog.article.image.delete', 'uses' => 'ArticleController@deleteImage']);

        $api->resource('article.cover', 'ArticleCoverController',
            ['only' => ['index', 'store', 'show', 'destroy']]);
        $api->resource('article.file', 'ArticleFileController',
            ['only' => ['index', 'store', 'show', 'destroy']]);

    });
});
