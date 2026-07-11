<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil kustom.
     */



    public function editCustom(Request $request)
    {
        return view('profile.edit-profil', [
            'user' => Auth::user(),
        ]);
    }



    /**
     * Memperbarui data profil kustom ke database.
     */



    public function updateCustom(Request $request): RedirectResponse
    {
        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'nim'            => ['nullable', 'string', 'max:20'],
            'tahun_angkatan' => ['nullable', 'string', 'max:4'],
            'program_studi'  => ['nullable', 'string', 'max:100'],
            'fakultas'       => ['nullable', 'string', 'max:100'],
            'bio'            => ['nullable', 'string', 'max:500'],
            'avatar'         => ['nullable', 'image', 'max:2048'],
        ]);

        $user = Auth::user();

        $data = $request->only([
            'name', 'email', 'phone', 'nim',
            'tahun_angkatan', 'program_studi', 'fakultas', 'bio',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }



    /**
     * Menghapus akun user.
     */




    public function destroy(Request $request): RedirectResponse
    {
        Auth::user()->delete();
        Auth::logout();
        return redirect('/');
    }
}