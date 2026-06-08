<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromArray, WithHeadings, WithStyles
{
    protected $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function array(): array
    {
        $rows = [];
        
        // Header informasi tambahan
        $rows[] = ['LAPORAN RE-UPLOAD SOSIAL MEDIA BPRS AMANAH BANGSA'];
        $rows[] = ['Bulan', $this->data['bulan']];
        $rows[] = ['Cabang', $this->data['cabang']];
        $rows[] = ['Tanggal Cetak', $this->data['tanggal_cetak']];
        $rows[] = ['Konten Platform', ucfirst($this->data['konten']->platform)];
        $rows[] = ['Deadline', date('d-m-Y', strtotime($this->data['konten']->deadline_date))];
        $rows[] = [''];
        $rows[] = ['RINGKASAN'];
        $rows[] = ['Total Karyawan', $this->data['total_karyawan']];
        $rows[] = ['Karyawan Aktif', $this->data['total_aktif']];
        $rows[] = ['Karyawan Tidak Aktif', $this->data['total_tidak_aktif']];
        $rows[] = ['Persentase Keaktifan', $this->data['persentase_keaktifan'] . '%'];
        $rows[] = [''];
        $rows[] = ['DETAIL KARYAWAN'];
        $rows[] = ['No', 'Nama', 'Cabang', 'Posisi', 'Email', 'Tanggal Upload', 'Link Upload', 'Status'];
        
        $no = 1;
        foreach ($this->data['laporan'] as $item) {
            $rows[] = [
                $no++,
                $item['nama'],
                $item['cabang'],
                $item['posisi'],
                $item['email'],
                $item['tanggal_upload'],
                $item['link_upload'],
                $item['status'],
            ];
        }
        
        return $rows;
    }
    
    public function headings(): array
    {
        return [];
    }
    
    public function styles(Worksheet $sheet)
    {
        // Style header (bold)
        $sheet->getStyle('A1:A14')->getFont()->setBold(true);
        $sheet->getStyle('A14:H14')->getFont()->setBold(true);
        
        // Auto size kolom
        foreach(range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        return [];
    }
}