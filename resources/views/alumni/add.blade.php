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
                    <input class="form-control" id="id" type="hidden" />
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nis">NIS <span class="text-danger">*</span></label>
                            <input class="form-control" id="nis" name="nis" type="text" placeholder="" value="" required />
                            <div class="invalid-feedback">NIS wajib diisi</div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nisn">NISN <span class="text-danger">*</span></label>
                            <input class="form-control" id="nisn" name="nisn" placeholder="" value="" required />
                            <div class="invalid-feedback">NISN wajib diisi</div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required></select>
                            <div class="invalid-feedback">Jenis kelamin wajib dipilih</div>
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nama">Nama Alumni (sesuai AKTE) <span class="text-danger">*</span></label>
                            <input class="form-control" id="nama" name="nama" type="text" placeholder="" value="" required />
                            <div class="invalid-feedback">Nama wajib diisi</div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="no_hp">HP Alumni (WA Aktif) <span class="text-danger">*</span></label>
                            <input class="form-control" id="no_hp" name="no_hp" type="text" placeholder="" value="" required />
                            <div class="invalid-feedback">Nomor HP wajib diisi</div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="email">Email</label>
                            <input class="form-control" id="email" name="email" placeholder="" value="" type="email" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="paket">Paket <span class="text-danger">*</span></label>
                            <select class="form-control" id="paket" name="paket" required></select>
                            <div class="invalid-feedback">Paket wajib dipilih</div>
                        </div>
                        <div class="col-md-4">
                            <label class="mb-1" for="tahun_akademik">Tahun Akademik <span class="text-danger">*</span></label>
                            <select class="form-control" id="tahun_akademik" style="width: 100%;" name="tahun_akademik_id" required>
                            </select>
                            <div class="invalid-feedback">Tahun akademik wajib dipilih</div>
                        </div>
                    </div>
                    <hr>
                    <h1>Kegiatan Sekarang</h1>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="lanjut_kuliah">Lanjut <span class="text-danger">*</span></label>
                            <select class="form-control" id="lanjut_kuliah" name="lanjut_kuliah" required></select>
                            <div class="invalid-feedback">Status lanjut wajib dipilih</div>
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
    // Form Reset Functionality
    $('#resetFormBtn').on('click', function(e){
        resetForm();
    });

    function resetForm() {
        $('#formAlumni').trigger("reset");
        // Reset select2 values
        $('#jenis_kelamin').val('').trigger('change');
        $('#paket').val('a').trigger('change');
        $('#tahun_akademik').val('').trigger('change');
        $('#lanjut_kuliah').val('').trigger('change'); // Diubah dari '0' ke ''
        // Remove validation classes
        $('.is-invalid').removeClass('is-invalid');
    }

   // Initialize Select2 Elements
    function initializeSelect2Elements() {
        // Initialize Jenis Kelamin
        $('#jenis_kelamin').select2({
            theme: 'bootstrap4',
            data: [
                {id: '', text: '-- Pilih Jenis Kelamin --'},
                {id: 'l', text: 'Laki-laki'},
                {id: 'p', text: 'Perempuan'}
            ]
        });

        // Initialize Lanjut Kuliah - Diubah
        $('#lanjut_kuliah').select2({
            theme: 'bootstrap4',
            data: [
                {id: '', text: '-- Pilih Lanjut --'},
                {id: '1', text: 'Ya'},
                {id: '0', text: 'Tidak'}
            ]
        });

        // Initialize Paket
        $('#paket').select2({
            theme: 'bootstrap4',
            data: [
                {id: '', text: '-- Pilih Paket --'},
                {id: 'a', text: 'PAKET A'},
                {id: 'b', text: 'PAKET B'},
                {id: 'c', text: 'PAKET C'}
            ]
        });

        // Initialize Tahun Akademik
        $('#tahun_akademik').select2({
            theme: 'bootstrap4'
        });
    }

    // Get Tahun Akademik Data
    function getTahunAkademik() {
        $.ajax({
            type: "POST",
            url: "{{ route('ajax.tahun_akademik.list') }}",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(res) {
                console.log('Response data:', res);

                if (!res.data || !Array.isArray(res.data)) {
                    console.error('Invalid response format');
                    $('#tahun_akademik').html('<option value="">Gagal memuat data</option>');
                    return;
                }

                // Prepare options
                var options = res.data.map(row =>
                    `<option value="${row.id}">${row.kode} - ${row.keterangan}</option>`
                ).join('');

                // Set options
                $('#tahun_akademik').html('<option value="">-- Pilih Tahun Akademik --</option>' + options);

                // Set default value (newest year)
                if (res.data.length > 0) {
                    res.data.sort((a, b) => b.kode.localeCompare(a.kode));
                    const defaultId = res.data[0].id;
                    $('#tahun_akademik').val(defaultId).trigger('change');
                }

                // Set form values if alumni data exists
                setFormValues();
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                $('#tahun_akademik').html('<option value="">Gagal memuat data</option>');
            }
        });
    }

    // Set Form Values from Alumni Data
    function setFormValues() {
        @if(isset($alumni) && $alumni)
            // Set select values
            $('#jenis_kelamin').val("{{ $alumni->jenis_kelamin ?? '' }}").trigger('change');
            $('#paket').val("{{ $alumni->paket ?? 'a' }}").trigger('change');
            $('#tahun_akademik').val("{{ $alumni->tahun_akademik_id ?? '' }}").trigger('change');
            $('#lanjut_kuliah').val("{{ $alumni->lanjut_kuliah ?? '' }}").trigger('change');

            // Set input values
            $('#id').val("{{ $alumni->id ?? '' }}");
            $('#nis').val("{{ $alumni->nis ?? '' }}");
            $('#nisn').val("{{ $alumni->nisn ?? '' }}");
            $('#nama').val("{{ $alumni->nama ?? '' }}");
            $('#no_hp').val("{{ $alumni->no_hp ?? '' }}");
            $('#email').val("{{ $alumni->email ?? '' }}");
            $('#nama_sekolah').val("{{ $alumni->nama_sekolah ?? '' }}");
            $('#surat_penerimaan').val("{{ $alumni->surat_penerimaan ?? '' }}");
            $('#prodi').val("{{ $alumni->prodi ?? '' }}");
            $('#usaha').val("{{ $alumni->usaha ?? '' }}");
            $('#sertifikat').val("{{ $alumni->sertifikat ?? '' }}");
        @else
            // Set default values for new form
            $('#jenis_kelamin').val('').trigger('change');
            $('#paket').val('a').trigger('change');
            $('#lanjut_kuliah').val('').trigger('change');
        @endif
    }

    // Validate Form
    function validateForm() {
        let isValid = true;

        // Check required fields
        const requiredFields = [
            'nis', 'nisn', 'nama', 'no_hp', 'jenis_kelamin',
            'paket', 'tahun_akademik_id', 'lanjut_kuliah'
        ];

        requiredFields.forEach(field => {
            const element = $(`[name="${field}"]`);
            const value = element.val();

            // Special handling for select2
            if (element.hasClass('select2-hidden-accessible')) {
                if (value === null || value === '') {
                    element.addClass('is-invalid');
                    isValid = false;
                } else {
                    element.removeClass('is-invalid');
                }
            } else {
                if (!value) {
                    element.addClass('is-invalid');
                    isValid = false;
                } else {
                    element.removeClass('is-invalid');
                }
            }
        });

        return isValid;
    }

    // Form Submission
    $('#submitAlumniBtn').on('click', function(e){
        e.preventDefault();

        // Validate form first
        if (!validateForm()) {
            swalError({text: 'Harap lengkapi semua field yang wajib diisi'});
            return;
        }

        var form = $("#formAlumni");
        enableLoadingButton("#submitAlumniBtn");

        $.ajax({
            type: "POST",
            url: "{{ route('web.sialum.alumni.store') }}",
            data: form.serialize(),
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

    // Document Ready
    $(document).ready(function() {
        initializeSelect2Elements();
        getTahunAkademik();

        // Add validation on blur for required fields
        $('[required]').on('blur', function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Special handling for select2 elements
        $('.select2').on('change', function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });
</script>

@endsection