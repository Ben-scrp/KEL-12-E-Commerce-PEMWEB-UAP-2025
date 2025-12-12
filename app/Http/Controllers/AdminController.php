<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function verification()
    {
        $stores = Store::where('is_verified', false)
                    ->with('user')
                    ->get();

        return view('admin.verification', compact('stores'));
    }


    public function verifyStore($id)
    {
        $store = Store::findOrFail($id);
        $store->is_verified = true;
        $store->save();

        return back()->with('success', 'Toko berhasil diverifikasi!');
    }


    public function rejectStore(Store $store)
    {
        // Dalam konteks ini, 'menolak' bisa berarti membiarkan false, atau menghapus? 
        // Sesuai instruksi: "mengubah stores.is_verified".
        // Karena default false, mungkin kita perlu pastikan saja dia false.
        // Atau jika ingin "Menolak" pendaftaran yang berarti user harus daftar ulang, bisa delete?
        // Tapi instruksi bilang "mengubah stores.is_verified", jadi kita set ke false saja (unsuspend jika fitur suspend)
        // Namun karena ini konteks "Verifikasi Toko", biasanya "Tolak" itu berarti tetap false.
        // Tapi untuk memberi feedback mungkin nanti bisa dikembangkan. 
        // Untuk sekarang saya buat toggle atau pastikan false.
        
        $store->update(['is_verified' => false]);
        return redirect()->back()->with('success', 'Verifikasi toko ditolak / status menjadi unverified.');
    }

    public function users()
    {
        $users = User::with('store')->latest()->get();
        return view('admin.users', compact('users'));
    }
}
