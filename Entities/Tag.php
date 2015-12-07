<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    protected $table = 'blog__tags';

    public function articles()
    {
        return $this->belongsToMany('Modules\Blog\Entities\Articles', 'blog__articles_tags');
    }
}
