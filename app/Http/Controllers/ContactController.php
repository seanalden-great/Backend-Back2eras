<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi data dari frontend
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'type'    => 'required|string|in:tenant,sponsorship,media,volunteer,general',
            'message' => 'required|string',
        ]);

        // 2. Simpan data ke database
        $contact = Contact::create($validated);

        // 3. Kembalikan response JSON ke Next.js
        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!',
            'data'    => $contact
        ], 201);
    }
}
