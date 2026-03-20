<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses()->orderByDesc('is_default')->get();
        return view('customer.address.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label'       => 'nullable|string|max:50',
            'address'     => 'required|string',
            'city'        => 'nullable|string|max:100',
            'province'    => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'is_default'  => 'nullable|boolean',
        ]);

        $data['is_default'] = $request->boolean('is_default');

        $user = auth()->user();

        // Jika centang utama, reset semua dulu
        if ($data['is_default']) {
            $user->addresses()->update(['is_default' => false]);
        }

        // Alamat pertama otomatis jadi utama
        if ($user->addresses()->count() === 0) {
            $data['is_default'] = true;
        }

        // Isi recipient_name & phone dari user jika kolom ada
        $data['recipient_name'] = auth()->user()->name;
        $data['phone']          = auth()->user()->phone ?? '-';

        $user->addresses()->create($data);

        return back()->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function destroy(Address $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);
        $address->delete();
        return back()->with('success', 'Alamat dihapus.');
    }

    public function setDefault(Address $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);
        auth()->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);
        return back()->with('success', 'Alamat utama diperbarui.');
    }
}