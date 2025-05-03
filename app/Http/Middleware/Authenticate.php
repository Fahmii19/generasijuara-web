<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $route = $request->route()->getName();
        $apps = '';
        if (str_starts_with($route, 'web.siab')) {
            $apps = 'siab';
        }elseif (str_starts_with($route, 'web.su')) {
            $apps = 'su';
        }elseif (str_starts_with($route, 'web.situ')) {
            $apps = 'situ';
        }elseif (str_starts_with($route, 'web.sireka')) {
            $apps = 'sireka';
        }elseif (str_starts_with($route, 'web.sirego')) {
            $apps = 'sirego';
        }
        
        if (! $request->expectsJson()) {
            return route('login', ['apps' => $apps]);
        }
    }
}
