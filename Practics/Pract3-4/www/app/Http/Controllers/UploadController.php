<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10240',
        ]);

        if ($request->file('pdf_file')->isValid()) {
            $file = $request->file('pdf_file');
            $filename = preg_replace("/[^a-zA-Z0-9\._-]/", "", $file->getClientOriginalName());

            $file->move(public_path('uploads'), $filename);

            return back()->with('success', "Файл '$filename' успешно загружен.");
        }

        return back()->withErrors(['msg' => 'Ошибка загрузки файла.']);
    }
}
