<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Проверяем, есть ли кука 'language'
        // Если нет — берем дефолтный язык из конфига ('en')
        $language = $request->cookie('language', config('app.locale'));

        // 2. Устанавливаем этот язык в Laravel
        App::setLocale($language);

        return $next($request);
    }
}
