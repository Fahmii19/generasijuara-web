<!DOCTYPE html>
<html>
<head>
    <title>Pendataan Alumni Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }
        h3 {
            color: #3498db;
            margin-top: 20px;
        }
        p {
            margin: 8px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <h2>Data Alumni Baru</h2>

    <h3>Data Pribadi</h3>
    <p><strong>NIS:</strong> {{ $alumniData['nis'] ?? '-' }}</p>
    <p><strong>NISN:</strong> {{ $alumniData['nisn'] ?? '-' }}</p>
    <p><strong>Nama:</strong> {{ $alumniData['nama'] ?? '-' }}</p>
    <p><strong>Jenis Kelamin:</strong>
        @if(isset($alumniData['jenis_kelamin']))
            {{ $alumniData['jenis_kelamin'] == 'l' ? 'Laki-laki' : 'Perempuan' }}
        @else
            -
        @endif
    </p>
    <p><strong>No HP:</strong> {{ $alumniData['no_hp'] ?? '-' }}</p>
    <p><strong>Email:</strong> {{ $alumniData['email'] ?? '-' }}</p>
    <p><strong>Paket:</strong>
        @if(isset($alumniData['paket']))
            @php
                $paketMapping = [
                    'a' => 'PAKET A',
                    'b' => 'PAKET B',
                    'c' => 'PAKET C'
                ];
                echo $paketMapping[$alumniData['paket']] ?? strtoupper($alumniData['paket']);
            @endphp
        @else
            -
        @endif
    </p>

    <h3>Kegiatan Sekarang</h3>
    <p><strong>Lanjut Kuliah:</strong>
        @if(isset($alumniData['lanjut_kuliah']))
            {{ $alumniData['lanjut_kuliah'] ? 'Ya' : 'Tidak' }}
        @else
            -
        @endif
    </p>

    @if(isset($alumniData['lanjut_kuliah']) && $alumniData['lanjut_kuliah'])
        <p><strong>Nama Sekolah/Perguruan Tinggi:</strong> {{ $alumniData['nama_sekolah'] ?? '-' }}</p>
        <p><strong>Program Studi:</strong> {{ $alumniData['prodi'] ?? '-' }}</p>
    @else
        <p><strong>Kegiatan/Usaha:</strong> {{ $alumniData['usaha'] ?? '-' }}</p>
    @endif

    <div class="footer">
        <p>Data diterima pada: {{ now()->format('d F Y H:i') }}</p>
        <p>Terima kasih telah melakukan pendataan alumni.</p>
    </div>
</body>
</html>