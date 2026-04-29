<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pengguna</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; padding: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        h2 { text-align: center; text-transform: uppercase; margin-bottom: 5px; }
        .info { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="info">
        <h2>Laporan Data Pengguna</h2>
        <p>Aplikasi Peminjaman Alat - Tasya Azahra</p>
        <p>Tanggal Cetak: {{ date('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role/Level</th>
                <th>Tanggal Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $key => $u)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ strtoupper($u->role) }}</td>
                <td>{{ $u->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; float: right; text-align: center;">
        <p>Cirebon, {{ date('d-m-Y') }}</p>
        <p>Petugas Administrasi,</p>
        <br><br><br>
        <p><b>( ........................... )</b></p>
    </div>

</body>
</html>