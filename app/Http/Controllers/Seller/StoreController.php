<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function create()
    {
        if (Auth::user()->store) {
            return redirect()->route('seller.dashboard');
        }
        return view('seller.store.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name',
            'domain' => 'required|string|max:255|unique:stores,domain',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'address' => 'required|string',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('store-logos', 'public');
        }

        Store::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'domain' => $request->domain,
            'logo' => $logoPath,
            'description' => $request->description,
            'address' => $request->address,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Toko berhasil dibuat!');
    }

    public function edit()
    {
        $store = Auth::user()->store;
        if (!$store) {
            return redirect()->route('store.register');
        }
        return view('seller.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = Auth::user()->store;
        if (!$store) {
            return redirect()->route('store.register');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name,' . $store->id,
            'domain' => 'required|string|max:255|unique:stores,domain,' . $store->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'address' => 'required|string',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($store->logo && Storage::disk('public')->exists($store->logo)) {
                Storage::disk('public')->delete($store->logo);
            }
            $store->logo = $request->file('logo')->store('store-logos', 'public');
        }

        $store->update([
            'name' => $request->name,
            'domain' => $request->domain,
            'description' => $request->description,
            'address' => $request->address,
        ]);

        return redirect()->route('seller.profile')->with('success', 'Profil toko berhasil diperbarui!');
    }
}
