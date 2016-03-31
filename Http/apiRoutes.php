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


        $api->get('article/{slug}/cover', ['as' => 'api.blog.article.cover.index', 'uses' => 'ArticleCoverController@index']);
        $api->post('article/{slug}/cover', ['as' => 'api.blog.article.cover.store', 'uses' => 'ArticleCoverController@store']);
        $api->delete('article/{slug}/cover', ['as' => 'api.blog.article.cover.destroy', 'uses' => 'ArticleCoverController@destroy']);


        $api->get('article/{slug}/file', ['as' => 'api.blog.article.file.index', 'uses' => 'ArticleFileController@index']);
        $api->post('article/{slug}/file', ['as' => 'api.blog.article.file.store', 'uses' => 'ArticleFileController@store']);
        $api->get('article/{slug}/file/{id}', ['as' => 'api.blog.article.file.show', 'uses' => 'ArticleFileController@show']);
        $api->delete('article/{slug}/file/{id}', ['as' => 'api.blog.article.file.destroy', 'uses' => 'ArticleFileController@destroy']);
        
    });
});
