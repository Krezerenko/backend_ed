<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(Service::all());
    }

    public function show($id)
    {
        return response()->json(Service::findOrFail($id));
    }

    public function store(Request $request)
    {
        $service = Service::create($request->all());
        return response()->json(['message' => 'Created', 'id' => $service->id], 201);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->all());
        return response()->json(['message' => 'Updated']);
    }

    public function destroy($id)
    {
        Service::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}