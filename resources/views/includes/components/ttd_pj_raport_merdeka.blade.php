<table width="98%" class="table-collapse table-nilai font-size-12" style="margin-top: 24px;">
    <tr style="">
        <td width="27%">

        </td>
        <td>
        </td>
        <td width="30%">
            <span>
                Depok, {{ ($kelas_wb->kelas_detail->tahun_akademik->tgl_raport != NULL) ? Carbon\Carbon::parse($kelas_wb->kelas_detail->tahun_akademik->tgl_raport)->translatedFormat('d F Y') : Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </span>
            <br>
            <span>
                Wali Kelas
            </span>
        </td>
    </tr>
    <tr style="">
        <td>
        </td>
        <td>
        </td>
        <td >
            @php
            $defaultTtdPath = public_path('images/white.png');
            $relativePath = isset($data_ttd['url_ttd_pj']) ? str_replace(url('/'), '', $data_ttd['url_ttd_pj']) : null;
            $fullPath = $relativePath ? public_path($relativePath) : $defaultTtdPath;
            @endphp

            @if ($relativePath && file_exists($fullPath))
                <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents($fullPath)) }}" alt="image" style="height: 100px;"> <br>
            @else
                <img src="{{ asset('images/white.png') }}" alt="placeholder" style="height: 100px;">
            @endif
            <br>

            <span class="letter-spacing-sm">
                {{ $data_ttd->nama_pj_rombel ?? '-' }}
            </span>
            <br>
            <span>
                NIP: {{ $data_ttd->nip_pj_rombel ?? '-' }}
            </span>
        </td>
    </tr>
</table>