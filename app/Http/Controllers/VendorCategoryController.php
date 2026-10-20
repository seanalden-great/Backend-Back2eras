<?php

// namespace App\Http\Controllers;

// use App\Models\VendorCategory;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage; // TAMBAHKAN INI

// class VendorCategoryController extends Controller
// {
//     public function index()
//     {
//         return response()->json(VendorCategory::all());
//     }

//     // public function store(Request $request) {
//     //     $data = $request->validate([
//     //         'name' => 'required|string',
//     //         'image_url' => 'required|string',
//     //         'subtitle' => 'nullable|string',
//     //         'features' => 'required|string'
//     //     ]);
//     //     return response()->json(VendorCategory::create($data), 201);
//     // }

//     public function store(Request $request)
//     {
//         $data = $request->validate([
//             'name'       => 'required|string',
//             'subtitle'   => 'nullable|string',
//             'features'   => 'required|string',
//             'image_file' => 'nullable|image|max:5120',
//             'image_url'  => 'nullable|string'
//         ]);

//         // if ($request->hasFile('image_file')) {
//         //     $path = $request->file('image_file')->storePublicly('categories', 's3');
//         //     $data['image_url'] = Storage::disk('s3')->url($path);
//         // } elseif (!$request->filled('image_url')) {
//         //     return response()->json(['message' => 'Either image file or URL is required'], 422);
//         // }

//         if ($request->hasFile('image_file')) {
//             // Ganti storePublicly menjadi store
//             $path = $request->file('image_file')->store('stories', 's3');

//             // Tambahkan pengecekan ini agar tidak error length 0
//             if (!$path) {
//                 return response()->json(['message' => 'Gagal mengupload gambar ke S3. Pastikan ukuran gambar < 2MB.'], 500);
//             }

//             $validated['image_path'] = Storage::disk('s3')->url($path);
//         } elseif (!$request->filled('image_path')) {
//             return response()->json(['message' => 'Either image file or URL is required'], 422);
//         }

//         return response()->json(VendorCategory::create($data), 201);
//     }

//     // public function update(Request $request, $id) {
//     //     $cat = VendorCategory::findOrFail($id);
//     //     $cat->update($request->all());
//     //     return response()->json($cat);
//     // }

//     public function update(Request $request, $id)
//     {
//         $cat = VendorCategory::findOrFail($id);
//         $data = $request->except(['image_file', '_method']);

//         // if ($request->hasFile('image_file')) {
//         //     $path = $request->file('image_file')->storePublicly('categories', 's3');
//         //     $data['image_url'] = Storage::disk('s3')->url($path);
//         // }

//         if ($request->hasFile('image_file')) {
//             // Ganti storePublicly menjadi store
//             $path = $request->file('image_file')->store('stories', 's3');

//             // Tambahkan pengecekan ini agar tidak error length 0
//             if (!$path) {
//                 return response()->json(['message' => 'Gagal mengupload gambar ke S3. Pastikan ukuran gambar < 2MB.'], 500);
//             }

//             $validated['image_path'] = Storage::disk('s3')->url($path);
//         } elseif (!$request->filled('image_path')) {
//             return response()->json(['message' => 'Either image file or URL is required'], 422);
//         }

//         $cat->update($data);
//         return response()->json($cat);
//     }

//     public function destroy($id)
//     {
//         VendorCategory::destroy($id);
//         return response()->json(['message' => 'Category deleted']);
//     }
// }

namespace App\Http\Controllers;

use App\Models\VendorCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorCategoryController extends Controller
{
    public function index()
    {
        return response()->json(VendorCategory::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string',
            'subtitle'   => 'nullable|string',
            'features'   => 'required|string',
            'image_file' => 'nullable|image|max:5120',
            'image_url'  => 'nullable|string'
        ]);

        // LOGIKA S3 UNTUK VENDOR CATEGORY (Menggunakan $data dan image_url)
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('categories', 's3');

            if (!$path) {
                return response()->json(['message' => 'Gagal mengupload gambar ke S3. Pastikan ukuran gambar < 2MB.'], 500);
            }

            $data['image_url'] = Storage::disk('s3')->url($path);
        } elseif (!$request->filled('image_url')) {
            return response()->json(['message' => 'Either image file or URL is required'], 422);
        }

        return response()->json(VendorCategory::create($data), 201);
    }

    public function update(Request $request, $id)
    {
        $cat = VendorCategory::findOrFail($id);
        $data = $request->except(['image_file', '_method']);

        // LOGIKA S3 UNTUK VENDOR CATEGORY (Menggunakan $data dan image_url)
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('categories', 's3');

            if (!$path) {
                return response()->json(['message' => 'Gagal mengupload gambar ke S3. Pastikan ukuran gambar < 2MB.'], 500);
            }

            $data['image_url'] = Storage::disk('s3')->url($path);
        }

        $cat->update($data);
        return response()->json($cat);
    }

    public function destroy($id)
    {
        VendorCategory::destroy($id);
        return response()->json(['message' => 'Category deleted']);
    }
}
