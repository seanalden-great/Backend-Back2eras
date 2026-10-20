<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    // Menampilkan daftar pengunjung (Untuk halaman Admin nanti)
    public function index()
    {
        $visitors = Visitor::orderBy('created_at', 'desc')->get();
        return response()->json($visitors);
    }

    // Menerima input form dari Frontend (Visitor Registration)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'            => 'required|string|max:255',
            'email'                => 'required|email|max:255',
            'whatsapp'             => 'required|string|max:20',
            'instagram'            => 'nullable|string|max:255',
            'subscribe_newsletter' => 'boolean'
        ]);

        $visitor = Visitor::create($validated);

        return response()->json([
            'success' => true,
            'message' => "Welcome to BACK2ERAS! You're on the list.",
            'data'    => $visitor
        ], 201);
    }

    // Menghapus data pengunjung (Untuk Admin)
    public function destroy($id)
    {
        Visitor::destroy($id);
        return response()->json(['message' => 'Visitor data deleted successfully']);
    }
}
