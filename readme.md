# Laralabs

Starter project for Laravel applications

## Development tools

### Packages

```
"doctrine/dbal": "~2.3",
"barryvdh/laravel-ide-helper": "^2.1",
"barryvdh/laravel-debugbar": "^2.1",
```

### Code to remove

#### `/app/Providers/AppServiceProvider.php`

Some code in the `boot()` method to add the service providers of above packages.

## Auth

### Packages

```
```

### Code to remove

```
app/Http/Controllers/Frontend/Auth/*
app/Http/Routes/Frontend/Auth.php
app/Models/Auth/User.php
config/auth.php
```

### Resources to remove

```
resources/views/emails/auth/*
resources/views/frontend/auth/*
```

  
  
  