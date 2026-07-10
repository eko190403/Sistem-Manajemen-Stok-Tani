<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogService;

class AuthController extends Controller
{
    // ======================
    // Form Register
    // ======================
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'anggota', // default role anggota
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat, silakan login!');
    }

    // ======================
    // Form Login
    // ======================
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (auth()->check()) {
            return redirect()->route('dashboard.index');
        }
        
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = auth()->user();
            ActivityLogService::log('login', 'User berhasil login', 'User', $user->id);

            // Redirect ke dashboard untuk semua role
            return redirect()->route('dashboard.index')
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->withInput($request->only('email'));
    }

    // ======================
    // Logout
    // ======================
    public function logout()
    {
        ActivityLogService::log('logout', 'User logout', 'User', Auth::id());
        auth()->logout();
        return redirect()->route('login');
    }

    // ======================
    // Profile
    // ======================
    public function profile()
    {
        $user = Auth::user();
        return view('partials.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $old = $user->toArray();
        $user->update($request->only('name', 'email'));
        ActivityLogService::log('update', 'User memperbarui profil', 'User', $user->id, $old, $user->toArray());

        return response()->json(['message' => 'Profil berhasil diperbarui!']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Password saat ini salah!'], 422);
        }

        $user->update(['password' => Hash::make($request->password)]);
        ActivityLogService::log('update', 'User mengubah password', 'User', $user->id);

        return response()->json(['message' => 'Password berhasil diubah!']);
    }
}
