<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kategori Alat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; padding: 30px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2 style="margin: 0; text-transform: uppercase;">Laporan Daftar Kategori Alat</h2>
        <p style="margin: 5px 0;">Aplikasi Peminjaman Alat - Tasya Azahra</p>
        <p style="font-size: 10px;">Dicetak pada: {{ date('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="50">No</th>
                <th width="100">ID Kategori</th>
                <th>Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoris as $key => $k)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>#{{ $k->id }}</td>
                <td>{{ $k->nama_kategori }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; float: right; text-align: center;">
        <p>Cirebon, {{ date('d-m-Y') }}</p>
        <p>Petugas Inventaris,</p>
        <br><br><br>
        <p><b>( _________________ )</b></p>
    </div>
</body>
</html>