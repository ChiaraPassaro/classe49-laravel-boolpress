# Laravel Boolpress

## Installazione Laravel in current folder
```
composer create-project --prefer-dist laravel/laravel:^7.0 ./
```
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

### Install Bootstrap Icons
`npm i bootstrap-icons`
Add to `app.scss` 
`@import "~bootstrap-icons/font/bootstrap-icons.scss";`

https://icons.getbootstrap.com/#usage

<br>
<hr>
<br>

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
2. UserInfos
3. Categories
4. Add Relationship

```
php artisan make:model --migration --seed Model/Post

php artisan make:model --migration --seed Model/UserInfo

php artisan make:model --migration --seed Model/Category
```

## Create PostController 

```
php artisan make:controller --resource Admin/PostController
```

### Add relationship
```
php artisan make:migration update_posts_table --table=posts

php artisan make:migration update_posts_categories_table --table=posts
```

## Routes
https://laravel.com/docs/7.x/routing

### Routes Implicit Binding - How to modify show's uri with slug
#### Customizing The Default Key Name
https://laravel.com/docs/7.x/routing#implicit-binding

#### How to create a slug
https://laravel.com/docs/7.x/helpers#method-str-slug

## Authentication Directives Blade - Use Auth in blade views
https://laravel.com/docs/7.x/blade#if-statements

## Model Relationships
https://laravel.com/docs/7.x/eloquent-relationships

## Query Relationships
https://laravel.com/docs/7.x/eloquent-relationships#querying-relations

## Helpers Old for Forms
How to pass a default argument to `old()`
https://laravel.com/docs/7.x/helpers#method-old


## Pagination with query for orderBy

https://laravel.com/docs/7.x/pagination#displaying-pagination-results
```
If you wish to append all current query string values to the pagination links you may use the withQueryString method:

{{ $users->withQueryString()->links() }}
```