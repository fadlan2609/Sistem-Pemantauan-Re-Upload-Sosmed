<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MonthlyContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role == 'admin') {
            // Dashboard admin
            $totalKaryawan = User::where('role', 'karyawan')->count();
            $totalCabang = User::select('cabang')->distinct()->count();
            $bulanIni = MonthlyContent::where('month_year', now()->startOfMonth())->first();
            
            $karyawanAktif = 0;
            if ($bulanIni) {
                $karyawanAktif = User::where('role', 'karyawan')
                    ->whereHas('reuploadLogs', function($q) use ($bulanIni) {
                        $q->where('content_id', $bulanIni->id)  // PERBAIKI: pakai content_id
                          ->where('status', 'verified');
                    })->count();
            }
            
            return view('admin.dashboard', compact('totalKaryawan', 'totalCabang', 'karyawanAktif', 'bulanIni'));
        } else {
            // Dashboard karyawan
            $kontenBulanIni = MonthlyContent::where('month_year', now()->startOfMonth())->first();
            $sudahUpload = false;
            
            if ($kontenBulanIni) {
                $sudahUpload = $kontenBulanIni->isUploadedByUser($user->id);
            }
            
            return view('karyawan.dashboard', compact('kontenBulanIni', 'sudahUpload'));
        }
    }
}