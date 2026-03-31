<?php

declare(strict_types=1);

namespace Tinigin\ETag\Middleware;

use Tinigin\ETag\Facades\ETag;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class ETagHandling
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!config('etag.enable')) {
            return $response;
        }

        if (is_null(ETag::get())) {
            return $response;
        }

        if (!in_array(strtoupper($request->getMethod()), ['GET', 'HEAD'])) {
            return $response;
        }

        if ($response instanceof Response) {
            $response->setEtag(ETag::get());
        }

        $requestNoneMatchString = request()->header('If-None-Match');
        if (!is_string($requestNoneMatchString)) {
            return $response;
        }

        if (ETag::get() === $requestNoneMatchString) {
            abort(304);
        }

        return $response;
    }
}
