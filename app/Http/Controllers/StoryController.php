<?php

// namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
// use App\Models\Story;
// use Illuminate\Http\Request;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Storage; // TAMBAHKAN INI

// class StoryController extends Controller
// {
//     // Mengambil semua cerita (diurutkan dari yang terbaru)
//     public function index()
//     {
//         $stories = Story::orderBy('published_date', 'desc')->get();
//         return response()->json($stories);
//     }

//     // Mengambil satu cerita berdasarkan SLUG
//     public function show($slug)
//     {
//         $story = Story::where('slug', $slug)->first();

//         if (!$story) {
//             return response()->json(['message' => 'Story not found'], 404);
//         }

//         return response()->json($story);
//     }

//     // Membuat cerita baru (Untuk Admin CRUD nanti)
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'category'       => 'required|string',
//             'title'          => 'required|string',
//             'published_date' => 'required|date',
//             'description'    => 'required|string',
//             'image_file'     => 'nullable|image|max:5120', // Maksimal 5MB
//             'image_path'     => 'nullable|string', // Bisa berupa URL Unsplash
//         ]);

//         // Otomatis membuat slug dari judul (Contoh: "Halo Dunia" -> "halo-dunia")
//         $validated['slug'] = Str::slug($validated['title']);

//         // // LOGIKA S3: Jika ada file yang diupload, simpan ke S3. Jika tidak, pakai URL dari inputan teks.
//         // if ($request->hasFile('image_file')) {
//         //     $path = $request->file('image_file')->storePublicly('stories', 's3');
//         //     $validated['image_path'] = Storage::disk('s3')->url($path);
//         // } elseif (!$request->filled('image_path')) {
//         //     return response()->json(['message' => 'Either image file or URL is required'], 422);
//         // }

//         // LOGIKA S3
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

//         $story = Story::create($validated);

//         return response()->json(['message' => 'Story created successfully', 'data' => $story], 201);
//     }

//     // Mengupdate cerita
//     // public function update(Request $request, $id)
//     // {
//     //     $story = Story::findOrFail($id);
//     //     $story->update($request->all());

//     //     // Update slug jika judul berubah
//     //     if ($request->has('title')) {
//     //         $story->update(['slug' => Str::slug($request->title)]);
//     //     }

//     //     return response()->json(['message' => 'Story updated', 'data' => $story]);
//     // }

//     public function update(Request $request, $id)
//     {
//         $story = Story::findOrFail($id);
//         $data = $request->except(['image_file', '_method']);

//         if ($request->has('title')) {
//             $data['slug'] = Str::slug($request->title);
//         }

//         // Jika mengupload gambar baru saat edit, timpa URL-nya
//         // if ($request->hasFile('image_file')) {
//         //     $path = $request->file('image_file')->storePublicly('stories', 's3');
//         //     $data['image_path'] = Storage::disk('s3')->url($path);
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

//         $story->update($data);
//         return response()->json(['message' => 'Story updated', 'data' => $story]);
//     }

//     // Menghapus cerita
//     public function destroy($id)
//     {
//         Story::destroy($id);
//         return response()->json(['message' => 'Story deleted']);
//     }
// }

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::orderBy('published_date', 'desc')->get();
        return response()->json($stories);
    }

    public function show($slug)
    {
        $story = Story::where('slug', $slug)->first();

        if (!$story) {
            return response()->json(['message' => 'Story not found'], 404);
        }

        return response()->json($story);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'       => 'required|string',
            'title'          => 'required|string',
            'published_date' => 'required|date',
            'description'    => 'required|string',
            'image_file'     => 'nullable|image|max:5120',
            'image_path'     => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // LOGIKA S3 UNTUK STORY
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('stories', 's3');

            if (!$path) {
                return response()->json(['message' => 'Gagal mengupload gambar ke S3. Pastikan ukuran gambar < 2MB.'], 500);
            }

            $validated['image_path'] = Storage::disk('s3')->url($path);
        } elseif (!$request->filled('image_path')) {
            return response()->json(['message' => 'Either image file or URL is required'], 422);
        }

        $story = Story::create($validated);
        return response()->json(['message' => 'Story created successfully', 'data' => $story], 201);
    }

    public function update(Request $request, $id)
    {
        $story = Story::findOrFail($id);
        $data = $request->except(['image_file', '_method']);

        if ($request->has('title')) {
            $data['slug'] = Str::slug($request->title);
        }

        // LOGIKA S3 UNTUK STORY
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('stories', 's3');

            if (!$path) {
                return response()->json(['message' => 'Gagal mengupload gambar ke S3. Pastikan ukuran gambar < 2MB.'], 500);
            }

            $data['image_path'] = Storage::disk('s3')->url($path);
        }

        $story->update($data);
        return response()->json(['message' => 'Story updated', 'data' => $story]);
    }

    public function destroy($id)
    {
        Story::destroy($id);
        return response()->json(['message' => 'Story deleted']);
    }
}
