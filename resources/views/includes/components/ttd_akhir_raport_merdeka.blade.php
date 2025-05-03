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
            <td class="border-bottom-sm">
            </td>
            <td>
            </td>
            <td >
                @if ($data_ttd && isset($data_ttd['url_ttd_pj']) && $data_ttd['url_ttd_pj'] != '' && filter_var($data_ttd['url_ttd_pj'], FILTER_VALIDATE_URL) !== false)
                    <img src="{{'data:image/png;base64,' . base64_encode(file_get_contents(@$data_ttd['url_ttd_pj']))}}" alt="image" style="height: 100px;"> <br>
                @else
                    <img src="{{ public_path($data_ttd['url_ttd_pj'] ?? '/images/white.png') }}" style="height: 100px;">
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