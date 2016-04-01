<?php

namespace Modules\Blog\Http\Controllers\api;

use Illuminate\Http\Request;
use Modules\Blog\Repositories\ArticleRepository;
use Modules\Blog\Transformers\ArticleCoverTransformer;
use Modules\Blog\Transformers\ArticleImagesTransformer;
use Modules\Core\Http\Controllers\ApiBaseController;
use Modules\Core\Http\Requests\MediaImageRequest;

class ArticleCoverController extends ApiBaseController
{
    /**
     * @var PageRepository
     */
    private $article;

    public function __construct(ArticleRepository $article)
    {
        parent::__construct();
        $this->article = $article;
    }

    public function index(Request $request, $slug)
    {
        $article = $this->article->findBySlug($slug);

        $cover = $article->getFirstMedia('cover')?:null;

        return $this->response->item($cover, new ArticleCoverTransformer());
    }

    public function store(MediaImageRequest $request, $slug)
    {
        $article = $this->article->findBySlug($slug);

        $article->clearMediaCollection('cover');
        $savedImage = $article->addMedia($request->files->get('image'))->toMediaLibrary('cover');

        return $this->response->item($savedImage, new ArticleCoverTransformer());
    }

    public function destroy(Request $request, $slug)
    {
        $article = $this->article->findBySlug($slug);

        $article->clearMediaCollection('cover');
        return $this->response->noContent();
    }
}
