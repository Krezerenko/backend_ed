@extends('layouts.app')

@section('title', 'Панель управления')

@section('content')
    <div class="container">
        <div class="success-box" style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; margin-top: 50px;">
            <h1>Авторизация успешна!</h1>
            <p>Добро пожаловать в панель управления автосервисом</p>

            <div class="user-info" style="margin: 20px 0; font-size: 1.2em;">
                Вы вошли как: <strong>{{ Auth::user()->name }}</strong>
            </div>

            <p>Доступ к админ-панели подтвержден</p>
            <p style="color: #666;">Время входа: {{ now()->format('d.m.Y H:i:s') }}</p>

            <div class="links" style="margin-top: 30px; display: flex; justify-content: center; gap: 15px;">
                <a href="{{ route('home') }}" class="back-link" style="padding: 12px; text-decoration: none; color: #333; border: 1px solid #ddd; border-radius: 5px;">
                    Вернуться на главную
                </a>

                <a href="{{ route('admin.fixtures') }}">
                    <button style="width: auto; background: #17a2b8;">Генерация данных</button>
                </a>

                <a href="{{ route('admin.stats') }}">
                    <button style="width: auto; background: #6f42c1;">Статистика (Графики)</button>
                </a>
            </div>
        </div>
    </div>
@endsection
