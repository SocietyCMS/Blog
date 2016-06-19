<?php

namespace Modules\Blog\Components;

use Modules\Blog\Repositories\ArticleRepository;
use Modules\Core\Components\BaseBlock;

/**
 * Class RecentBlock
 * @package Modules\Blog\Components
 */
class RecentDetailedBlock extends BaseBlock
{

    /**
     * @var ArticleRepository
     */
    private $article;

    /**
     * RecentBlock constructor.
     * @param ArticleRepository $article
     */
    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    /**
     * Get the widget data to send to the view
     * @return array
     */
    protected function data()
    {
        $articles = $this->article->latestPinnedAndPublishedArticles(5);
        return $articles;
    }
}