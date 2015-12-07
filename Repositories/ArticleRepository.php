<?php

namespace Modules\Blog\Repositories;

use Modules\Core\Repositories\Eloquent\EloquentSlugRepository;

class ArticleRepository extends EloquentSlugRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'Modules\\Blog\\Entities\\Article';
    }

    /**
     * Return all ordered with OrderCriteria.
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        return parent::all($columns);
    }

    /**
     * Return the latest x blog posts.
     *
     * @param int $amount
     *
     * @return Collection
     */
    public function latest()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findPublishedArticleBySlug($slug)
    {
        return $this->model->where('published', 1)->where('slug', $slug)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allPublishedArticles()
    {
        return $this->model->wherePublished(1)->get();
    }

    /**
     * Return the latest x blog posts.
     *
     * @param int $amount
     *
     * @return Collection
     */
    public function latestPublishedArticles()
    {
        return $this->model->wherePublished(1)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get the previous post of the given post.
     *
     * @param object $article
     *
     * @return object
     */
    public function getPreviousOf($article)
    {
        return $this->model->where('created_at', '<', $article->created_at)
            ->wherePublished(1)->first();
    }

    /**
     * Get the next post of the given post.
     *
     * @param object $article
     *
     * @return object
     */
    public function getNextOf($article)
    {
        return $this->model->where('created_at', '>', $article->created_at)
            ->wherePublished(1)->first();
    }
}
