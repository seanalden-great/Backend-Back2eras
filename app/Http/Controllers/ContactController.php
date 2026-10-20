<?php

// namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
// use App\Models\Contact;
// use Illuminate\Http\Request;

// class ContactController extends Controller
// {
//     public function store(Request $request)
//     {
//         // 1. Validasi data dari frontend
//         $validated = $request->validate([
//             'name'    => 'required|string|max:255',
//             'email'   => 'required|email|max:255',
//             'type'    => 'required|string|in:tenant,sponsorship,media,volunteer,general',
//             'message' => 'required|string',
//         ]);

//         // 2. Simpan data ke database
//         $contact = Contact::create($validated);

//         // 3. Kembalikan response JSON ke Next.js
//         return response()->json([
//             'success' => true,
//             'message' => 'Your message has been sent successfully!',
//             'data'    => $contact
//         ], 201);
//     }
// }

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // 1. Menampilkan semua pesan contact (Diurutkan dari yang terbaru)
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return response()->json($contacts);
    }

    // 2. Menyimpan pesan dari pengunjung (Frontend)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'type'    => 'required|string|in:tenant,sponsorship,media,volunteer,general',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!',
            'data'    => $contact
        ], 201);
    }

    // 3. Menghapus pesan
    public function destroy($id)
    {
        Contact::destroy($id);
        return response()->json(['message' => 'Message deleted successfully']);
    }
}
