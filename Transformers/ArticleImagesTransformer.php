<?php

namespace Modules\Blog\Transformers;

use League\Fractal;
use Spatie\MediaLibrary\Media;

class ArticleImagesTransformer extends Fractal\TransformerAbstract
{
    public function transform(Media $articleImages)
    {
        return [
            'id'        => $articleImages->id,
            'name'      => $articleImages->name,
            'file_name' => $articleImages->file_name,
            'size'      => $articleImages->size,
            'image'     => $articleImages->getUrl(),
            'thumbnail' => [
                'square' => $articleImages->getUrl('square100'),
                'small'  => $articleImages->getUrl('original100'),
                'medium' => $articleImages->getUrl('original180'),
                'large'  => $articleImages->getUrl('original400'),
                'cover'  => $articleImages->getUrl('cover900'),
            ],
        ];
    }
}
