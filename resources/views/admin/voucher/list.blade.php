@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Voucher List
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addVoucherBtn">
                            <i class="me-1" data-feather="plus"></i>
                            Add Voucher
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
                    <table class="table table-bordered" id="dtVoucher" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalVoucher" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVoucherLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVoucherLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formVoucher" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="kode">Kode</label>
                        <input readonly="readonly" class="form-control" id="kode" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="stok">Stok</label>
                        <input class="form-control" id="stok" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="type">Type</label>
                        <select class="form-control" id="type">
                            <option value="fixed_amount">Fixed Amount</option>
                            <option value="percentage">Percentage</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="discount">Diskon</label>
                        <input class="form-control" id="discount" type="number" placeholder="">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="">
                            <label class="form-check-label" for="is_active">Set Aktif</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitVoucherBtn">Submit</button></div>
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
        table = $('#dtVoucher').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.voucher.get')}}",
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
                    "title":"Stok",
                    "width":"12%",
                    "data":"stok"
                },
                {
                    "title":"Type",
                    "width":"12%",
                    "data":"type"
                },
                {
                    "title":"Diskon",
                    "width":"12%",
                    "data":"discount"
                },
                {
                    "title":"Status",
                    "width":"12%",
                    "data":"is_active",
                    "name":"u.is_active",
                    render: function (data, type, row) {
                        if (data) {
                            return '<span class="badge bg-green-soft text-green">Aktif</span>';
                        }else{
                            return '<span class="badge bg-yellow-soft text-yellow">Tidak Aktif</span>';
                        }
                    }
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"30%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        return ''+
                        '<a href="#" class="voucherEditBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="voucherDeleteBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
                    }
                }
            ],
            order:[[1,'asc']],
            columnDefs:[]
        });
        
        $('#input-search-table').on( 'keyup change clear',function() {
            table
                // .columns(2)
                .search( $(this).val())
                .draw()
        })

        $('#dtVoucher').on('click', '.voucherEditBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalVoucher').modal('show');
            $('#formVoucher').trigger("reset");
            $('#formVoucher').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.voucher.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formVoucher').find('#id').val(res.data.id);
                        $('#formVoucher').find('#kode').val(res.data.kode);
                        $('#formVoucher').find('#stok').val(res.data.stok);
                        $('#formVoucher').find('#type').val(res.data.type);
                        $('#formVoucher').find('#discount').val(res.data.discount);
                        if (res.data.is_active) {
                            $('#formVoucher').find('#is_active').prop('checked', true);
                        }else{
                            $('#formVoucher').find('#is_active').prop('checked', false);
                        }
                    }
                }
            });
        });

        $('#dtVoucher').on('click', '.editPwdBtn', function(){
            var id = $(this).data('id');
            $('#modalPwd').modal('show');
            $('#formPwd').trigger("reset");
            $('#formPwd').find('#id').val(id);
        });

        $('#dtVoucher').on('click', '.voucherDeleteBtn', function(e){
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
                        url: "{{route('ajax.voucher.delete')}}",
                        data: data,
                        withSuccessMessage: true,
                        successMessage: 'Voucher berhasil dihapus',
                        withReloadTable: true,
                        table: table
                    });
                }
            });

            // $.ajax({
            //     type: "POST",
            //     url: "{{route('ajax.voucher.delete')}}",
            //     data: data,
            //     success: function(res) {
            //         if (!res.error) {
            //             table.ajax.reload();
            //         }else{
            //         }
            //     }
            // });
        });

        $('#addVoucherBtn').on('click', function(){
            $('#modalVoucher').modal('show');
            $('#formVoucher').trigger("reset");
            $('#formVoucher').find('#id').val(null);
        });

        $('#submitVoucherBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formVoucher");

            enableLoadingButton("#submitVoucherBtn");

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formVoucher').find('#id').val(),
                'stok' : $('#formVoucher').find('#stok').val(),
                'discount' : $('#formVoucher').find('#discount').val(),
                'type' : $('#formVoucher').find('#type').val(),
                'is_active' : $('#formVoucher').find("#is_active").is(":checked"),
            }
            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.voucher.save')}}",
                data: data,
                success: function(res) {
                    disableLoadingButton("#submitVoucherBtn");
                    if (!res.error) {
                        $('#modalVoucher').modal('hide');
                        // table.ajax.reload();
                        // showSuccess(res.message || "Success");
                        swalSuccess({
                            text: "Voucher berhasil disimpan",
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                        showError('failed');
                    }
                },
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitVoucherBtn");
                    ajaxCallbackError(response);
                }
            });
        });

    });
</script>
@endsection
