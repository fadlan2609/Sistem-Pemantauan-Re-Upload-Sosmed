<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MonthlyContent;
use App\Models\ReuploadLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    // Halaman laporan
    public function index()
    {
        $bulanTersedia = MonthlyContent::select('month_year')
            ->distinct()
            ->orderBy('month_year', 'desc')
            ->get();
            
        $cabangList = ['Pematangsiantar', 'Sidamanik', 'Perdagangan', 'Kisaran', 'Stabat'];
        
        return view('admin.laporan.index', compact('bulanTersedia', 'cabangList'));
    }
    
    // Generate data laporan
    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required|date',
            'cabang' => 'required',
        ]);
        
        $bulan = $request->bulan;
        $cabang = $request->cabang;
        
        // Cari konten bulan tersebut
        $konten = MonthlyContent::where('month_year', $bulan)->first();
        
        if (!$konten) {
            return redirect()->back()->with('error', 'Belum ada konten untuk bulan tersebut');
        }
        
        // Ambil karyawan berdasarkan cabang
        $karyawan = User::where('role', 'karyawan');
        if ($cabang != 'semua') {
            $karyawan->where('cabang', $cabang);
        }
        $karyawan = $karyawan->get();
        
        // Data laporan
        $laporan = [];
        $totalAktif = 0;
        
        foreach ($karyawan as $k) {
            $log = ReuploadLog::where('user_id', $k->id)
                ->where('content_id', $konten->id)
                ->where('status', 'verified')
                ->first();
                
            $status = $log ? 'Aktif' : 'Tidak Aktif';
            if ($status == 'Aktif') $totalAktif++;
            
            $laporan[] = [
                'nama' => $k->name,
                'cabang' => $k->cabang,
                //'posisi' => $k->posisi,
                'email' => $k->email,
                'tanggal_upload' => $log ? date('d-m-Y', strtotime($log->uploaded_at)) : '-',
                'link_upload' => $log ? $log->uploaded_link : '-',
                'status' => $status,
            ];
        }
        
        $data = [
            'bulan' => date('F Y', strtotime($bulan)),
            'cabang' => $cabang == 'semua' ? 'Semua Cabang' : $cabang,
            'laporan' => $laporan,
            'total_karyawan' => count($karyawan),
            'total_aktif' => $totalAktif,
            'total_tidak_aktif' => count($karyawan) - $totalAktif,
            'persentase_keaktifan' => count($karyawan) > 0 ? round(($totalAktif / count($karyawan)) * 100, 2) : 0,
            'konten' => $konten,
            'tanggal_cetak' => date('d-m-Y H:i:s'),
        ];
        
        // Simpan ke session untuk ekspor
        session(['laporan_data' => $data]);
        
        return view('admin.laporan.preview', $data);
    }
    
    // Ekspor PDF
    public function exportPdf()
    {
        $data = session('laporan_data');
        
        if (!$data) {
            return redirect()->route('admin.laporan')->with('error', 'Tidak ada data laporan');
        }
        
        $pdf = Pdf::loadView('admin.laporan.pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan_reupload_' . $data['bulan'] . '_' . $data['cabang'] . '.pdf');
    }
    
    // Ekspor Excel
    public function exportExcel()
    {
        $data = session('laporan_data');
        
        if (!$data) {
            return redirect()->route('admin.laporan')->with('error', 'Tidak ada data laporan');
        }
        
        return Excel::download(new LaporanExport($data), 'laporan_reupload_' . $data['bulan'] . '_' . $data['cabang'] . '.xlsx');
    }
}