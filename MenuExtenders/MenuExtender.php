<?php

namespace Modules\Blog\MenuExtenders;

use Modules\Blog\Repositories\ArticleRepository;
use Modules\Core\Contracts\Authentication;
use Modules\Menu\Repositories\BaseMenuExtender;

class MenuExtender extends BaseMenuExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @var ArticleRepository
     */
    private $article;

    /**
     * @param ArticleRepository $article
     * @param Authentication $auth
     *
     * @internal param ArticleRepository $page
     * @internal param Guard $guard
     */
    public function __construct(ArticleRepository $article, Authentication $auth)
    {
        $this->auth = $auth;
        $this->article = $article;
    }

    /**
     * @return mixed
     * @internal param MenuRepository $menuRepository
     */
    public function contentItems()
    {
        return collect();
        //return $publishedPages = $this->page->allPublishedPages();
    }

    /**
     * @return mixed
     * @internal param MenuRepository $menuRepository
     */
    public function staticLinks()
    {
        return collect([
            'Blog' => route('blog.index')
        ]);
    }
}
