<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SettingsController extends Controller
{
    public function update(Request $request)
    {
        $minutes = 60 * 24 * 365;

        Cookie::queue('username', $request->input('username', 'Guest'), $minutes);
        Cookie::queue('theme', $request->input('theme', 'light'), $minutes);
        Cookie::queue('language', $request->input('language', 'ru'), $minutes);

        session([
            'username' => $request->input('username'),
            'theme' => $request->input('theme'),
            'language' => $request->input('language'),
        ]);

        return redirect()->route('home');
    }
}
