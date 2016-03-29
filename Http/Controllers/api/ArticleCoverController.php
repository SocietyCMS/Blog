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

        return $this->response->collection($article->getMedia('cover'), new ArticleCoverTransformer());
    }

    public function store(MediaImageRequest $request, $slug)
    {
        $article = $this->article->findBySlug($slug);

        $savedImage = $article->addMedia($request->files->get('image'))->toMediaLibrary('cover');

        $resourceUrl = app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.blog.article.cover.show', ['article' => $slug, 'image' => $savedImage->id]);

        return $this->response->item($savedImage, new ArticleCoverTransformer());
    }

    public function show(Request $request, $slug, $image)
    {
        $article = $this->article->findBySlug($slug);

        return $this->response->item($article->getMedia('cover')->keyBy('id')->get($image), new ArticleCoverTransformer());
    }

    public function destroy(Request $request, $slug)
    {
        $article = $this->article->findBySlug($slug);

        $article->clearMediaCollection('cover');
        return $this->response->noContent();
    }
}
