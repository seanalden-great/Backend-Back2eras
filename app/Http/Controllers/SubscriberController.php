<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi email (wajib, format email benar, dan belum ada di tabel subscribers)
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ], [
            // Kustomisasi pesan error jika email sudah terdaftar
            'email.unique' => 'This email is already subscribed to our newsletter!'
        ]);

        // 2. Simpan ke database
        Subscriber::create($validated);

        // 3. Kembalikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'Thank you for subscribing to our newsletter!',
        ], 201);
    }
}