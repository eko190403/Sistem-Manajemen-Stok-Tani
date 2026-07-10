<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,anggota',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => 'User',
            'model_id' => $user->id,
            'description' => 'Membuat user baru: ' . $user->name,
            'new_values' => $user->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return response()->json(['message' => 'User berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,anggota',
        ];

        // Jika password diisi, tambahkan validasi
        if ($request->filled('password')) {
            $rules['password'] = 'required|min:6|confirmed';
        }

        $validated = $request->validate($rules);

        $oldData = $user->toArray();
        
        // Update data user
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'User',
            'model_id' => $user->id,
            'description' => 'Mengupdate user: ' . $user->name,
            'old_values' => $oldData,
            'new_values' => $user->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return response()->json(['message' => 'User berhasil diupdate']);
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Cek apakah user mencoba menghapus dirinya sendiri
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa menghapus akun sendiri'
                ], 403);
            }

            $userData = $user->toArray();
            $userName = $user->name;
            
            // Hapus user
            $user->delete();

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'delete',
                'model' => 'User',
                'model_id' => $id,
                'description' => 'Menghapus user: ' . $userName,
                'old_values' => $userData,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User "' . $userName . '" berhasil dihapus'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update(['password' => Hash::make($request->password)]);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'reset_password',
            'model' => 'User',
            'model_id' => $user->id,
            'description' => 'Reset password user: ' . $user->name,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Password berhasil direset');
    }
}
