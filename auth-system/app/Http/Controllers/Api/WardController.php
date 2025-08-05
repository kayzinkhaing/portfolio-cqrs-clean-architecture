<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    // List wards (optionally filter by township_id)
    public function index()
    {
        // Return ALL wards without filtering.
        // Frontend will filter client-side.
        return response()->json(Ward::all());
    }


    // Create a new ward
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'township_id' => 'required|exists:townships,id',
        ]);

        $ward = Ward::create($request->only('name', 'township_id'));

        return response()->json($ward, 201);
    }

    // Show one ward
    public function show($id)
    {
        $ward = Ward::findOrFail($id);
        return response()->json($ward);
    }

    // Update a ward
    public function update(Request $request, $id)
    {
        $ward = Ward::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'township_id' => 'required|exists:townships,id',
        ]);

        $ward->update($request->only('name', 'township_id'));

        return response()->json($ward);
    }

    // Delete a ward
    public function destroy($id)
    {
        $ward = Ward::findOrFail($id);
        $ward->delete();

        return response()->json(null, 204);
    }
}
