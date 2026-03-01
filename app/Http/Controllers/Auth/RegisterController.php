<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UmkmProfile;
use App\Models\UmkmCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:users'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        Auth::login($user);
        return redirect()->route('customer.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    public function showUmkmForm()
    {
        $categories = UmkmCategory::where('is_active', true)->get();
        return view('auth.register-umkm', compact('categories'));
    }

    public function registerUmkm(Request $request)
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email', 'unique:users'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'umkm_name'     => ['required', 'string', 'max:200'],
            'category_id'   => ['required', 'exists:umkm_categories,id'],
            'address'       => ['required', 'string'],
            'kecamatan'     => ['required', 'string'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'whatsapp'      => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'umkm',
        ]);

        UmkmProfile::create([
            'user_id'     => $user->id,
            'name'        => $request->umkm_name,
            'slug'        => Str::slug($request->umkm_name) . '-' . $user->id,
            'category_id' => $request->category_id,
            'address'     => $request->address,
            'kelurahan'   => $request->kelurahan,
            'kecamatan'   => $request->kecamatan,
            'phone'       => $request->phone,
            'whatsapp'    => $request->whatsapp,
            'status'      => 'pending',
        ]);

        Auth::login($user);
        return redirect()->route('umkm.dashboard')->with('info', 'Akun UMKM Anda sedang menunggu verifikasi dari admin.');
    }
}
