@extends('layouts.app')

@section('content')
    <section id="hero">
        <h2>@lang('messages.main_header')</h2>
        <p>
            @if($username !== 'Guest')
                @lang('messages.welcome_back'), {{ $username }}!
            @else
                @lang('messages.hello_guest').
            @endif
        </p>
    </section>

    <section id="user-preferences">
        <h2>@lang('messages.settings')</h2>
        <form action="{{ route('settings.update') }}" method="POST" class="settings-form">
            @csrf
            <div class="form-group">
                <label for="username">Ваше имя:</label>
                <input type="text" id="username" name="username" value="{{ $username === 'Guest' ? '' : $username }}">
            </div>
            <div class="form-group">
                <label for="theme">Тема:</label>
                <select id="theme" name="theme">
                    <option value="light" {{ $theme == 'light' ? 'selected' : '' }}>Светлая</option>
                    <option value="dark" {{ $theme == 'dark' ? 'selected' : '' }}>Темная</option>
                </select>
            </div>
            <div class="form-group">
                <label for="language">Язык:</label>
                <select id="language" name="language">
                    <option value="ru" {{ request()->cookie('language') == 'ru' ? 'selected' : '' }}>Русский</option>
                    <option value="en" {{ request()->cookie('language') == 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>
            <button type="submit">Сохранить настройки</button>
        </form>
    </section>

    <section id="upload-section">
        <h2>@lang('messages.upload_pdf')</h2>
        <form action="{{ route('upload.pdf') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="pdf_file">Выберите PDF файл:</label>
                <input type="file" id="pdf_file" name="pdf_file" accept="application/pdf" required>
            </div>
            <button type="submit">Загрузить</button>
        </form>
    </section>

    <section id="services">
        <h2>@lang('messages.our_services')</h2>
        <div class="services-grid">
            @foreach($services as $service)
                <div class="service-card">
                    <h3>{{ $service->name }}</h3>
                    <p>{{ $service->description }}</p>
                    <div class="service-info">
                        <span class="price">{{ $service->price }} €</span>
                        <span class="duration">{{ $service->duration }} мин</span>
                        <span class="category">{{ $service->category }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
