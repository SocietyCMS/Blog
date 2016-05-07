<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\Media\baseMediaConversions;
use Modules\Core\Traits\Activity\RecordsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

/**
 * Class Article
 * @package Modules\Blog\Entities
 */
class Article extends Model implements HasMediaConversions
{
    use HasMediaTrait;

    use RecordsActivity;
    use PresentableTrait;

    use baseMediaConversions {
        registerMediaConversions as registerMediaConversionsFromTrait;
    }

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
    protected $fillable = ['title', 'slug', 'body', 'published', 'pinned', 'user_id'];

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
    {
        return $this->belongsTo('Modules\User\Entities\Entrust\EloquentUser', 'user_id');
    }

    /**
     *
     */
    public function registerMediaConversions()
    {
        $this->addMediaConversion('square')
            ->setManipulations(['w' => 300, 'h' => 300,  'fit' => 'crop'])
            ->performOnCollections('cover');

        $this->addMediaConversion('small')
            ->setManipulations(['w' => 300, 'h' => 55,  'fit' => 'crop'])
            ->performOnCollections('cover');

        $this->addMediaConversion('medium')
            ->setManipulations(['w' => 800, 'h' => 148,  'fit' => 'crop'])
            ->performOnCollections('cover');

        $this->addMediaConversion('large')
            ->setManipulations(['w' => 1920, 'h' => 355,  'fit' => 'crop'])
            ->performOnCollections('cover');

        $this->registerMediaConversionsFromTrait();
    }
}
