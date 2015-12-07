<?php

namespace Modules\Blog\Http\Controllers\api;

use Illuminate\Http\Request;
use Modules\Blog\Repositories\ArticleRepository;
use Modules\Blog\Transformers\ArticleImagesTransformer;
use Modules\Core\Http\Controllers\ApiBaseController;

class ArticleImageController extends ApiBaseController
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

        return $this->response->collection($article->getMedia('images'), new ArticleImagesTransformer());
    }

    public function store(Request $request, $slug)
    {
        $article = $this->article->findBySlug($slug);

        $savedImage = $article->addMedia($request->files->get('qqfile'))->toMediaLibrary('images');

        $resourceUrl = app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.blog.article.image.show', ['article' => $slug, 'image' => $savedImage->id]);

        return $this->response->item($savedImage, new ArticleImagesTransformer());
    }

    public function show(Request $request, $slug, $image)
    {
        $article = $this->article->findBySlug($slug);

        return $this->response->item($article->getMedia('images')->keyBy('id')->get($image), new ArticleImagesTransformer());
    }

    public function destroy(Request $request, $slug, $image)
    {
        $article = $this->article->findBySlug($slug);

        $article->getMedia('images')->keyBy('id')->get($image)->delete();

        return $this->response->noContent();
    }
}
