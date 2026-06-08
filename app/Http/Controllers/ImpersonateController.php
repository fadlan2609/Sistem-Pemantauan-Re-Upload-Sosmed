<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    /**
     * Menampilkan daftar karyawan untuk login sebagai
     * Route: GET /admin/impersonate
     */
    public function index()
    {
        // Ambil semua karyawan
        $karyawan = User::where('role', 'karyawan')
            ->orderBy('cabang')
            ->orderBy('name')
            ->get();
        
        return view('admin.impersonate.index', compact('karyawan'));
    }
    
    /**
     * Login sebagai karyawan tertentu
     * Route: POST /admin/impersonate/{id}
     */
    public function loginAs($id)
    {
        // Cari karyawan
        $karyawan = User::findOrFail($id);
        
        // Pastikan role-nya karyawan
        if ($karyawan->role != 'karyawan') {
            return redirect()->back()->with('error', 'Hanya bisa login sebagai karyawan');
        }
        
        // Simpan session original admin
        session([
            'impersonate_as' => $karyawan->id,
            'impersonate_original_user' => Auth::id(),
            'impersonate_original_role' => Auth::user()->role,
            'impersonate_original_name' => Auth::user()->name,
        ]);
        
        // Login sebagai karyawan
        Auth::loginUsingId($karyawan->id);
        
        return redirect()->route('dashboard')->with('success', 
            '✅ Anda sekarang login sebagai: ' . $karyawan->name . ' (' . $karyawan->cabang . ')');
    }
    
    /**
     * Kembali ke akun admin (logout dari impersonate)
     * Route: GET /admin/impersonate/logout
     * Route juga support POST untuk keamanan
     */
    public function logoutAs(Request $request)
    {
        // Ambil data original admin dari session
        $originalUserId = session('impersonate_original_user');
        $originalRole = session('impersonate_original_role');
        $originalName = session('impersonate_original_name');
        
        // Validasi session
        if ($originalUserId && $originalRole == 'admin') {
            // Hapus session impersonate
            session()->forget([
                'impersonate_as', 
                'impersonate_original_user', 
                'impersonate_original_role',
                'impersonate_original_name'
            ]);
            
            // Login kembali sebagai admin
            Auth::loginUsingId($originalUserId);
            
            return redirect()->route('dashboard')->with('success', 
                '✅ Kembali ke akun admin: ' . $originalName);
        }
        
        // Jika tidak ada session impersonate, redirect ke login
        return redirect()->route('login')->with('error', 'Sesi tidak valid');
    }
}