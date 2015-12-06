<?php namespace Modules\Blog\Presenters;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;

class ArticlePresenter extends Presenter
{

    public function summary()
    {
        return Str::words($this->body, 50);
    }

    /**
     * Format created_at
     *
     * @return string
     */
    public function createdAt()
    {
        $created = $this->created_at;

        return Carbon::createFromFormat('Y-m-d H:i:s', $created)
            ->formatLocalized('%d %b. %Y');
    }

    /**
     * Format updated_at
     *
     * @return string
     */
    public function updatedAt()
    {
        $updated = $this->updated_at;

        return Carbon::createFromFormat('Y-m-d H:i:s', $updated)
            ->formatLocalized('%d %b. %Y');
    }
}
