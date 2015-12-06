<?php namespace Modules\Blog\MenuExtenders;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
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
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->weight(10);

            $group->item(trans('blog::blog.title.blog'), function (Item $item) {
                $item->weight(10);
                $item->icon('fa fa-newspaper-o');
                $item->route('backend::blog.article.index');
                $item->authorize(
                    $this->auth->hasAccess('blog.article.index')
                );
            });

        });

        return $menu;
    }
}
