<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Periksa apakah rute memiliki awalan 'adminyofa'
            if ($request->is('adminyofa/*')) {
                return route('loginadmin');
            }
            // Jika tidak, arahkan ke halaman login umum
            return route('login');
        }
    }
}
