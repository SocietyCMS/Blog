<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\Media\baseMediaConversions;
use Modules\User\Traits\Activity\RecordsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Article extends Model implements HasMediaConversions
{
    use HasMediaTrait;

    use RecordsActivity;
    use PresentableTrait;

    use baseMediaConversions;

    /**
     * Presenter Class.
     *
     * @var string
     */
    protected $presenter = 'Modules\Blog\Presenters\ArticlePresenter';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog__articles';

    /**
     * The fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'body', 'published', 'user_id'];

    /**
     * @var array
     */
    protected static $recordEvents = ['created'];

    /**
     * Views for the Dashboard timeline.
     *
     * @var string
     */
    protected static $templatePath = 'blog::backend.activities';

    /**
     * User relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    { //Change to Repo
        return $this->belongsTo('Modules\User\Entities\Sentinel\EloquentUser', 'user_id');
    }

    public function category()
    {
        return $this->hasOne('Modules\Blog\Entities\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('Modules\Blog\Entities\Tag', 'blog__articles_tags');
    }
}
