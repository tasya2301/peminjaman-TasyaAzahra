<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Alat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; color: #000; margin-bottom: 0; }
        .text-center { text-align: center; }
        
        /* Sembunyikan tombol print saat kertas dicetak */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()"> <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px; background: #ec4899; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Klik Cetak
        </button>
    </div>

    <h2>LAPORAN PEMINJAMAN ALAT</h2>
    <p class="text-center">Tanggal Cetak: {{ date('d-m-Y') }}</p>
    
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Peminjam</th>
                <th>Nama Alat</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $key => $p)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $p->user->name ?? 'N/A' }}</td>
                <td>{{ $p->alat->nama_alat ?? 'N/A' }}</td>
                <td>{{ $p->tgl_pinjam }}</td>
                <td>{{ strtoupper($p->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>