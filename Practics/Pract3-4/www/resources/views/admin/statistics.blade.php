@extends('layouts.app')

@section('title', 'Статистика')

@section('content')
    <!-- Внутренние стили страницы переносим сюда -->
    <style>
        .charts-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }

        .chart-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            min-width: 300px;
        }

        .chart-box img {
            max-width: 100%;
            height: auto;
            border: 1px solid #eee;
        }

        .nav-buttons {
            margin: 20px 0;
            text-align: center;
        }

        .nav-buttons a {
            display: inline-block;
            margin: 0 10px;
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .nav-buttons a:hover {
            background: #5a6268;
        }
    </style>

    <div class="container">
        <h1 style="margin-top: 30px;">Статистика автосервиса</h1>

        <div class="nav-buttons">
            <a href="{{ route('admin.fixtures') }}" style="background: #17a2b8;">Сгенерировать новые данные</a>
            <a href="{{ route('admin.dashboard') }}">Вернуться в меню</a>
        </div>

        <div class="charts-container">
            @if (isset($file1) && $file1)
                <div class="chart-box">
                    <h3>Категории услуг</h3>
                    <img src="{{ asset('uploads/stats/chart1.png') }}?t={{ time() }}" alt="Pie Chart">
                </div>
            @endif

            @if (isset($file2) && $file2)
                <div class="chart-box">
                    <h3>Выручка по дням</h3>
                    <img src="{{ asset('uploads/stats/chart2.png') }}?t={{ time() }}" alt="Bar Chart">
                </div>
            @endif

            @if (isset($file3) && $file3)
                <div class="chart-box">
                    <h3>Статусы заказов</h3>
                    <img src="{{ asset('uploads/stats/chart3.png') }}?t={{ time() }}" alt="Line Chart">
                </div>
            @endif

            @if (!$hasData)
                <div class="chart-box" style="width: 100%; padding: 40px;">
                    <p>Нет данных для отображения.</p>
                    <a href="{{ route('admin.fixtures') }}" style="color: #007bff;">Сгенерируйте фикстуры</a>
                </div>
            @endif
        </div>
    </div>
@endsection
