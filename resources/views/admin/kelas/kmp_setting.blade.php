@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><a href="#" onclick="goBackWithRefresh();"><i data-feather="arrow-left"></i></a></div>
                            Kelas: Setting 
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addSettingBtn">
                            <i class="me-1" data-feather="plus"></i>
                            Add Setting
                        </a>
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
                    <table class="table table-bordered" id="tbKelas" width="100%" cellspacing="0">
                        <tr>
                            <th width="20%">Kode Kelas</th>
                            <td id="kode_kelas"></td>
                        </tr>
                        <tr>
                            <th>Nama Kelas</th>
                            <td id="nama_kelas"></td>
                        </tr>
                        <tr>
                            <th>Mata Pelajaran</th>
                            <td id="mata_pelajaran"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Setting</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtSettingKMP" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalSettingKMP" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalSettingKMPLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSettingKMPLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formSettingKMP" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="semester">Semester</label>
                        <select class="form-control" id="semester">
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="persentase_tm">Persentase Tugas Modul</label>
                        <input class="form-control" id="persentase_tm" type="text" placeholder="40">
                    </div>
                    <div class="mb-3">
                        <label for="persentase_um">Persentase Ujian Modul</label>
                        <input class="form-control" id="persentase_um" type="text" placeholder="60">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_modul">Jumlah Modul</label>
                        <input class="form-control" id="jumlah_modul" type="text" placeholder="3">
                    </div>
                    <div class="mb-3">
                        <label for="kkm">KKM</label>
                        <input class="form-control" id="kkm" type="text" placeholder="70">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" id="need_nilai_sikap" name="need_nilai_sikap" type="checkbox" value="">
                            <label class="form-check-label" for="need_nilai_sikap">Set Nilai Sikap</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitKMPBtn">Submit</button></div>
        </div>
    </div>
</div>

@stop

@section('style_extra')

@endsection

@section('js_extra')
<script type="text/javascript">
    $(document).ready(function() {
        var table = null
        var kmp_id = "{{$kmp_id}}";

        getKMP();
        function getKMP() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas_mp.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id'    : kmp_id
                },
                success: function(res) {
                    // console.log(res);
                    if (!res.error) {
                        $('#tbKelas').find('#kode_kelas').text(res.data?.kelas_detail.kode);
                        $('#tbKelas').find('#nama_kelas').text(res.data?.kelas_detail.nama);
                        $('#tbKelas').find('#mata_pelajaran').text(res.data?.mata_pelajaran_detail.nama);
                    }
                }
            });
        }

        table = $('#dtSettingKMP').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.kmp_setting.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.kmp_id = kmp_id
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"Semester",
                    "width":"12%",
                    "data":"semester"
                },
                {
                    "title":"TM (%)",
                    "width":"12%",
                    "data":"persentase_tm"
                },
                {
                    "title":"UM (%)",
                    "width":"12%",
                    "data":"persentase_um"
                },
                {
                    "title":"Jml Modul",
                    "width":"12%",
                    "data":"jumlah_modul"
                },
                {
                    "title":"Nilai Sikap",
                    "width":"12%",
                    "data":"need_nilai_sikap",
                    render: function (data,type, row){
                        return (data) ? 'Ya' : 'Tidak';
                    }
                },
                {
                    "title":"KKM",
                    "width":"12%",
                    "data":"kkm"
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        return '<a href="#" class="editRowBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="deleteRowBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
                    }
                }
            ],
            order:[[0,'asc']],
            columnDefs:[]
        });
        
        $('#input-search-table').on( 'keyup change clear',function() {
            table
                // .columns(2)
                .search( $(this).val())
                .draw()
        })

        $('#dtSettingKMP').on('click', '.editRowBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalSettingKMP').modal('show');
            $('#formSettingKMP').trigger("reset");
            $('#formSettingKMP').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kmp_setting.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formSettingKMP').find('#id').val(res.data.id);
                        $('#formSettingKMP').find('#semester').val(res.data.semester);
                        $('#formSettingKMP').find('#persentase_tm').val(res.data.persentase_tm);
                        $('#formSettingKMP').find('#persentase_um').val(res.data.persentase_um);
                        $('#formSettingKMP').find('#jumlah_modul').val(res.data.jumlah_modul);
                        $('#formSettingKMP').find('#kkm').val(res.data.kkm);
                        if (res.data?.need_nilai_sikap) {
                            $('#formSettingKMP').find('#need_nilai_sikap').prop('checked', true);
                        }else{
                            $('#formSettingKMP').find('#need_nilai_sikap').prop('checked', false);
                        }
                    }
                }
            });
        });

        $('#dtSettingKMP').on('click', '.deleteRowBtn', function(e){
            e.preventDefault();
            var idSelected = $(this).data('id');
            var rowData =  table.row( $(this).parents('tr') ).data();

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : idSelected,
            }

            sweetAlertAction({
                title: 'Apakah anda yakin?',
                text: 'Data tidak dapat dikembalikan',
                type: 'question',
                withCallback: true,
                callback: function() {
                    ajaxOperation({
                        type: "POST",
                        url: "{{route('ajax.kmp_setting.delete')}}",
                        data: data,
                        withSweetAlertTimer: true,
                        swalTitle: 'Sukses',
                        swalType: 'success',
                        swalTimer: 2000,
                        swalText: 'Data berhasil dihapus',
                        withReloadTable: true,
                        table: table
                    });
                }
            });

            // $.ajax({
            //     type: "POST",
            //     url: "{{route('ajax.kmp_setting.delete')}}",
            //     data: data,
            //     success: function(res) {
            //         if (!res.error) {
            //             table.ajax.reload();
            //         }else{
            //         }
            //     }
            // });

            // var url = ""
            // var route = "ajax.branch.delete"
            // var params = {
            //     "_token": "{{ csrf_token() }}",
            //     'id' : idSelected
            // }
            // var successCallback = () => {
            //     table.ajax.reload(null,false);
            // }

            // confirmDeleteElement(rowData.region_code, url, route, params, successCallback)
        });

        $('#addSettingBtn').on('click', function(){
            $('#modalSettingKMP').modal('show');
            $('#formSettingKMP').trigger("reset");
            $('#formSettingKMP').find('#id').val(null);
        });

        $('#submitKMPBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formSettingKMP");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formSettingKMP').find('#id').val(),
                'kmp_id' : kmp_id,
                'semester' : $('#formSettingKMP').find("#semester").val(),
                'persentase_tm' : $('#formSettingKMP').find("#persentase_tm").val(),
                'persentase_um' : $('#formSettingKMP').find("#persentase_um").val(),
                'jumlah_modul' : $('#formSettingKMP').find("#jumlah_modul").val(),
                'kkm' : $('#formSettingKMP').find("#kkm").val(),
                'need_nilai_sikap' : $('#formSettingKMP').find("#need_nilai_sikap").is(":checked"),
            }
            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kmp_setting.save')}}",
                data: data,
                success: function(res) {
                    console.log(res);
                    // $('#spinner-toast').modal('hide');

                    if (!res.error) {
                        $('#modalSettingKMP').modal('hide');
                        // $("#link-next").attr("href", "#");
                        // $('#success-modal').modal('show');
                        // $('#success-modal-btn-ok').on('click', function(){
                        //     $('#success-modal').modal('hide');
                        // });
                        table.ajax.reload();
                    }else{
                        // $('#toastModalLabel').text(response.message)
                        // $('#toastModal').modal('show')
                    }
                }
            });
        });
    });
</script>
@endsection
