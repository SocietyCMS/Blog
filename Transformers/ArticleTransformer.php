<?php

namespace Modules\Blog\Transformers;

use League\Fractal;
use Modules\Blog\Entities\Article;

class ArticleTransformer extends Fractal\TransformerAbstract
{
    public function transform(Article $article)
    {
        return [
            'id'        => (int) $article->id,
            'title'     => $article->title,
            'slug'      => $article->slug,
            'body'      => $article->body,
            'published' => (bool) $article->published,
            'user'      => (int) $article->user_id,
            'links'     => [
                [
                    'rel' => 'self',
                    'uri' => '/books/'.$article->id,
                ],
            ],
        ];
    }
}
