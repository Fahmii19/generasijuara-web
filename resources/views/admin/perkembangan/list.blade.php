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
                            Perkembangan
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addPerkembanganBtn">
                            <i class="me-1" data-feather="plus"></i>
                            Add
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
                    <table class="table table-bordered" id="tbTagihan" width="100%" cellspacing="0">
                        <tr>
                            <th style="width: 30%;">NIS</th>
                            <td style="width: 70%;" id="nis_siswa"></td>
                        </tr>
                        <tr>
                            <th>Nama Siswa</th>
                            <td id="nama_siswa"></td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td id="nama_kelas"></td>
                        </tr>
                        <tr>
                            <th>Mata Pelajaran</th>
                            <td id="nama_mapel"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtPerkembangan" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalPerkembangan" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalPerkembanganLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPerkembanganLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPerkembangan" novalidate>
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="mb-3">
                        <label for="laporan_perkembangan">Laporan</label>
                        <textarea class="form-control" name="laporan" id="laporan" cols="5" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="submitPerkembanganBtn">Submit</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('style_extra')

@endsection

@section('js_extra')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = null
        var ppdb_id = "{{ request()->ppdb_id }}";
        var kelas_id = "{{ request()->kelas_id }}";
        var kmp_id = "{{ request()->kmp_id }}";

        //  Ajax get info
        $.ajax({
            url: "{{ route('ajax.perkembangan.get-info') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
                "ppdb_id": ppdb_id,
                "kelas_id": kelas_id,
                "kmp_id": kmp_id
            },
            success: function(res) {
                $('#nis_siswa').html(res.data.ppdb.nis);
                $('#nama_siswa').text(res.data.ppdb.nama);
                $('#nama_kelas').text(res.data.kelas.nama);
                $('#nama_mapel').text(res.data.kmp.mata_pelajaran_detail.nama)
            }
        })

        table = $('#dtPerkembangan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.perkembangan.get')}}",
                type: "POST",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.ppdb_id = ppdb_id,
                    d.kelas_id = kelas_id,
                    d.kmp_id = kmp_id
                },
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "data": 'DT_RowIndex',
                    "title": 'No.',
                    "orderable": false,
                    "searchable": false,
                    "width": "8%"
                },
                {
                    "title":"Tanggal Laporan",
                    "width":"27%",
                    "data":"created_at",
                    "render":function(data, type, row, meta){
                        return moment(data.created_at).format('DD-MM-YYYY');
                    }
                },
                {
                    "title":"Laporan",
                    "width":"50%",
                    "data":"laporan"
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type,row){
                        return '<a href="#" class="editPerkembanganBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="deletePerkembanganBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
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

        $('#dtPerkembangan').on('click', '.editPerkembanganBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#formPerkembangan').trigger("reset");
            $('#formPerkembangan').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.perkembangan.get-data')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : id
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formPerkembangan').find('#id').val(res.data.id);
                        $('#formPerkembangan').find('#laporan').val(res.data.laporan);
                        $('#modalPerkembangan').modal('show');
                    }
                }
            });
        });

        $('#dtPerkembangan').on('click', '.deletePerkembanganBtn', function(e){
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
                        url: "{{route('ajax.perkembangan.delete')}}",
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
        });

        $('#addPerkembanganBtn').on('click', function(){
            $('#modalPerkembangan').modal('show');
            $('#formPerkembangan').trigger("reset");
            $('#formPerkembangan').find('#id').val(null);
        });

        //Submit Call
        $('#submitPerkembanganBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formPerkembangan");
            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formPerkembangan').find('#id').val(),
                'ppdb_id' : ppdb_id,
                'kelas_id' : kelas_id,
                'kmp_id' : kmp_id,
                'laporan' : $('#formPerkembangan').find('#laporan').val(),
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.perkembangan.save')}}",
                data: data,
                success: function(res) {
                    console.log(res);
                    if (!res.error) {
                        $('#modalPerkembangan').modal('hide');
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        });
                    } else {
                        swalError({
                            text: 'Data gagal disimpan'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
