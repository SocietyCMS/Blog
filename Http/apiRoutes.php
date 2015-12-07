<?php

$api->version('v1', function ($api) {
    $api->group([
        'prefix'     => 'blog',
        'namespace'  => $this->namespace.'\api',
        'middleware' => config('society.core.core.middleware.api.backend', []),
        'providers'  => ['jwt'],
    ], function ($api) {

        $api->resource('article', 'ArticleController', ['only' => ['index', 'store', 'show', 'destroy']]);
        $api->resource('article.image', 'ArticleImageController',
            ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    });
});
