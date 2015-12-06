<?php namespace Modules\Blog\MenuExtenders;

use Modules\Core\Contracts\Authentication;
use Modules\Menu\Repositories\Menu\MenuRepository;

class MenuExtender implements \Modules\Menu\Repositories\MenuExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param MenuRepository $menuRepository
     *
     * @return MenuRepository
     */
    public function extendWith(MenuRepository $menuRepository)
    {
        $menuRepository->mainMenu()->route('blog.index', trans('blog::blog.title.blog'), [], 1, [
            'active' => function () {
                return \Route::is('blog.index') || \Route::is('blog.show');
            }
        ]);

        return $menuRepository;
    }
}
