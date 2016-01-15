<?php

$router->group(['prefix' => '/blog'], function ($router) {

    // Blog
    $router->group(['middleware' => ['permission:blog::manage-article']], function () {
        get('article', ['as' => 'backend::blog.article.index', 'uses' => 'BlogController@index']);
        get('article/create', ['as' => 'backend::blog.article.create', 'uses' => 'BlogController@create']);
        post('article', ['as' => 'backend::blog.article.store', 'uses' => 'BlogController@store']);
        get('article/{slug}/edit', ['as' => 'backend::blog.article.edit', 'uses' => 'BlogController@edit']);
        put('article/{slug}/edit', ['as' => 'backend::blog.article.update', 'uses' => 'BlogController@update']);
        delete('article/{slug}', ['as' => 'backend::blog.article.destroy', 'uses' => 'BlogController@destroy']);
    });

});
