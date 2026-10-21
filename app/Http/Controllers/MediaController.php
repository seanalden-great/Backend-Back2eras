<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    // Menampilkan daftar media (Untuk Admin)
    public function index()
    {
        $medias = Media::orderBy('created_at', 'desc')->get();
        return response()->json($medias);
    }

    // Menerima form pendaftaran Media dari Frontend
    public function store(Request $request)
    {
        $validated = $request->validate([
            'media_name'      => 'required|string|max:255',
            'contact_person'  => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'whatsapp'        => 'required|string|max:20',
            'social_links'    => 'required|string|max:255',
            'media_category'  => 'required|string|max:100',
            'audience_size'   => 'nullable|string|max:255',
            'media_kit'       => 'required|url|max:255',
            'coverage_format' => 'required|string',
        ]);

        $media = Media::create($validated);

        return response()->json([
            'success' => true,
            'message' => "Media partnership application received!",
            'data'    => $media
        ], 201);
    }

    // Update status aplikasi (Untuk Admin)
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string|in:pending,approved,rejected']);
        $media = Media::findOrFail($id);
        $media->update(['status' => $request->status]);
        
        return response()->json(['message' => 'Status updated successfully', 'data' => $media]);
    }

    // Menghapus data media (Untuk Admin)
    public function destroy($id)
    {
        Media::destroy($id);
        return response()->json(['message' => 'Media application deleted successfully']);
    }
}