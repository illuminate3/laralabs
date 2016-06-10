# Development tools

The Development features do not depend on any other feature in the project.

## How to remove that?

### Packages to remove

```
"doctrine/dbal": "~2.3",
"barryvdh/laravel-ide-helper": "^2.1",
"barryvdh/laravel-debugbar": "^2.1",
```

### Code to remove

#### `/app/Providers/AppServiceProvider.php`

Some code in the `boot()` method to add the service providers of above packages.
