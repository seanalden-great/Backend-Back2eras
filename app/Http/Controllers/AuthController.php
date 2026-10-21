<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 1. LOGIN ADMIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek email dan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau Password salah!'], 401);
        }

        // Buat Token (Kunci Akses)
        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Login Berhasil',
            'user' => $user,
            'token' => $token
        ]);
    }

    // 2. LOGOUT ADMIN
    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    // 3. UPDATE PROFIL (Nama, Email, & Password Baru)
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6' // Password opsional, diisi jika ingin diubah
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json(['message' => 'Profil berhasil diperbarui', 'user' => $user]);
    }

    // 4. FORGOT PASSWORD (Kirim password sementara ke Email via SMTP)
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email tidak terdaftar di sistem admin'], 404);
        }

        // Generate password baru acak (8 karakter)
        $newPassword = Str::random(8);
        $user->password = Hash::make($newPassword);
        $user->save();

        // Kirim email menggunakan fitur SMTP yang sudah kita buat sebelumnya
        Mail::raw("Seseorang meminta reset password untuk akun Admin BACK2ERAS.\n\nPassword baru Anda adalah: $newPassword\n\nSegera login dan ubah password ini di menu Update Profile.", function($msg) use ($user) {
            $msg->to($user->email)->subject('BACK2ERAS Admin - Password Reset');
        });

        return response()->json(['message' => 'Password baru telah dikirim ke email Anda.']);
    }
}