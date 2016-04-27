<?php

namespace Modules\Blog\Presenters;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;

class ArticlePresenter extends Presenter
{
    public function summary()
    {
        $html = new \Html2Text\Html2Text($this->body);
        return Str::words($html->getText(), 50);
    }

    /**
     * Format created_at.
     *
     * @return string
     */
    public function createdAt()
    {
        return $this->created_at->formatLocalized('%d %b. %Y');
    }

    /**
     * Format updated_at.
     *
     * @return string
     */
    public function updatedAt()
    {
        return $this->updated_at->formatLocalized('%d %B. %Y');
    }
}
