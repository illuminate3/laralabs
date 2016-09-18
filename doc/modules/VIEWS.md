# Views

Provides packages used to simplify writing views. 

## Dependencies

### Bootforms

Quick way to write forms with Bootstrap markup

```
"laravelcollective/html" : "^5.2.0",
"adamwathan/bootforms" : "^0.8.0"
```

### Menus

```
"lavary/laravel-menu": "^1.6"
```

Menus are defined within view composers. For example, the backend menu is defined in the 
`App\ViewComposers\Backend\NavigationMenuComposer` class.

Below is a sample navigation menu which demonstrates the possibilities offered out of the box:

```php
$navigationMenu = Menu::make('backend.navigation', function (Builder $menu)
{
    // A header without link
    $menu->raw('Basic items');

    // A simple menu item pointing to a named route
    $menu->add('Simple item', [
        'route'    => 'backend.dashboard',
        'nickname' => 'simple-item',
    ]);

    // It is good practice to nickname the item, that will add a CSS class with corresponding nickname. Else the
    // nickname will be computed from the title and thus may be language dependent.
    $menu
        ->add('Coloured item', [
            'route'    => 'backend.dashboard',
            'nickname' => 'simple-item',
        ])
        ->data([
            'title-class' => 'text-danger',
        ]);

    // A header without link
    $menu->raw('Icons');

    // A menu item with an icon
    $menu
        ->add('With icon', [
            'route' => 'backend.dashboard',
        ])
        ->data([
            'icon' => 'users',
        ]);

    $menu
        ->add('With coloured icon', [
            'route' => 'backend.dashboard',
        ])
        ->data([
            'icon'       => 'warning',
            'icon-class' => 'text-danger',
        ]);

    // A header without link
    $menu->raw('Labels');

    // A menu item with a label
    $menu
        ->add('With label', [
            'route' => 'backend.dashboard',
        ])
        ->data([
            'label' => '0',
        ]);

    $menu
        ->add('With coloured label', [
            'route' => 'backend.dashboard',
        ])
        ->data([
            'label'       => 'new',
            'label-class' => 'label-info' // Optional, defaults to label-default
        ]);

    // A header without link
    $menu->raw('Hierarchies');

    $parent1 = $menu->add('Parent 1', '/');
    $child1 = $parent1->add('Child 1.1')->data(['icon' => 'circle-o']);
    $child1->add('Child 1.1.1')->data(['icon' => 'circle-o']);
    $child1->add('Child 1.1.2')->data(['icon' => 'circle-o']);
    $child2 = $parent1->add('Child 1.2')->data(['icon' => 'circle-o']);
    $child2->add('Child 1.2.1')->data(['icon' => 'circle-o']);
    $child2->add('Child 1.2.2')->data(['icon' => 'circle-o']);
    $child3 = $parent1->add('Child 1.3')->data(['icon' => 'circle-o']);
});
```