<?php

namespace Modules\Blog\Http\Controllers\api;

use DebugBar\DebugBarException;
use Illuminate\Http\Request;
use Modules\Blog\Http\Requests\ArticleRequest;
use Modules\Blog\Repositories\ArticleRepository;
use Modules\Blog\Transformers\ArticleTransformer;
use Modules\Core\Contracts\Authentication;
use Modules\Core\Http\Controllers\ApiBaseController;

/**
 * Class ArticleController
 * @package Modules\Blog\Http\Controllers\api
 */
class ArticleController extends ApiBaseController
{
    /**
     * @var Authentication
     */
    private $auth;

    /**
     * @var PageRepository
     */
    private $article;

    /**
     * ArticleController constructor.
     * @param ArticleRepository $article
     * @param Authentication    $auth
     */
    public function __construct(ArticleRepository $article, Authentication $auth)
    {
        parent::__construct();
        $this->article = $article;
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $articles = $this->article->all();

        return $this->response->collection($articles, new ArticleTransformer());
    }

    /**
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleRequest $request)
    {
        $input = array_merge($request->input(), [
            'user_id'   => $this->auth->check()->id,
            'slug'      => $this->article->getSlugForTitle($request->title),
            'published' => (bool) $request->published,
        ]);

        $article = $this->article->create($input);

        return $this->response()->item($article, new ArticleTransformer());
    }

    /**
     * @param Request $request
     * @param         $slug
     * @return mixed
     */
    public function show(Request $request, $slug)
    {
        $article = $this->article->findBySlug($slug);

        return $this->response->item($article, new ArticleTransformer());
    }


    public function autosave(Request $request, $slug)
    {
        $input = array_merge($request->input(), [
            'user_id'   => $this->auth->user()->id,
            'published' => (bool) $request->published,
            'pinned' => (bool) $request->pinned,
        ]);

        $article = $this->article->update($input, $this->article->findBySlug($slug)->id);

        return $this->response()->item($article, new ArticleTransformer());
    }

    /**
     * @param Request $request
     * @param         $slug
     * @throws DebugBarException
     */
    public function update(Request $request, $slug)
    {
        throw new DebugBarException();
    }

    /**
     * @param Request $request
     * @param         $slug
     * @throws DebugBarException
     */
    public function destroy(Request $request, $slug)
    {
        throw new DebugBarException();
    }
}
