<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function editProfile()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Update data profile user
    public function updateProfile(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        // Ambil data user yang sedang login
        $user = Auth::user();

        // Update data user
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        // Simpan perubahan
        $user->save();

        // Redirect ke halaman profil dengan pesan sukses
        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }
}
