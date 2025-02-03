<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class AuthController extends Controller
{
    // Tampilkan form registrasi
    public function showRegisterForm()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'role' => 'karyawan',
            'is_approved' => false,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Tunggu konfirmasi dari admin.');
    }

    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }

    // Check if phone number already exists
    public function checkPhone(Request $request)
    {
        $exists = User::where('phone', $request->phone)->exists();
        return response()->json(['exists' => $exists]);
    }

    // Tampilkan form login
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }


    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Mencari user berdasarkan email
        $user = User::where('email', $credentials['email'])->first();

        // Mengecek apakah user ditemukan dan password cocok
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Cek apakah akun sudah disetujui oleh admin
            if (!$user->is_approved) {
                return back()->withErrors(['email' => 'Akun Anda belum disetujui oleh admin.']);
            }

            // Login dan arahkan ke dashboard
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Login berhasil! Selamat datang di dashboard.');
        }

        // Jika login gagal
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }


    // Proses logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

// Menampilkan form forgot password
public function showForgotPasswordForm()
{
    return view('auth.forgot-password');
}

// Proses forgot password
public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user) {
        $token = Password::getRepository()->create($user);

        // Kirimkan email reset password menggunakan Mailable dengan template kustom
        Mail::to($user->email)->send(new ResetPasswordMail($token, $user->email));

        return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
    }

    return back()->withErrors(['email' => 'Email tidak ditemukan.']);
}

// Menampilkan halaman reset password
public function showResetPasswordForm(Request $request, $token = null)
{
    return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
}

// Proses reset password
public function resetPassword(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'new_password' => 'required|string|min:8|confirmed',
        'new_password_confirmation' => 'required',
        'token' => 'required',
    ]);

    // Lakukan reset password
    $status = Password::reset(
        [
            'email' => $request->email,
            'password' => $request->new_password,
            'token' => $request->token,
        ],
        function ($user) use ($request) {
            // Menggunakan new_password, bukan password
            $user->password = Hash::make($request->new_password);
            $user->save();
        }
    );

    // Periksa status
    if ($status == Password::PASSWORD_RESET) {
        // Redirect atau beri respon sukses
        return redirect()->route('login')->with('status', 'Password berhasil direset');
    } else {
        // Error handling jika reset password gagal
        return back()->withErrors(['email' => [trans($status)]]);
    }
}


public function showResetPasswordFormProfile()
{
    return view('auth.reset-password-profile');
}

public function updatePasswordFromProfile(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed|different:old_password',
    ]);

    $user = auth()->user();

    // Periksa apakah old_password sesuai
    if (!Hash::check($request->old_password, $user->password)) {
        return redirect()->back()->withErrors(['old_password' => 'Password lama Anda salah.']);
    }

    // Update password
    $user->password = Hash::make($request->new_password);
    $user->save();

    // Redirect ke halaman profil dengan pesan sukses
    return redirect()->route('profile')->with('success', 'Password berhasil diperbarui.');
}

}
