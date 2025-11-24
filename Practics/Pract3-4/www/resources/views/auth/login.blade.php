@extends('layouts.app')

@section('title', 'Вход в систему')

@section('content')
    <div class="container" style="max-width: 400px; margin-top: 50px;">
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center; margin-bottom: 20px;">Вход</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    @error('email')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <button type="submit" style="width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Войти
                </button>
            </form>

            <div style="margin-top: 15px; font-size: 12px; color: #666;">
                <p>Тестовые данные (созданные сидером):</p>
                <ul>
                    <li>Admin: admin@autoservice.local / admin123</li>
                    <li>User: user@autoservice.local / user123</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
