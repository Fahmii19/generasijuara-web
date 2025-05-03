<table style="width: 100%;">
    <tr>
        <td class="font-size-10" style="padding: 3px 10px 3px;" width="23%">Nama Satuan Pendidikan </td>
        <td class="font-size-10" width="5%">: </td>
        <td class="font-size-10 letter-spacing-sm" width="40%" style="padding: 3px 10px 3px 0;">
                <b>PKBM GENERASI JUARA</b>
        </td>
        <td >

        </td>
        <td width="27%" class="font-size-10 letter-spacing-sm">
            Kelas
            <span style="margin-left:66px;">
                &emsp;:
            </span>
            <span>{{@$kelas_wb->kelas_detail->kelas}}</span>
        </td>
    </tr>
    <tr>
        <td class="font-size-10" style="padding: 3px 10px 3px;" width="20%" rowspan="2">Alamat </td>
        <td class="font-size-10" width="5%" rowspan="2">: </td>
        <td class="font-size-10" style="padding: 3px 10px 3px 0;" width="40%" rowspan="2">{{ $kelas_wb->wb_detail->alamat_peserta_didik ?? '-' }}</td>
        <td rowspan="2"></td>
        <td width="27%" class="font-size-10">
            Semester
            <span style="margin-left:55px;">
                &emsp;:
            </span>
            <span class="letter-spacing-sm">
                {{$semester}}
            </span>
        </td>
    </tr>

    @if(!empty($kelas_wb->kelas_detail->jurusan))
    <tr>
        <td width="27%" class="font-size-10">
            Jurusan
            <span style="margin-left:56px;">
                :
            </span>
            <span class="letter-spacing-sm">
                {{ ($kelas_wb->kelas_detail->jurusan == 'IPA') ? "MIA" : "IIS"}}
            </span>
        </td>
    </tr>
    @else
    <tr>
        <td width="27%" class="font-size-10">
            <span style="margin-left:56px;"></span>
            <span class="letter-spacing-sm"></span>
        </td>
    </tr>
    @endif

    <tr>
        <td class="font-size-10" style="padding: 3px 10px 3px;">Nama Peserta Didik </td>
        <td class="font-size-10" width="5%">: </td>
        <td class="font-size-10 letter-spacing-sm" style="padding: 3px 10px 3px 0;"><b>{{@$kelas_wb->wb_detail->nama}}</b></td>
        <td >

        </td>
        <td width="27%" class="font-size-10">
            Fase
            <span style="margin-left:75px;">
                &emsp;:
            </span>
            <span class="letter-spacing-sm">
                {{$fase}}
            </span>
        </td>
    </tr>

    <tr>
        <td class="font-size-10" style="padding: 3px 10px 3px;">Nomor Induk/NISN </td>
        <td class="font-size-10" width="5%">: </td>
        <td class="font-size-10" style="padding: 3px 10px 3px 0;">{{@$kelas_wb->wb_detail->no_induk}} / {{@$kelas_wb->wb_detail->nisn}}</td>
        <td >

        </td>
        <td width="27%" class="font-size-10">
            Tahun Pelajaran
            <span style="margin-left:24px;">
                &emsp;:
            </span>
            <span class="">
                {{@$kelas_wb->kelas_detail->tahun_akademik->tahun_ajar}}
            </span>
        </td>
    </tr>
</table>