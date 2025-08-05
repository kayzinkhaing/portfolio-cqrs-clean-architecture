<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Township;
use Illuminate\Http\Request;

class TownshipController extends Controller
{
    // List all townships
    // public function index()
    // {
    //     return response()->json(Township::all());
    // }

    public function index()
    {
        return response()->json(
            Township::with('wards:id,name,township_id') // eager load wards
                ->select('id', 'name') // only needed fields
                ->get()
        );
    }

    // Create a new township
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:townships,name',
        ]);

        $township = Township::create($request->only('name'));

        return response()->json($township, 201);
    }

    // Show one township
    public function show($id)
    {
        $township = Township::findOrFail($id);
        return response()->json($township);
    }

    // Update a township
    public function update(Request $request, $id)
    {
        $township = Township::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:townships,name,' . $township->id,
        ]);

        $township->update($request->only('name'));

        return response()->json($township);
    }

    // Delete a township
    public function destroy($id)
    {
        $township = Township::findOrFail($id);
        $township->delete();

        return response()->json(null, 204);
    }
}
