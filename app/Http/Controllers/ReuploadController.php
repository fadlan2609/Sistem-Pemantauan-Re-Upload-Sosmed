<?php

namespace App\Http\Controllers;

use App\Models\MonthlyContent;
use App\Models\ReuploadLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReuploadController extends Controller
{
    /**
     * Form untuk karyawan mengisi re-upload
     * Route: GET /karyawan/reupload/{contentId}
     */
    public function create($contentId)
    {
        $konten = MonthlyContent::findOrFail($contentId);
        
        // Cek apakah sudah pernah upload
        $existing = ReuploadLog::where('user_id', Auth::id())
            ->where('content_id', $contentId)
            ->first();
            
        if ($existing) {
            return redirect()->route('karyawan.dashboard')
                ->with('error', 'Anda sudah pernah re-upload konten ini');
        }
        
        return view('karyawan.reupload', compact('konten'));
    }
    
    /**
     * Simpan re-upload dari karyawan
     * Route: POST /karyawan/reupload/{contentId}
     */
    public function store(Request $request, $contentId)
    {
        $request->validate([
            'uploaded_link' => 'required|url',
            'uploaded_at' => 'required|date',
        ]);
        
        // Cek apakah sudah pernah upload
        $existing = ReuploadLog::where('user_id', Auth::id())
            ->where('content_id', $contentId)
            ->first();
            
        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah pernah re-upload konten ini');
        }
        
        // Cek apakah konten exist
        $konten = MonthlyContent::findOrFail($contentId);
        
        ReuploadLog::create([
            'user_id' => Auth::id(),
            'content_id' => $contentId,
            'uploaded_link' => $request->uploaded_link,
            'uploaded_at' => $request->uploaded_at,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('karyawan.dashboard')
            ->with('success', 'Re-upload berhasil dilaporkan, menunggu verifikasi admin');
    }
    
    /**
     * Admin melihat daftar pending upload
     * Route: GET /admin/verifikasi
     */
    public function pendingVerification()
    {
        $pendingLogs = ReuploadLog::with(['user', 'content'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Data verifikasi yang sudah dilakukan
        $verifiedLogs = ReuploadLog::with(['user', 'content', 'verifier'])
            ->where('status', 'verified')
            ->orderBy('updated_at', 'desc')
            ->limit(20)
            ->get();
            
        return view('admin.verifikasi', compact('pendingLogs', 'verifiedLogs'));
    }
    
    /**
     * Admin verifikasi upload (VALIDASI SATU PER SATU)
     * Route: POST /admin/verifikasi/{id}
     */
    public function verify($logId)
    {
        $log = ReuploadLog::findOrFail($logId);
        
        // Update status menjadi verified
        $log->update([
            'status' => 'verified',
            'verified_by' => Auth::id(),
        ]);
        
        // Cek apakah sedang dalam mode impersonate
        $isImpersonating = session()->has('impersonate_as');
        
        $message = '✅ Re-upload berhasil diverifikasi untuk ' . $log->user->name;
        if ($isImpersonating) {
            $message .= ' (Anda login sebagai admin melalui fitur Login as Karyawan)';
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Admin tolak / reject upload (VALIDASI TOLAK)
     * Route: DELETE /admin/verifikasi/{id}
     */
    public function reject($logId)
    {
        $log = ReuploadLog::findOrFail($logId);
        $userName = $log->user->name;
        
        // Hapus log re-upload
        $log->delete();
        
        return redirect()->back()->with('success', '❌ Re-upload dari ' . $userName . ' ditolak dan dihapus. Karyawan harus upload ulang.');
    }
    
    /**
     * Admin langsung verifikasi dari dashboard karyawan (via impersonate)
     * Route: POST /admin/verifikasi/quick/{userId}/{contentId}
     */
    public function quickVerify($userId, $contentId)
    {
        // Cek apakah ada log pending
        $log = ReuploadLog::where('user_id', $userId)
            ->where('content_id', $contentId)
            ->where('status', 'pending')
            ->first();
            
        if ($log) {
            $log->update([
                'status' => 'verified',
                'verified_by' => Auth::id(),
            ]);
            
            return redirect()->back()->with('success', '✅ Berhasil diverifikasi!');
        }
        
        return redirect()->back()->with('error', 'Tidak ditemukan pending verifikasi');
    }
    
    /**
     * Batch verifikasi (multiple)
     * Route: POST /admin/verifikasi/batch
     */
    public function batchVerify(Request $request)
    {
        $logIds = $request->input('log_ids', []);
        
        if (empty($logIds)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih');
        }
        
        $count = 0;
        $failed = 0;
        
        foreach ($logIds as $logId) {
            $log = ReuploadLog::find($logId);
            if ($log && $log->status == 'pending') {
                $log->update([
                    'status' => 'verified',
                    'verified_by' => Auth::id(),
                ]);
                $count++;
            } else {
                $failed++;
            }
        }
        
        $message = "✅ {$count} data berhasil diverifikasi";
        if ($failed > 0) {
            $message .= ", {$failed} data gagal (mungkin sudah diverifikasi sebelumnya)";
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Get reupload status for a user (AJAX)
     * Route: (Opsional untuk API)
     */
    public function getStatus($userId, $contentId)
    {
        $log = ReuploadLog::where('user_id', $userId)
            ->where('content_id', $contentId)
            ->first();
            
        if (!$log) {
            return response()->json(['status' => 'not_uploaded']);
        }
        
        return response()->json([
            'status' => $log->status,
            'uploaded_link' => $log->uploaded_link,
            'uploaded_at' => $log->uploaded_at->format('Y-m-d'),
            'verified_by' => $log->verifier ? $log->verifier->name : null,
        ]);
    }
}