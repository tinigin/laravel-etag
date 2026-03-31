<?php

declare(strict_types=1);

namespace Tinigin\ETag\Tests;

use Tinigin\ETag\Facades\ETag;
use Tinigin\ETag\ETagServiceProvider;
use Tinigin\ETag\Middleware\ETagHandling;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;

class EtagHandlingTest extends Orchestra
{
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->headers = [
            'If-None-Match' => md5('1'),
        ];

        Route::any('/dummy-post-without-etag', function () {
            ETag::set(null);

            return 'ok';
        })->middleware(ETagHandling::class);

        Route::any('/dummy-post-with-etag', function () {
            ETag::set('1');

            return 'ok';
        })->middleware(ETagHandling::class);
    }

    protected function getPackageProviders($app): array
    {
        return [
            ETagServiceProvider::class,
        ];
    }

    public function testWithoutETagHeader(): void
    {
        $this->get('/dummy-post-without-etag')->assertOk();
        $this->get('/dummy-post-with-etag')->assertOk();
    }

    public function testWithETagHeader(): void
    {
        $this->get('/dummy-post-without-etag', $this->headers)->assertOk();
        $this->get('/dummy-post-with-etag', $this->headers)->assertStatus(304);
    }

    public function testPostMethod(): void
    {
        $this->post('/dummy-post-with-etag', [], $this->headers)->assertOk();
    }

    public function testDisableETag(): void
    {
        config(['etag.enable' => false]);
        $this->get('/dummy-post-with-etag', $this->headers)->assertOk();
        config(['etag.enable' => true]);
    }

    public function test304(): void
    {
        $this->get('/dummy-post-with-etag', $this->headers)->assertStatus(304);
    }
}
