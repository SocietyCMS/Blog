<?php

namespace Modules\Blog\Repositories;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class CategoryRepository extends EloquentBaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'Modules\\Blog\\Entities\\Category';
    }
}
