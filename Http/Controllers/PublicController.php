<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Blog\Repositories\ArticleRepository;
use Modules\Core\Http\Controllers\PublicBaseController;

class PublicController extends PublicBaseController
{
    /**
     * @var ArticleRepository
     */
    private $article;
    /**
     * @var Application
     */
    private $app;

    public function __construct(ArticleRepository $article, Application $app)
    {
        parent::__construct();
        $this->article = $article;
        $this->app = $app;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $articles = $this->article->latestPinnedAndPublishedArticles();

        return view('blog::public.index', compact('articles'));
    }

    /**
     * @param $slug
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $article = $this->article->findPublishedArticleBySlug($slug);

        $this->throw404IfNotFound($article);

        $template = $this->getTemplateForPage($article);

        return view('blog::public.show', compact('article'));
    }

    /**
     * Return the template for the given page
     * or the default template if none found.
     *
     * @param $page
     *
     * @return string
     */
    private function getTemplateForPage($article)
    {
        return (view()->exists($article->template)) ? $article->template : 'default';
    }

    /**
     * Throw a 404 error page if the given page is not found.
     *
     * @param $page
     */
    private function throw404IfNotFound($article)
    {
        if (is_null($article)) {
            $this->app->abort('404');
        }
    }
}
