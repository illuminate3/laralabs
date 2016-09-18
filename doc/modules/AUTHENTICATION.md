# Auth

The Auth features do not depend on any other feature in the project.

## How to remove that?

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

### Dependencies
  
#### Permissions/roles

  
#### User verification 
  
```
"jrean/laravel-user-verification": "^2.2"
```
  