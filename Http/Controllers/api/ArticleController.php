<?php namespace Modules\Blog\Http\Controllers\api;

use DebugBar\DebugBarException;
use Illuminate\Http\Request;
use Modules\Blog\Repositories\ArticleRepository;
use Modules\Blog\Transformers\ArticleTransformer;
use Modules\Core\Http\Controllers\ApiBaseController;

class ArticleController extends ApiBaseController {


    /**
     * @var PageRepository
     */
    private $article;

    public function __construct(ArticleRepository $article)
    {
        parent::__construct();
        $this->article = $article;
    }

    public function index(Request $request)
    {
        $articles = $this->article->all();
        return $this->response->collection($articles, new ArticleTransformer);
    }

    public function store(Request $request, $slug)
    {
        throw new DebugBarException;
    }

    public function show(Request $request, $slug)
    {
        $article = $this->article->findBySlug($slug);
        return $this->response->item($article, new ArticleTransformer);
    }

    public function update(Request $request, $slug)
    {
        throw new DebugBarException;
    }


    public function destroy(Request $request, $slug)
    {
        throw new DebugBarException;
    }
	
}
