<?php

namespace App\Http\Controllers;

use App\Models\VendorCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // TAMBAHKAN INI

class VendorCategoryController extends Controller
{
    public function index() {
        return response()->json(VendorCategory::all());
    }

    // public function store(Request $request) {
    //     $data = $request->validate([
    //         'name' => 'required|string',
    //         'image_url' => 'required|string',
    //         'subtitle' => 'nullable|string',
    //         'features' => 'required|string'
    //     ]);
    //     return response()->json(VendorCategory::create($data), 201);
    // }

    public function store(Request $request) {
        $data = $request->validate([
            'name'       => 'required|string',
            'subtitle'   => 'nullable|string',
            'features'   => 'required|string',
            'image_file' => 'nullable|image|max:5120',
            'image_url'  => 'nullable|string'
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->storePublicly('categories', 's3');
            $data['image_url'] = Storage::disk('s3')->url($path);
        } elseif (!$request->filled('image_url')) {
            return response()->json(['message' => 'Either image file or URL is required'], 422);
        }

        return response()->json(VendorCategory::create($data), 201);
    }

    // public function update(Request $request, $id) {
    //     $cat = VendorCategory::findOrFail($id);
    //     $cat->update($request->all());
    //     return response()->json($cat);
    // }

    public function update(Request $request, $id) {
        $cat = VendorCategory::findOrFail($id);
        $data = $request->except(['image_file', '_method']);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->storePublicly('categories', 's3');
            $data['image_url'] = Storage::disk('s3')->url($path);
        }

        $cat->update($data);
        return response()->json($cat);
    }

    public function destroy($id) {
        VendorCategory::destroy($id);
        return response()->json(['message' => 'Category deleted']);
    }
}
