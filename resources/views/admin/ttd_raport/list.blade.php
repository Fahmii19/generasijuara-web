@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Tanda Tangan Raport
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        {{-- <a class="btn btn-sm btn-light text-primary" href="#" id="addKelasBtn">
                            <i class="me-1" data-feather="plus"></i>
                            Add
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtKelas" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Update -->
<div class="modal fade" id="modalEdit" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Update Tanda Tangan</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit" method="POST" action="" novalidate>
                    @csrf
                    <input class="form-control" id="kelas_id" type="hidden" placeholder="">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="nama">Nama Penanggung Jawab Rombel</label>
                            <input class="form-control" id="nama_pj_rombel" type="text" placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="biaya">NIP Penanggung Jawab Rombel</label>
                            <input class="form-control" id="nip_pj_rombel" type="number" placeholder="">
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <img id="ttd_pj_preview" style="height: 150px" src="{{asset('images')}}/placeholder.png" alt="" class="img-thumbnail">
                        <br>
                        <label>
                            <input type="file" class="d-none" id="ttd_pj_file" accept="image/png, image/jpg, image/jpeg">
                            <div class="btn btn-sm btn-primary">Unggah TTD PJ Rombel</div>
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="submitTtdBtn">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Data -->
<div class="modal fade" id="modalView" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalViewLabel">Data Tanda Tangan</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tabelTandaTangan">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>TTD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="viewNIPKetua"></td>
                                <td id="viewNamaKetua"></td>
                                <td id="viewJenisKetua"></td>
                                <td id="viewTTDKetua">
                                    <img id="view_ttd_ketua" style="height: 150px" src="" alt="" class="img-thumbnail">
                                </td>
                            </tr>
                            <tr>
                                <td id="viewNIPPJ"></td>
                                <td id="viewNamaPJ"></td>
                                <td id="viewJenisPJ"></td>
                                <td id="viewTTDPJ">
                                    <img id="view_ttd_pj" style="height: 150px" src="" alt="" class="img-thumbnail">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('style_extra')

@endsection

@section('js_extra')
<script type="text/javascript">
    $(document).ready(function() {
        var table = null;
        var ttd_ketua_file = null;
        var ttd_ketua_src = null;
        var ttd_pj_file = null;
        var ttd_pj_src = null;

        table = $('#dtKelas').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.kelas.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}"
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"Kode",
                    "width":"12%",
                    "data":"kode"
                },
                {
                    "title":"Kelas",
                    "width":"12%",
                    "data":"kelas"
                },
                {
                    "title":"Semester",
                    "width":"12%",
                    "data":"semester"
                },
                {
                    "title":"Tahun Ajaran",
                    "width":"12%",
                    "data":"ta_tahun_ajar",
                    "name": "ta.tahun_ajar"
                },
                {
                    "title":"Paket Kelas",
                    "width":"12%",
                    "data":"pk_nama",
                    "name": "pk.nama"
                },
                {
                    "title":"Layanan",
                    "width":"15%",
                    "data":"lk_kode",
                    "name":"lk.kode"
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"10%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        return '<a href="#" class="detailDataBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-eye"></i></a>'+
                        '<a href="#" class="editDataBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'
                    }
                }
            ],
            order:[[1,'asc']],
            columnDefs:[]
        });
        
        $('#input-search-table').on( 'keyup change clear',function() {
            table
                .search( $(this).val())
                .draw()
        });

        $('#ttd_ketua_file').on('change',function(){
            if(this.files && this.files[0]){
                ttd_ketua_file = this.files[0]
                var ttd_ketua_src = URL.createObjectURL(ttd_ketua_file)
                $('#formEdit').find('#ttd_ketua_preview').attr("src", ttd_ketua_src);
            }
        });

        $('#ttd_pj_file').on('change',function(){
            if(this.files && this.files[0]){
                ttd_pj_file = this.files[0]
                var ttd_pj_src = URL.createObjectURL(ttd_pj_file)
                $('#formEdit').find('#ttd_pj_preview').attr("src", ttd_pj_src);
            }
        });

        $('#dtKelas').on('click', '.detailDataBtn', function(){
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "{{route('ajax.ttd_raport.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'kelas_id' : id
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error && res.data != null) {
                        $('#tabelTandaTangan').find('#viewNIPKetua').html((res.data.nip_ketua_pkbm ?? '-'));
                        $('#tabelTandaTangan').find('#viewNamaKetua').html((res.data.nama_ketua_pkbm ?? '-'));
                        $('#tabelTandaTangan').find('#viewJenisKetua').html('Ketua PKBM');
                        $('#tabelTandaTangan').find('#view_ttd_ketua').attr("src", res.data.url_ttd_ketua);

                        $('#tabelTandaTangan').find('#viewNIPPJ').html((res.data.nip_pj_rombel ?? '-'));
                        $('#tabelTandaTangan').find('#viewNamaPJ').html((res.data.nama_pj_rombel ?? '-'));
                        $('#tabelTandaTangan').find('#viewJenisPJ').html('Penanggung jawab rombel');
                        $('#tabelTandaTangan').find('#view_ttd_pj').attr("src", res.data.url_ttd_pj);

                        $('#modalView').modal('show');
                    } else {
                        // showError('Data masih kosong, silahkan isi terlebih dahulu');
                        swalError({text: 'Data masih kosong, silahkan isi terlebih dahulu'});
                    }
                }
            });
        });

        $('#dtKelas').on('click', '.editDataBtn', function(){
            var id = $(this).data('id');
            $("#formEdit").trigger("reset");
            $('#formEdit').find('#kelas_id').val(id);

            $.ajax({
                type: "POST",
                url: "{{route('ajax.ttd_raport.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'kelas_id' : id
                },
                success: function(res) {
                    $('#formEdit').find('#ttd_ketua_preview').attr("src", '{{asset('images')}}/placeholder.png');
                    $('#formEdit').find('#ttd_pj_preview').attr("src", '{{asset('images')}}/placeholder.png');

                    if (!res.error && res.data != null) {
                        $('#formEdit').find('#nip_ketua_pkbm').val((res.data.nip_ketua_pkbm ? res.data.nip_ketua_pkbm : '-'));
                        $('#formEdit').find('#nama_ketua_pkbm').val((res.data.nama_ketua_pkbm ?? '-'));

                        $('#formEdit').find('#nip_pj_rombel').val((res.data.nip_pj_rombel ?? '-'));
                        $('#formEdit').find('#nama_pj_rombel').val((res.data.nama_pj_rombel ?? '-'));

                        $('#formEdit').find('#ttd_ketua_preview').attr("src", res.data.url_ttd_ketua);
                        $('#formEdit').find('#ttd_pj_preview').attr("src", res.data.url_ttd_pj);
                    }
                }
            });

            $('#modalEdit').modal('show');
        });

        //Submit Call
        $('#submitTtdBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formEdit");
            enableLoadingButton("#submitTtdBtn");

            async function getImageBlob(imageUrl) {
                try {
                    const response = await fetch(imageUrl);
                    if (!response.ok) {
                        throw new Error('Failed to fetch image');
                    }
                    return await response.blob();
                } catch (error) {
                    throw error;
                }
            }

            $.ajax({
                type: "GET",
                url: "{{ route('ajax.settings.get_kepala_pkbm') }}",
                success: async function(res) {
                    console.log(res.data)
                    if (res.data) {
                        try {
                            ttd_ketua_file = await getImageBlob(res.data.ttd_kepala_pkbm);
                            var formData = new FormData();
                            formData.append('_token', "{{ csrf_token() }}");
                            formData.append('kelas_id', $('#formEdit').find('#kelas_id').val());
                            formData.append('nama_ketua_pkbm', res.data.nama_kepala_pkbm);
                            formData.append('nip_ketua_pkbm', res.data.nip_ketua_pkbm);
                            formData.append('nama_pj_rombel', $('#formEdit').find('#nama_pj_rombel').val());
                            formData.append('nip_pj_rombel', $('#formEdit').find('#nip_pj_rombel').val());
                            formData.append('ttd_ketua_pkbm', ttd_ketua_file);

                            
                            if (ttd_pj_file) {
                                formData.append('ttd_pj_rombel', ttd_pj_file)
                            }

                            $.ajax({
                            type: "POST",
                            url: "{{route('ajax.ttd_raport.saveOrUpdate')}}",
                            cache : false,
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(res) {
                                disableLoadingButton("#submitTtdBtn");
                                if (!res.error) {
                                    swalSuccess({text: 'Upload berhasil'});
                                    $('#modalEdit').modal('hide');
                                    $("#formEdit").trigger("reset");

                                    $('#formEdit').find('#ttd_ketua_preview').attr("src", '{{asset('images')}}/placeholder.png');
                                    $('#formEdit').find('#ttd_pj_preview').attr("src", '{{asset('images')}}/placeholder.png');
                                }else{
                                    swalError({text: 'Upload gagal'});
                                }
                            },
                            error: function(response, textStatus, errorThrown){
                                disableLoadingButton("#submitTtdBtn");
                                ajaxCallbackError(response);
                            }
                        });

                        } catch (error) {
                            console.error('Error:', error);
                        }
                    } else {
                        console.error('Failed to get data kepala pkbm');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

            
        });
    });
</script>
@endsection
