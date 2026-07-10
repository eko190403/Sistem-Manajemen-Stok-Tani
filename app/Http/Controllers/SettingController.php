<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SettingController extends Controller
{
    public function index()
    {
        // Check if settings table exists
        if (!Schema::hasTable('settings')) {
            return view('admin.settings.index', [
                'settings' => collect([]),
                'tableNotExists' => true
            ]);
        }
        
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'address' => 'nullable|string',
            'min_stock_alert' => 'required|numeric|min:0',
            'enable_notifications' => 'nullable|boolean',
        ]);
        
        foreach ($validated as $key => $value) {
            Setting::set($key, $value ?? '');
        }
        
        return back()->with('success', 'Pengaturan berhasil disimpan');
    }
}
