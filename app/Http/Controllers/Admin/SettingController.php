<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        $setting->site_name = $request->site_name;

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($setting->logo) {
                Storage::delete('public/' . $setting->logo);
            }

            // Simpan logo baru
            $path = $request->file('logo')->store('logos', 'public');
            $setting->logo = $path;
        }

        $setting->save();

        return redirect()->route('admin.setting.index')->with('success', 'Pengaturan berhasil diperbarui');
    }
}
