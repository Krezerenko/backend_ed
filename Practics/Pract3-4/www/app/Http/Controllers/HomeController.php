<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('category')->orderBy('name')->get();

        return view('home', [
            'services' => $services,
            'username' => request()->cookie('username', 'Guest'),
            'theme' => request()->cookie('theme', 'light'),
        ]);
    }

    public function files()
    {
        $uploadDir = public_path('uploads');
        $files = [];

        if (is_dir($uploadDir)) {
            $files = array_diff(scandir($uploadDir), ['.', '..']);
            $files = array_filter($files, fn($file) => str_ends_with(strtolower($file), '.pdf'));
        }

        return view('files.index', compact('files'));
    }
}
