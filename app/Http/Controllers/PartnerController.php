<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    // Menampilkan daftar partner/sponsor (Untuk Admin)
    public function index()
    {
        $partners = Partner::orderBy('created_at', 'desc')->get();
        return response()->json($partners);
    }

    // Menerima form dari Frontend
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'   => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'whatsapp'       => 'required|string|max:20',
            'social_link'    => 'required|string|max:255',
            'interest'       => 'required|string|max:255',
            'idea'           => 'required|string',
            'budget'         => 'nullable|string|max:255',
            'deck_link'      => 'nullable|url|max:255',
        ]);

        $partner = Partner::create($validated);

        return response()->json([
            'success' => true,
            'message' => "Partnership inquiry received! We will get in touch soon.",
            'data'    => $partner
        ], 201);
    }

    // Update status aplikasi (Untuk Admin)
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string|in:pending,reviewed,approved,rejected']);
        $partner = Partner::findOrFail($id);
        $partner->update(['status' => $request->status]);
        
        return response()->json(['message' => 'Status updated successfully', 'data' => $partner]);
    }

    // Menghapus data partner (Untuk Admin)
    public function destroy($id)
    {
        Partner::destroy($id);
        return response()->json(['message' => 'Partnership inquiry deleted successfully']);
    }
}