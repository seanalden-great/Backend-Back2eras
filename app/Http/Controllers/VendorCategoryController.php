<?php

namespace App\Http\Controllers;

use App\Models\VendorCategory;
use Illuminate\Http\Request;

class VendorCategoryController extends Controller
{
    public function index() {
        return response()->json(VendorCategory::all());
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'image_url' => 'required|string',
            'subtitle' => 'nullable|string',
            'features' => 'required|string'
        ]);
        return response()->json(VendorCategory::create($data), 201);
    }

    public function update(Request $request, $id) {
        $cat = VendorCategory::findOrFail($id);
        $cat->update($request->all());
        return response()->json($cat);
    }

    public function destroy($id) {
        VendorCategory::destroy($id);
        return response()->json(['message' => 'Category deleted']);
    }
}