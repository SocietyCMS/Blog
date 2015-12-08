<?php

namespace Modules\Blog\Http\Controllers\backend;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Modules\Blog\Http\Requests\ArticleRequest;
use Modules\Blog\Repositories\ArticleRepository;
use Modules\Core\Http\Controllers\AdminBaseController;

class BlogController extends AdminBaseController
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

    public function index()
    {
        $articles = $this->article->latest();

        return view('blog::backend.blog.index', compact('articles'));
    }

    public function create()
    {
        return view('blog::backend.blog.create');
    }

    public function store(ArticleRequest $request)
    {
        $input = array_merge($request->input(), [
            'user_id'   => Sentinel::getUser()->id,
            'slug'      => $this->article->getSlugForTitle($request->title),
            'published' => (bool) $request->published,
        ]);

        $article = $this->article->create($input);

        return redirect()->route('backend::blog.article.index')
            ->with('success', 'Your article has been created successfully.');
    }

    public function edit($slug)
    {
        $article = $this->article->findBySlug($slug);

        return view('blog::backend.blog.edit', compact('article'));
    }

    public function update(ArticleRequest $request, $slug)
    {
        $input = array_merge($request->input(), [
            'user_id'   => Sentinel::getUser()->id,
            'published' => (bool) $request->published,
        ]);

        $this->article->update($input, $this->article->findBySlug($slug)->id);

        return redirect()->route('backend::blog.article.index')
            ->with('success', 'Your article has been updated successfully.');
    }
}
