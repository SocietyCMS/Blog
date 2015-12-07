<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    protected $table = 'blog__categories';

    public function articles()
    {
        return $this->belongsToMany('Articles');
    }
}
