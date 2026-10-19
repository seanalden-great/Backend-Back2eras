<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    // Mengambil semua cerita (diurutkan dari yang terbaru)
    public function index()
    {
        $stories = Story::orderBy('published_date', 'desc')->get();
        return response()->json($stories);
    }

    // Mengambil satu cerita berdasarkan SLUG
    public function show($slug)
    {
        $story = Story::where('slug', $slug)->first();

        if (!$story) {
            return response()->json(['message' => 'Story not found'], 404);
        }

        return response()->json($story);
    }

    // Membuat cerita baru (Untuk Admin CRUD nanti)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'       => 'required|string',
            'title'          => 'required|string',
            'published_date' => 'required|date',
            'description'    => 'required|string',
            'image_path'     => 'required|string', // Bisa berupa URL Unsplash
        ]);

        // Otomatis membuat slug dari judul (Contoh: "Halo Dunia" -> "halo-dunia")
        $validated['slug'] = Str::slug($validated['title']);

        $story = Story::create($validated);

        return response()->json(['message' => 'Story created successfully', 'data' => $story], 201);
    }

    // Mengupdate cerita
    public function update(Request $request, $id)
    {
        $story = Story::findOrFail($id);
        $story->update($request->all());

        // Update slug jika judul berubah
        if ($request->has('title')) {
            $story->update(['slug' => Str::slug($request->title)]);
        }

        return response()->json(['message' => 'Story updated', 'data' => $story]);
    }

    // Menghapus cerita
    public function destroy($id)
    {
        Story::destroy($id);
        return response()->json(['message' => 'Story deleted']);
    }
}
