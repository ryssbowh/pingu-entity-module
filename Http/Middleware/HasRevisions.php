<?php

namespace Pingu\Entity\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Pingu\Field\Contracts\HasRevisionsContract;

class HasRevisions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $slug)
    {
        $entity = $request->route($slug);
        if (!$entity instanceof HasRevisionsContract) {
            return response()->view('errors.404', [], 404);
        }
        return $next($request);
    }
}
