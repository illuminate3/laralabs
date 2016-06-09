# Laralabs

Starter project for Laravel applications

## Development tools

The Development features do not depend on any other feature in the project.

### Packages to remove

```
"doctrine/dbal": "~2.3",
"barryvdh/laravel-ide-helper": "^2.1",
"barryvdh/laravel-debugbar": "^2.1",
```

### Code to remove

#### `/app/Providers/AppServiceProvider.php`

Some code in the `boot()` method to add the service providers of above packages.

## Auth

The Auth features do not depend on any other feature in the project.

### Files to remove

```
app/Http/Controllers/Frontend/Auth/**
app/Http/Routes/Frontend/Auth.php
app/Models/Auth/User.php
config/auth.php
database/factories/Auth/**
database/seeds/Auth/**
database/migrations/2016_06_10_000000_create_users_table.php
database/migrations/2016_06_10_100000_create_password_resets_table.php
```

### Resources to remove

```
resources/views/emails/auth/*
resources/views/frontend/auth/*
```

  
  
  