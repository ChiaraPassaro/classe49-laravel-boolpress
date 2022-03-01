# Laravel Boolpress

## Update Faker
```
composer remove fzaninotto/faker 
composer require fakerphp/faker
```

## Add Auth
https://laravel.com/docs/7.x/authentication#included-routing

```
composer require laravel/ui:^2.4
 
php artisan ui vue --auth
```

## Update Bootstrap to 5.1.0
  ```JS
  "devDependencies": {
        "axios": "^0.19",
        "bootstrap": "^5.1.0"
```

### Popper JS Bootstrap
Add to `webpack.mix`
```JS
    .js('node_modules/popper.js/dist/popper.js', 'public/js').sourceMaps();
```


# To do 

Move `home.blade.php` in `admin` folder

## Create HomeController

Modify return view index

```

php artisan make:controller Admin/HomeController
```

## Modify RouteServiceProvider
```PHP
   // public const HOME = '/home';
    public const HOME = '/admin';
```


## Create Model Migration Seeder
1. Posts 
2. Categories
3. Add Relationship

```
php artisan make:model --migration --seed Model/Post

php artisan make:model --migration --seed Model/Category
```
### Add relationship
```
php artisan make:migration AddForeinCategoriesPostsTable --table=posts
```

## Create PostController 

```

php artisan make:controller --resource Admin/PostController
```

## Routes
https://laravel.com/docs/7.x/routing

### Routes Implicit Binding
#### Customizing The Default Key Name
https://laravel.com/docs/7.x/routing#implicit-binding

## Authentication Directives Blade
https://laravel.com/docs/7.x/blade#if-statements

## Relationships
https://laravel.com/docs/7.x/eloquent-relationships

## Query Relationships
https://laravel.com/docs/7.x/eloquent-relationships#querying-relations


