<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // daftar user
    public function index()
    {
        $users = User::latest()->paginate(10);

        $totalUser = User::count();

        $totalAdmin = User::where('role', 'admin')->count();

        $totalMahasiswa = User::where('role', 'user')->count();

        return view('admin.users.index', compact(
            'users',
            'totalUser',
            'totalAdmin',
            'totalMahasiswa'
        ));
    }

    // form tambah user
    public function create()
    {
        return view('admin.users.create');
    }

   // simpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:8',
            'nim'               => 'required|max:20',
            'tahun_angkatan'    => 'required',
            'program_studi'     => 'required',
            'fakultas'          => 'required',
            'phone'             => 'required',
            'role'              => 'required'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    //form edit
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // update user
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'              => 'required|max:255',
            'email'             => 'required|email|unique:users,email,' . $user->id,
            'nim'               => 'required|max:20',
            'tahun_angkatan'    => 'required',
            'program_studi'     => 'required',
            'fakultas'          => 'required',
            'phone'             => 'required',
            'role'              => 'required'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

   
    // hapus user
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}