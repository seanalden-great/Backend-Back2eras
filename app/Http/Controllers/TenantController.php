<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    // Menampilkan daftar tenant (Untuk Admin)
    public function index()
    {
        $tenants = Tenant::orderBy('created_at', 'desc')->get();
        return response()->json($tenants);
    }

    // Menerima form pendaftaran Tenant dari Frontend
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_name'     => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'whatsapp'       => 'required|string|max:20',
            'social_link'    => 'required|string|max:255',
            'category'       => 'required|string|max:100',
            'photo_link'     => 'required|url|max:255', // Memastikan format link/URL valid
            'description'    => 'required|string',
            'booth_size'     => 'required|string|max:100',
            'special_req'    => 'nullable|string|max:255',
        ]);

        $tenant = Tenant::create($validated);

        return response()->json([
            'success' => true,
            'message' => "Application Received! We will review it shortly.",
            'data'    => $tenant
        ], 201);
    }

    // Update status pendaftaran (Untuk Admin: Approve/Reject)
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string|in:pending,approved,rejected']);
        $tenant = Tenant::findOrFail($id);
        $tenant->update(['status' => $request->status]);
        
        return response()->json(['message' => 'Status updated successfully', 'data' => $tenant]);
    }

    // Menghapus data tenant (Untuk Admin)
    public function destroy($id)
    {
        Tenant::destroy($id);
        return response()->json(['message' => 'Tenant application deleted successfully']);
    }
}