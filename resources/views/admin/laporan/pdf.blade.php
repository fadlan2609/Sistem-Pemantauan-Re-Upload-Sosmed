<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Re-Upload - {{ $bulan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #1e3a5f;
        }
        .header p {
            margin: 5px 0;
            font-size: 11px;
        }
        .summary {
            margin-bottom: 20px;
        }
        .summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .info-konten {
            background: #f5f5f5;
            padding: 10px;
            margin-bottom: 20px;
            border-left: 3px solid #1e3a5f;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data th,
        table.data td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }
        table.data th {
            background: #f0f0f0;
            font-weight: bold;
        }
        .aktif {
            color: green;
            font-weight: bold;
        }
        .tidak-aktif {
            color: red;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BPRS AMANAH BANGSA</h1>
        <p>Laporan Pemantauan Re-Upload Sosial Media</p>
        <p><strong>{{ $bulan }}</strong> | {{ $cabang }}</p>
    </div>
    
    <div class="summary">
        <table>
            <tr><td width="30%"><strong>Total Karyawan</strong></td><td>: {{ $total_karyawan }}</td></tr>
            <tr><td><strong>Karyawan Aktif</strong></td><td>: {{ $total_aktif }}</td></tr>
            <tr><td><strong>Karyawan Tidak Aktif</strong></td><td>: {{ $total_tidak_aktif }}</td></tr>
            <tr><td><strong>Persentase Keaktifan</strong></td><td>: {{ $persentase_keaktifan }}%</td></tr>
        </table>
    </div>
    
    <div class="info-konten">
        <strong>Informasi Konten Wajib:</strong><br>
        Platform: {{ ucfirst($konten->platform) }}<br>
        Deadline: {{ date('d-m-Y', strtotime($konten->deadline_date)) }}<br>
        Link Konten: {{ $konten->original_link }}
    </div>
    
    <!-- Tabel TANPA POSISI -->
    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Cabang</th>
                <th>Tanggal Upload</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['nama'] }}</td>
                <td>{{ $item['cabang'] }}</td>
                <td>{{ $item['tanggal_upload'] }}</td>
                <td class="{{ $item['status'] == 'Aktif' ? 'aktif' : 'tidak-aktif' }}">{{ $item['status'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak pada: {{ $tanggal_cetak }}
    </div>
</body>
</html>