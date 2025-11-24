@extends('layouts.app')

@section('title', 'Генерация фикстур')

@section('content')
    <div class="container">
        <h1 style="margin-top: 30px;">Генерация данных (Faker)</h1>

        @if(session('message'))
            <div class="error" style="background:#d4edda; color:#155724; padding: 15px; border-radius: 5px; margin: 20px 0;">
                {{ session('message') }}
            </div>
        @endif

        <div class="admin-panel" style="padding: 30px; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <p style="margin-bottom: 20px;">Нажмите кнопку ниже, чтобы сгенерировать 50+ записей статистики используя библиотеку FakerPHP.</p>

            <form method="POST" action="{{ route('admin.generate') }}">
                @csrf

                <label style="font-size: 1.1em; cursor: pointer;">
                    <input type="checkbox" name="clear" value="1" style="width: auto; margin-right: 10px;">
                    Удалить старые данные перед генерацией
                </label>

                <br><br>

                <button type="submit" style="max-width: 300px;">Сгенерировать фикстуры</button>
            </form>

            <div style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px;">
                <a href="{{ route('admin.stats') }}" style="color: #007bff; text-decoration: none; margin-right: 15px;">Перейти к графикам</a> |
                <a href="{{ route('admin.dashboard') }}" style="color: #666; text-decoration: none; margin-left: 15px;">Вернуться в админку</a>
            </div>
        </div>
    </div>
@endsection
