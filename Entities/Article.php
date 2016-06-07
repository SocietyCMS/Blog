<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\Entities\RelatesToUser;
use Modules\Core\Traits\Activity\RecordsActivity;
use Modules\Core\Traits\Media\useMediaConversions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

/**
 * Class Article
 * @package Modules\Blog\Entities
 */
class Article extends Model implements HasMediaConversions
{
    use HasMediaTrait;
    use useMediaConversions;

    use RecordsActivity;
    use PresentableTrait;

    use RelatesToUser;

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
     * Privacy setting for the dashboard. Articles are public.
     *
     * @var string
     */
    protected static $activityPrivacy = 'public';

    /**
     * Views for the Dashboard timeline.
     *
     * @var string
     */
    protected static $templatePath = 'blog::backend.activities';


    /**
     * Default MediaConversions for this Entity
     */
    public function additionalMediaConversions()
    {
        $this->addMediaConversion('small')
            ->setManipulations(['w' => 300, 'h' => 55,  'fit' => 'crop'])
            ->performOnCollections('cover');

        $this->addMediaConversion('medium')
            ->setManipulations(['w' => 800, 'h' => 148,  'fit' => 'crop'])
            ->performOnCollections('cover');

        $this->addMediaConversion('large')
            ->setManipulations(['w' => 1920, 'h' => 355,  'fit' => 'crop'])
            ->performOnCollections('cover');

        $this->addMediaConversion('thumbnail')
            ->setManipulations(['w' => 800])
            ->performOnCollections('files');

    }

}
