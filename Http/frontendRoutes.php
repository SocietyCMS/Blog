<?php

$router->get('blog', ['uses' => 'PublicController@index', 'as' => 'blog.index']);
$router->get('blog/{slug}', ['uses' => 'PublicController@show', 'as' => 'blog.show']);
