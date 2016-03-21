<?php

namespace Modules\Blog\Transformers;

use League\Fractal;
use Modules\Blog\Entities\Article;

class ArticleTransformer extends Fractal\TransformerAbstract
{
    public function transform(Article $article)
    {
        return [
            'id'        => (int)$article->id,
            'title'     => $article->title,
            'slug'      => $article->slug,
            'body'      => $article->body,
            'published' => (bool)$article->published,
            'user'      => (int)$article->user_id,
            'links'     => [
                [
                    'rel' => 'self',
                    'uri' => apiRoute('v1', 'api.blog.article.show', ['slug' => $article->slug]),
                    'url' => apiRoute('v1', 'api.blog.article.show', ['slug' => $article->slug], false),
                ],
                [
                    'rel' => 'backend',
                    'uri' => route('backend::blog.article.edit', ['slug' => $article->slug]),
                    'url' => route('backend::blog.article.edit', ['slug' => $article->slug], false),
                ],
                [
                    'rel' => 'frontend',
                    'uri' => route('blog.show', ['slug' => $article->slug]),
                    'url' => route('blog.show', ['slug' => $article->slug], false),
                ],
            ],
        ];
    }
}
