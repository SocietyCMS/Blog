<?php

namespace Modules\Blog\Http\Controllers\backend;

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
            'user_id'   => $this->auth->user()->id,
            'slug'      => $this->article->getSlugForTitle($request->title),
            'published' => (bool) $request->published,
        ]);

        $article = $this->article->create($input);

        flash(trans('core::messages.resource.resource created', ['name' => trans('blog::blog.title.article')]));

        return redirect()->route('backend::blog.article.index');
    }

    public function edit($slug)
    {
        $article = $this->article->findBySlug($slug);

        \JavaScript::put([
            'blog' => ['article' => ['slug' => $article->slug]]
        ]);

        return view('blog::backend.blog.edit', compact('article'));
    }

    public function update(ArticleRequest $request, $slug)
    {
        $input = array_merge($request->input(), [
            'user_id'   => $this->auth->user()->id,
            'published' => (bool) $request->published,
            'pinned' => (bool) $request->pinned,
        ]);

        $this->article->update($input, $this->article->findBySlug($slug)->id);

        flash(trans('core::messages.resource.resource updated', ['name' => trans('blog::blog.title.article')]));

        return redirect()->route('backend::blog.article.index');
    }

    public function destroy($slug)
    {
        $article = $this->article->findBySlug($slug);
        $article->delete();

        flash(trans('core::messages.resource.resource deleted', ['name' => trans('blog::blog.title.article')]));

        return redirect()->route('backend::blog.article.index');
    }
}
