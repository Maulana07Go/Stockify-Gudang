<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('manager.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Update username
        $user->name = $request->name;

        // Jika ada file foto baru yang diunggah
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }

            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
