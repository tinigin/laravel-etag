<?php

declare(strict_types=1);

namespace Tinigin\ETag\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void set(string|null $hash)
 * @method static string|null get()
 *
 * @see \Tinigin\ETag\ETag
 */
class ETag extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-etag';
    }
}
