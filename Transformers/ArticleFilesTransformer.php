<?php

namespace Modules\Blog\Transformers;

use League\Fractal;
use Spatie\MediaLibrary\Media;

class ArticleFilesTransformer extends Fractal\TransformerAbstract
{
    public function transform(Media $articleFiles)
    {
        return [
            'id'        => $articleFiles->id,
            'name'      => $articleFiles->name,
            'file_name' => $articleFiles->file_name,
            'size'      => $articleFiles->size,
            'mime-type'  => $articleFiles->getCustomProperty('mime-type')
        ];
    }
}
