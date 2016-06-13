<?php namespace App\ViewComposers\Backend;

use Illuminate\View\View;
use Lavary\Menu\Builder;
use Menu;

/**
 * Class NavigationMenuComposer
 * @package App\ViewComposers\Backend
 *
 * Build the navigation menu when the corresponding view needs to be rendered
 */
class NavigationMenuComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $navigationMenu = Menu::make('backend.navigation', function (Builder $menu)
        {
            $menu->add('Dashboard', [
                'route' => 'backend.dashboard',
            ]);
            $menu->add('About', 'about');
            $menu->add('services', 'services');
            $menu->add('Contact', 'contact');
        });

        $view->with('navigationMenu', $navigationMenu);
    }
}
