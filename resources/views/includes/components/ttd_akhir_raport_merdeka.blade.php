<div class="col-md-12" style="margin-top: 20px;">
    <table width="98%" class="table-collapse table-nilai font-size-9">
        <tr style="">
            <td width="27%">
                Mengetahui Orang Tua/Wali
            </td>
            <td>

            </td>
            <td width="30%">
                <span>
                    Depok, {{ ($kelas_wb->kelas_detail->tahun_akademik->tgl_raport != NULL) ? Carbon\Carbon::parse($kelas_wb->kelas_detail->tahun_akademik->tgl_raport)->translatedFormat('d F Y') : Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </span>
                <br>
                <span>
                    Penanggung jawab Rombel
                </span>
            </td>
        </tr>
        <tr style="">
            <td>
                @php
                $defaultTtdPath = public_path('images/white.png');
                $imageBase64 = base64_encode(file_get_contents($defaultTtdPath));
            @endphp

            <img src="data:image/png;base64,{{ $imageBase64 }}" alt="TTD Kosong" style="height: 100px;">
                <br>
                <br>


                @php
    $ayah = $kelas_wb->wb_detail->nama_ayah ?? null;
    $ibu = $kelas_wb->wb_detail->nama_ibu ?? null;
    $wali = $kelas_wb->wb_detail->nama_wali ?? null;

    if ($ayah && $ibu) {
        // Ayah dan ibu ada → tampilkan keduanya
        $hasil = $ibu . ' & ' . $ayah;
    } elseif ($ayah) {
        // Hanya ayah → tampilkan ayah
        $hasil = $ayah;
    } elseif ($ibu) {
        // Hanya ibu → tampilkan ibu
        $hasil = $ibu;
    } elseif ($wali) {
        // Ayah dan ibu kosong → tampilkan wali
        $hasil = $wali;
    } else {
        $hasil = '-';
    }
@endphp

<span>{{ $hasil }}</span>


            </td>
            <td>
            </td>
            <td >
                @php
                $defaultTtdPath = public_path('images/white.png');
                $url = $data_ttd['url_ttd_pj'] ?? null;

                // Ambil path lokal dari URL
                $isValidLocal = $url && !filter_var($url, FILTER_VALIDATE_URL);
                $parsedUrl = $url ? parse_url($url, PHP_URL_PATH) : null;
                $relativePath = $parsedUrl ? ltrim($parsedUrl, '/') : null;
                $fullPath = $relativePath ? public_path($relativePath) : $defaultTtdPath;
            @endphp

            @if ($relativePath && file_exists($fullPath))
                <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents($fullPath)) }}" alt="TTD" style="height: 100px;"> <br>
            @else
                <img src="{{ asset('images/white.png') }}" style="height: 100px;">
            @endif


                <br>
                <span class="letter-spacing-sm">
                    {{ $data_ttd['nama_pj_rombel'] ?? '-' }}
                </span>
                <br>
                <span>
                    NIP: {{ $data_ttd['nip_pj_rombel'] ?? '-' }}
                </span>
            </td>
        </tr>
        <tr style="">
            <td >
            </td>
            <td class="text-center">
                <span class="">
                    Mengetahui:
                </span>
                <br>
                <span class="">
                    Kepala PKBM GENERASI JUARA
                </span>
                <br>
                @if ($data_ttd && $data_ttd['url_ttd_ketua'] != '')
                    <img src="{{'data:image/png;base64,' . base64_encode(file_get_contents(@$data_ttd['url_ttd_ketua']))}}" alt="image" style="height: 100px;"> <br>
                @else
                    <img src="{{ public_path($data_ttd['url_ttd_ketua'] ?? '/images/white.png') }}" style="height: 100px;">
                @endif

                <br>
                <span class="">
                    {{ $data_ttd['nama_ketua_pkbm'] ?? '-' }}
                </span>

                <br>
                <span>
                    NIP: {{ $data_ttd['nip_ketua_pkbm'] ?? '-' }}
                </span>
            </td>
            <td>
            </td>
        </tr>
    </table>
</div>