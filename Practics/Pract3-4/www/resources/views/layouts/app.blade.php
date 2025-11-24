<!DOCTYPE html>
<html lang="{{ request()->cookie('language', 'ru') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.title'))</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="{{ request()->cookie('theme', 'light') }}">
<header>
    <div class="container">
        <h1>@lang('messages.title')</h1>
        <nav>
            <a href="{{ route('home') }}">Главная</a>
            <a href="{{ route('home') }}#services">@lang('messages.our_services')</a>
            <a href="{{ route('files.index') }}">@lang('messages.view_files')</a>

            @auth
                <a href="{{ route('admin.dashboard') }}">Админка</a>
            @else
                <a href="/login">Войти</a>
            @endauth
        </nav>
    </div>
</header>

<main class="container">
    @if(session('success'))
        <div class="alert success" style="padding: 10px; background: #d4edda; color: #155724; margin: 10px 0;">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert error" style="padding: 10px; background: #f8d7da; color: #721c24; margin: 10px 0;">
            {{ $errors->first() }}
        </div>
    @endif

    @yield('content')
</main>

<footer>
    <div class="container text-center">
        &copy; {{ date('Y') }} Autoservice Laravel
    </div>
</footer>
</body>
</html>
