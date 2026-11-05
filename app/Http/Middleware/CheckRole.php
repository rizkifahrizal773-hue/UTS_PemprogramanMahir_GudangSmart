<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Sesi Anda telah berakhir atau belum login. Silakan masuk terlebih dahulu.');
        }

        $user = Auth::user();

        // Jika tidak ada peran spesifik yang ditentukan, izinkan pengguna terautentikasi
        if (empty($roles)) {
            return $next($request);
        }

        // Periksa apakah role user ada dalam daftar $roles
        if (!in_array($user->role, $roles)) {
            // Jika user adalah staff dan mencoba akses fitur khusus manager
            return redirect()->route('admin.dashboard')
                ->with('error', "Akses Ditolak: Peran '{$user->role}' tidak memiliki izin untuk mengakses tindakan tersebut.");
        }

        return $next($request);
    }
}
