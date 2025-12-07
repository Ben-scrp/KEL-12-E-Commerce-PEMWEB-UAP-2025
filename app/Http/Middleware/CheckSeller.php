<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSeller
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        // Hanya role member
        if ($user->role !== 'member') {
            abort(403, 'HANYA MEMBER YANG BISA MENJADI SELLER.');
        }

        // HARUS punya store
        if (!$user->store) {
            abort(403, 'ANDA BELUM MEMBUAT TOKO.');
        }

        return $next($request);
    }

}
