@extends('layouts.ppdb_layout')

@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><a href="#" onclick="goBackWithRefresh();"><i data-feather="arrow-left"></i></a></div>
                            Pendataan Alumni
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <form id="formAlumni">
                    @csrf
                    <input class="form-control" id="id" type="text" />
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nis">NIS</label>
                            <input class="form-control" id="nis" name="nis" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nisn">NISN</label>
                            <input class="form-control" id="nisn" name="nisn" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nama">Nama Alumni (sesuai AKTE)</label>
                            <input class="form-control" id="nama" name="nama" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="no_hp">HP Alumni (WA Aktif)</label>
                            <input class="form-control" id="no_hp" name="no_hp" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="email">Email</label>
                            <input class="form-control" id="email" name="email" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="paket">Paket</label>
                            <select class="form-control" id="paket" name="paket">
                                <option value="a">PAKET A</option>
                                <option value="b">PAKET B</option>
                                <option value="c">PAKET C</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="mb-1" for="tahun_akademik">Tahun Akademik</label>
                            <select class="form-control" id="tahun_akademik" style="width: 100%;" name="tahun_akademik_id">
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h1>Kegiatan Sekarang</h1>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="lanjut_kuliah">Lanjut</label>
                            <select class="form-control" id="lanjut_kuliah" name="lanjut_kuliah">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nama_sekolah">Nama Sekolah/Perguruan Tinggi</label>
                            <input class="form-control" id="nama_sekolah" name="nama_sekolah" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="surat_penerimaan">Surat Penerimaan</label>
                            <input class="form-control" id="surat_penerimaan" name="surat_penerimaan" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="prodi">Program Studi/Jurusan/Fakultas</label>
                            <input class="form-control" id="prodi" name="prodi" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="usaha">Kegiatan/Usaha Yang Dilakukan</label>
                            <input class="form-control" id="usaha" name="usaha" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="sertifikat">Sertifikat Prestasi</label>
                            <input class="form-control" id="sertifikat" name="sertifikat" placeholder="" value="" />
                        </div>
                    </div>

                    <hr class="my-4" />
                    <div class="d-flex justify-content-between">
                        <div>
                            <button class="btn btn-light" type="button" onclick="goBackWithRefresh();">Cancel</button>
                            <button class="btn btn-warning" type="button" id="resetFormBtn">Reset Form</button>
                        </div>
                        <button class="btn btn-primary" type="button" id="submitAlumniBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@stop

@section('style_extra')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@endsection

@section('js_extra')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>

<script>
    $('#resetFormBtn').on('click', function(e){
        resetForm();
    });

    function resetForm() {
        $('#formAlumni').trigger("reset");
    }

    getTahunAkademik();
function getTahunAkademik() {
    $.ajax({
        type: "POST",
        url: "{{route('ajax.tahun_akademik.list')}}",
        data: {
            "_token": "{{ csrf_token() }}",
        },
        success: function(res) {
            var opt_for_filter = "";
            var opt_for_input = "<option value=''>-- Pilih Salah Satu --</option>";

            $.each(res.data, function (i, row) {
                opt_for_filter += "<option value='"+row.id+"'>"+row.kode+" - "+row.keterangan+"</option>";
                opt_for_input += "<option value='"+row.id+"'>"+row.kode+" - "+row.keterangan+"</option>";
            });

            $('#tahun_akademik').html(opt_for_filter);
            $('#tahun_akademik_id').html(opt_for_input);
            $('#tahun_akademik_source').html(opt_for_input);
            $('#tahun_akademik_destination').html(opt_for_input);

            // Perbaikan utama di bagian ini
            @if(isset($alumni) && $alumni)
                $('#id').val("{{ $alumni->id ?? '' }}");
                $('#nis').val("{{ $alumni->nis ?? '' }}");
                $('#nisn').val("{{ $alumni->nisn ?? '' }}");
                $('#jenis_kelamin').val("{{ $alumni->jenis_kelamin ?? '' }}");
                $('#nama').val("{{ $alumni->nama ?? '' }}");
                $('#no_hp').val("{{ $alumni->no_hp ?? '' }}");
                $('#email').val("{{ $alumni->email ?? '' }}");
                $('#tahun_akademik').val("{{ $alumni->tahun_akademik_id ?? '' }}").trigger('change');
                $('#lanjut_kuliah').val("{{ $alumni->lanjut_kuliah ?? '' }}");
                $('#nama_sekolah').val("{{ $alumni->nama_sekolah ?? '' }}");
                $('#surat_penerimaan').val("{{ $alumni->surat_penerimaan ?? '' }}");
                $('#prodi').val("{{ $alumni->prodi ?? '' }}");
                $('#usaha').val("{{ $alumni->usaha ?? '' }}");
                $('#sertifikat').val("{{ $alumni->sertifikat ?? '' }}");
            @endif
        }
    });
}

    $("#tahun_akademik").select2({
        theme: 'bootstrap4'
    });

    $("#tahun_akademik_id").select2({
        theme: 'bootstrap4',
        dropdownParent: $("#modalKuisioner")
    });

    $("#tahun_akademik_source, #tahun_akademik_destination").select2({
        theme: 'bootstrap4',
        dropdownParent: $("#modalDuplicate")
    });

    let tahunAkademikSelected = null;
    $("#tahun_akademik").on("change", function(e) {
        tahunAkademikSelected = $("#tahun_akademik").val();
        console.log($("#tahun_akademik").val());
    });


    $('#submitAlumniBtn').on('click', function(e){
    e.preventDefault();

    var form = $("#formAlumni");
    enableLoadingButton("#submitAlumniBtn");

    // Gunakan route store yang benar
    $.ajax({
        type: "POST",
        url: "{{ route('web.sialum.alumni.store') }}",
        data: form.serialize(), // atau new FormData() jika ada upload file
        success: function(res) {
            disableLoadingButton("#submitAlumniBtn");
            if (res.success) {
                swalSuccess({
                    text: res.message,
                    withConfirmButton: true,
                    withRedirect: true,
                    redirectUrl: '{{ route("web.sialum.alumni.add") }}'
                });
            } else {
                swalError({text: res.message});
            }
        },
        error: function(response) {
            disableLoadingButton("#submitAlumniBtn");
            ajaxCallbackError(response);
        }
    });
});

</script>
@endsection