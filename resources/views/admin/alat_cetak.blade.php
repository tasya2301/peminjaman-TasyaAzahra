<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris Alat</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2 style="margin: 0;">DAFTAR INVENTARIS ALAT</h2>
        <p style="margin: 5px 0;">Aplikasi Peminjaman Alat - Tasya Azahra</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Kategori</th>
                <th>Harga Per Hari</th>
                <th>Stok Tersedia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alats as $key => $a)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $a->nama_alat }}</td>
                <td>{{ $a->kategori->nama_kategori ?? '-' }}</td>
                <td>Rp {{ number_format($a->harga_per_hari, 0, ',', '.') }}</td>
                <td>{{ $a->stok }} Unit</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; float: right; text-align: center;">
        <p>Cirebon, {{ date('d-m-Y') }}</p>
        <p>Mengetahui,</p>
        <br><br>
        <p><b>Administrasi</b></p>
    </div>
</body>
</html>