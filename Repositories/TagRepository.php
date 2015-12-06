<?php namespace Modules\Blog\Repositories;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class TagRepository extends EloquentBaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return "Modules\\Blog\\Entities\\Tag";
    }

    /**
     * Find a tag by its name
     * @param $name
     * @return mixed
     */
    public function findByName($name)
    {
        return $this->model->where('name', 'like', "%$name%")->get();
    }
}