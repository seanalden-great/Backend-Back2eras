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

// namespace App\Http\Controllers;

// use App\Models\Contact;
// use Illuminate\Http\Request;

// class ContactController extends Controller
// {
//     // 1. Menampilkan semua pesan contact (Diurutkan dari yang terbaru)
//     public function index()
//     {
//         $contacts = Contact::orderBy('created_at', 'desc')->get();
//         return response()->json($contacts);
//     }

//     // 2. Menyimpan pesan dari pengunjung (Frontend)
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'name'    => 'required|string|max:255',
//             'email'   => 'required|email|max:255',
//             'type'    => 'required|string|in:tenant,sponsorship,media,volunteer,general',
//             'message' => 'required|string',
//         ]);

//         $contact = Contact::create($validated);

//         return response()->json([
//             'success' => true,
//             'message' => 'Your message has been sent successfully!',
//             'data'    => $contact
//         ], 201);
//     }

//     // 3. Menghapus pesan
//     public function destroy($id)
//     {
//         Contact::destroy($id);
//         return response()->json(['message' => 'Message deleted successfully']);
//     }
// }

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // TAMBAHKAN INI
use App\Mail\ReplyContactMail; // TAMBAHKAN INI

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return response()->json($contacts);
    }

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

    // FUNGSI BARU: Mengirim balasan via Email
    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required|string',
        ]);

        $contact = Contact::findOrFail($id);

        try {
            Mail::to($contact->email)->send(new ReplyContactMail(
                $request->reply_message,
                $contact->message,
                $contact->type
            ));

            return response()->json(['message' => 'Reply sent successfully via email']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        Contact::destroy($id);
        return response()->json(['message' => 'Message deleted successfully']);
    }
}
