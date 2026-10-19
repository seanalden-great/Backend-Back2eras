<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Mengambil semua data untuk halaman Admin
    public function index()
    {
        $applications = Application::orderBy('created_at', 'desc')->get();
        return response()->json($applications);
    }

    // Menerima pendaftaran baru dari halaman Apply
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|string|max:255',
            'category'   => 'required|string',
            'email'      => 'required|email',
            'details'    => 'nullable|string',
            'count'      => 'required|integer|min:1',
        ]);

        $application = Application::create($validated);

        return response()->json([
            'message' => 'Application submitted successfully!',
            'data'    => $application
        ], 201);
    }

    // Membatalkan pendaftaran (User dari frontend membatalkan apply)
    public function destroy($id)
    {
        Application::destroy($id);
        return response()->json(['message' => 'Application cancelled successfully!']);
    }

    // ADMIN: Menerima (Accept)
    public function accept($id)
    {
        $application = Application::findOrFail($id);
        $application->update(['status' => 'approved']);
        
        return response()->json(['message' => 'Application Approved!']);
    }

    // ADMIN: Menolak (Reject)
    public function reject($id)
    {
        $application = Application::findOrFail($id);
        $application->update(['status' => 'rejected']);
        
        return response()->json(['message' => 'Application Rejected!']);
    }
}