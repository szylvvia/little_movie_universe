<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            if(auth()->user()->role == 'admin')
            {
                return null;
            }
            session()->flash('error', 'Dostępne tylko dla administaratora');
            return route('home');
        } else {
            session()->flash('error', 'Dostępne tylko dla administaratora');
            return route('home');
        }
    }
}
