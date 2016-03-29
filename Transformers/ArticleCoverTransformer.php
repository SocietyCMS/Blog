<?php

namespace Modules\Blog\Transformers;

use League\Fractal;
use Spatie\MediaLibrary\Media;

class ArticleCoverTransformer extends Fractal\TransformerAbstract
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
                'cover'  => $articleImages->getUrl('cover'),
            ],
        ];
    }
}
