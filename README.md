<!--suppress HtmlDeprecatedAttribute -->

# ETag / 304 Not Modified Handler for Laravel

Easily setting the `ETag` header and `304 Not Modified` response code.

<p style="text-align: center;" align="center">

<a href="https://packagist.org/packages/tinigin/laravel-etag" title="Packagist version">
    <img alt="Packagist Version" src="https://img.shields.io/packagist/v/tinigin/laravel-etag">
</a>

<a href="https://github.com/tinigin/laravel-etag/actions/workflows/tests.yml" title="GitHub Tests Status">
    <img alt="GitHub Tests Status" src="https://img.shields.io/github/actions/workflow/status/tinigin/laravel-etag/tests.yml?label=tests">
</a>

<a href="https://github.com/tinigin/laravel-etag/actions/workflows/php-cs-fixer.yml" title="GitHub Code Style Status">
    <img alt="GitHub Code Style Status" src="https://img.shields.io/github/actions/workflow/status/tinigin/laravel-etag/php-cs-fixer.yml?label=code%20style">
</a>

<a href="https://www.php.net/" title="PHP version">
    <img alt="PHP Version Support" src="https://img.shields.io/packagist/php-v/tinigin/laravel-etag">
</a>

<a href="https://github.com/tinigin/laravel-etag/blob/master/LICENSE.md" title="License">
    <img alt="License" src="https://img.shields.io/github/license/tinigin/laravel-etag">
</a>

</p>


## Requirements
- PHP 8.3+
- Laravel 11.x / 12.x / 13.x

## Installation

You can install the package via composer:

```bash
composer require tinigin/laravel-etag
```

Optionally, you can publish the config file with:

```bash
php artisan vendor:publish --tag="etag-config"
```
## Usage
The setup is very simple and consists of two steps:

### Registering middleware

```php
// in bootstrap/app.php

->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \Tinigin\ETag\Middleware\ETagHandling::class,
    ]);
})
```

### Set Last Update Date in your Controller

```php
<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use ETag;
 
class PostController extends Controller
{
    public function show($id)
    {
        $post = \App\Models\Post::findOrFail($id);

        ETag::set($post->getKey());
        
        return view('posts.show', ['post' => $post]);
    }
}
```
It's all. Now you can check the headers.

## How to check headers

You can check headers in the browser console under the `Network` tab (make sure `Disable Cache` is off) 

## Testing

```bash
composer test:all
```

or

```bash
composer test:phpunit
composer test:phpstan
composer test:phpcsf
```

or see https://github.com/tinigin/laravel-etag/actions/workflows/tests.yml

## Feedback

If you have any feedback, comments or suggestions, please feel free to open an issue within this repository.

## Contributing

Please see [CONTRIBUTING](https://github.com/abordage/.github/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Dmitrii Tinigin](https://github.com/tinigin)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
