@extends('layouts.app')

@section('title', 'Загруженные файлы')

@section('content')
    <div style="padding-top: 20px;">
        <h1>Загруженные PDF файлы</h1>
        @if(!empty($files))
            <ul>
                @foreach($files as $file)
                    <li>
                        <a href="{{ asset('uploads/' . $file) }}" target="_blank">{{ $file }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Файлы еще не загружены.</p>
        @endif
        <br>
        <a href="{{ route('home') }}">← Вернуться на главную</a>
    </div>
@endsection
