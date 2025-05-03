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
                                Paket SPP ABC
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-sm btn-light text-primary" href="#" id="addPaketSppBtn">
                                <i class="me-1" data-feather="plus"></i>
                                Add
                            </a>
                            <!-- <a class="btn btn-sm btn-light text-primary" href="#">
                                    <i class="me-1" data-feather="file"></i>
                                    PDF
                                </a>
                                <a class="btn btn-sm btn-light text-primary" href="#">
                                    <i class="me-1" data-feather="file"></i>
                                    Excel/CSV
                                </a> -->
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
                        <table class="table table-bordered" id="dtPaketSpp" width="100%" cellspacing="0">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="modalPaketSpp" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="modalPaketSppLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPaketSppLabel">Form</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPaketSpp" method="POST" action="" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label><strong>Data</strong></label>
                        </div>
                        <input class="form-control" id="id" type="hidden" placeholder="">
                        <div class="mb-3">
                            <label for="cabang_id">Cabang</label>
                            <select class="form-control" id="cabang_id" name="cabang_id"></select>
                        </div>

                        <div class="mb-3">
                            <label for="layanan_kelas_id">Layanan Kelas</label>
                            <select class="form-control" id="layanan_kelas_id"></select>
                        </div>
                        <div class="mb-3" id="paket_kelas_wrapper">
                            <label for="paket_kelas_id">Paket Kelas</label>
                            <select class="form-control" id="paket_kelas_id"></select>
                        </div>
                        <div class="mb-3" id="semester_wrapper">
                            <label for="semester">Semester</label>
                            <select class="form-control" id="semester"></select>
                        </div>
                        <div class="mb-3 d-none" id="semester_kelas_khusus_wrapper">
                            <label for="semester">Semester</label>
                            <select class="form-control" id="semester_kelas_khusus"></select>
                        </div>
                        <div class="mb-3" id="kelas_wrapper">
                            <label for="kelas">Kelas</label>
                            <select class="form-control" id="kelas"></select>
                        </div>
                        <div class="mb-3 row" id="kelas_khusus_wrapper">
                            <label for="kelas">Kelas Khusus</label>
                            <div class="col-md-4">
                                <label><input type="checkbox" name="checkbox[]" value="11" class="checkbox"> Kelas 1 Semester 1</label><br>
                                <label><input type="checkbox" name="checkbox[]" value="12" class="checkbox"> Kelas 1 Semester 2</label><br>
                            </div>
                            <div class="col-md-4">
                                <label><input type="checkbox" name="checkbox[]" value="21" class="checkbox"> Kelas 2 Semester 1</label><br>
                                <label><input type="checkbox" name="checkbox[]" value="22" class="checkbox"> Kelas 2 Semester 2</label><br>
                            </div>
                            <div class="col-md-4">
                                <label><input type="checkbox" name="checkbox[]" value="31" class="checkbox"> Kelas 3 Semester 1</label><br>
                                <label><input type="checkbox" name="checkbox[]" value="32" class="checkbox"> Kelas 3 Semester 2</label><br>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="biaya">Biaya</label>
                            <input class="form-control ribuan-format" id="biaya" type="text" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="biaya_pendaftaran">Biaya Pendaftaran</label>
                            <input class="form-control ribuan-format" id="biaya_pendaftaran" type="text" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="biaya_kelas_khusus">Biaya Kelas Khusus</label>
                            <input class="form-control ribuan-format" id="biaya_kelas_khusus" type="text" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="jenis_pendaftaran">Jenis Pendaftaran</label>
                            <select class="form-control" id="jenis_pendaftaran"></select>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan">Keterangan</label>
                            <input class="form-control" id="keterangan" type="text" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="type">Tipe Kelas</label>
                            <select class="form-control" id="type"></select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" id="is_active" name="is_active" type="checkbox"
                                    value="">
                                <label class="form-check-label" for="is_active">Set Aktif</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-secondary" type="button"
                        data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button"
                        id="submitPaketSpp">Submit</button></div>
            </div>
        </div>
    </div>
@stop

@section('style_extra')

@endsection

@section('js_extra')
<script type="text/javascript">
    $(document).ready(function() {
        let table = null
        let layananKelasSelected = null
        let cabangSelected = null
        let typeSelected = "{{ $type }}";

        $("#type").attr('disabled', 'disabled')

        getCabang();

        function getCabang() {
            $.ajax({
                type: "POST",
                url: "{{ route('ajax.cabang.get') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res);
                    var html_results = "<option value=''>-- Pilih Cabang --</option>";
                    $.each(res.data, function(i, row) {
                        html_results += "<option value='" + row.id + "'>" + row
                            .nama_cabang + "</option>";
                    });
                    $('#cabang_id').html(html_results);
                    if (cabangSelected != null) {
                        $('#cabang_id').val(cabangSelected);
                    }
                }
            });
        }

        getSemesterOptions(function(output) {
            $("#semester").html(output);
        });

        getKelasNumOptions(function(output) {
            $("#kelas").html(output);
        });

        getJenisPendaftaranOptions(function(output) {
            $("#jenis_pendaftaran").html(output);
        });

        getTypeKelasOptions(function(output) {
            $("#type").html(output);
            if (typeSelected != null) {
                $('#type').val(typeSelected);
            }
        });

        getLayananKelasOptions(function(output) {
            $("#layanan_kelas_id").html(output);
        });

        getPaketKelasOptions(function(output) {
            $("#paket_kelas_id").html(output);
        });

        table = $('#dtPaketSpp').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('ajax.dt.paket_spp.get') }}",
                dataType: "json",
                "data": function(d) {
                    d._token = "{{ csrf_token() }}",
                        d.type = typeSelected
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns: [{
                    "title": "Cabang",
                    "width": "12%",
                    "data": "cb_nama",
                    "render": function(data, type, row, meta) {
                        return data ?? '-';
                    }
                },
                {
                    "title": "Layanan",
                    "width": "12%",
                    "data": "lk_kode"
                },
                {
                    "title": "Paket",
                    "width": "15%",
                    "data": "pk_kode",
                    "render": function(data, type, row, meta) {
                        return data ?? '-';
                    }
                },
                {
                    "title": "Kelas",
                    "width": "15%",
                    "data": "kelas",
                    "render": function(data, type, row, meta) {
                        return data ?? '-';
                    }
                },
                {
                    "title": "Semester",
                    "width": "7%",
                    "data": "semester",
                    "render": function(data, type, row, meta) {
                        return data ?? '-';
                    }
                },
                {
                    "title": "Semester Khusus",
                    "width": "7%",
                    "data": "semester_khusus",
                    "render": function(data, type, row, meta) {
                        return data ?? '-';
                    }
                },
                {
                    "title": "Biaya",
                    "width": "15%",
                    "data": "biaya",
                    render: function(data, type, row) {
                        return formatRibuan(data);
                    }
                },
                {
                    "title": "Pendaftaran",
                    "width": "15%",
                    "data": "biaya_pendaftaran",
                    render: function(data, type, row) {
                        return formatRibuan(data);
                    }
                },
                {
                    "title": "Jenis",
                    "width": "15%",
                    "data": "jenis_pendaftaran",
                    render: function(data, type, row) {
                        return getJenisPendaftaranStr(data);
                    }
                },
                {
                    "title": "Ket",
                    "width": "15%",
                    "data": "keterangan"
                },
                {
                    "title": "Type",
                    "width": "15%",
                    "data": "type",
                    render: function(data, type, row) {
                        return getTypeKelasStr(data);
                    }
                },
                {
                    "title": "Status",
                    "width": "12%",
                    "data": "is_active",
                    render: function(data, type, row) {
                        return getActiveStatusStr(data);
                    }
                },
                {
                    "title": "Action",
                    "data": null,
                    "width": "15%",
                    "orderable": false,
                    "searchable": false,
                    render: function(data, type, row) {
                        return '<a href="#" class="editRowBtn btn btn-sm btn-transparent-dark" data-id="' +
                            row.id + '"><i class="fas fa-edit"></i></a>' +
                            '<a href="#" class="deleteRowBtn btn btn-sm btn-transparent-dark" data-id="' +
                            row.id + '"><i class="fas fa-trash"></i></a>'
                    }
                }
            ],
            order: [
                [1, 'asc']
            ],
            columnDefs: []
        });

        $('#input-search-table').on('keyup change clear', function() {
            table
                // .columns(2)
                .search($(this).val())
                .draw()
        })

        $('#dtPaketSpp').on('click', '.editRowBtn', function() {
            var id = $(this).data('id');
            console.log(id);
            $('#modalPaketSpp').modal('show');
            $('#formPaketSpp').trigger("reset");
            $('#formPaketSpp').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{ route('ajax.paket_spp.get') }}",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formPaketSpp').find('#id').val(res.data.id);
                        $('#formPaketSpp').find('#layanan_kelas_id').val(res.data
                            .layanan_kelas_id);
                        $('#formPaketSpp').find('#paket_kelas_id').val(res.data
                            .paket_kelas_id);
                        $('#formPaketSpp').find('#semester').val(res.data.semester);
                        $('#formPaketSpp').find('#kelas').val(res.data.kelas);
                        $('#formPaketSpp').find('#biaya').val(res.data.biaya);
                        $('#formPaketSpp').find('#biaya_pendaftaran').val(res.data
                            .biaya_pendaftaran);
                        $('#formPaketSpp').find('#biaya_kelas_khusus').val(res.data.biaya_kk);
                        $('#formPaketSpp').find('#jenis_pendaftaran').val(res.data
                            .jenis_pendaftaran);
                        $('#formPaketSpp').find('#keterangan').val(res.data.keterangan);
                        $('#formPaketSpp').find('#type').val(res.data.type);
                        $('#formPaketSpp').find('#cabang_id').val(res.data.cabang_id);
                        if (res.data.is_active) {
                            $('#formPaketSpp').find('#is_active').prop('checked', true);
                        } else {
                            $('#formPaketSpp').find('#is_active').prop('checked', false);
                        }

                        let selected_kk = JSON.parse(res.data.selected_kk)
                        $('input[type="checkbox"]').each(function() {
                            if (selected_kk.includes($(this).val())) {
                                $(this).prop('checked', true);
                            }
                        });
                    }
                }
            });
        });

        $('#dtPaketSpp').on('click', '.deleteRowBtn', function(e) {
            e.preventDefault();
            var idSelected = $(this).data('id');
            var rowData = table.row($(this).parents('tr')).data();

            var data = {
                "_token": "{{ csrf_token() }}",
                'id': idSelected,
            }

            sweetAlertAction({
                title: 'Apakah anda yakin?',
                text: 'Data tidak dapat dikembalikan',
                type: 'question',
                withCallback: true,
                callback: function() {
                    ajaxOperation({
                        type: "POST",
                        url: "{{ route('ajax.paket_spp.delete') }}",
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
            //     url: "{{ route('ajax.paket_spp.delete') }}",
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

        $('#addPaketSppBtn').on('click', function() {
            $('#modalPaketSpp').modal('show');
            $('#formPaketSpp').trigger("reset");
            $('#formPaketSpp').find('#id').val(null);
            if (typeSelected != null) {
                $('#formPaketSpp').find('#type').val(typeSelected);
            }
        });
        
        let totalChecked = 0
        $('.checkbox').change(function() {
            totalChecked = $('.checkbox:checked').length;
            var biayaInput = $('#biaya_kelas_khusus');
            var biaya = 0;
            
            switch (totalChecked) {
                case 1:
                    biaya = 600000;
                    break;
                case 2:
                    biaya = 1000000;
                    break;
                case 3:
                    biaya = 1600000;
                    break;
                case 4:
                    biaya = 2000000;
                    break;
                case 5:
                    biaya = 2600000;
                    break;
                case 6:
                    biaya = 3000000;
                    break;
                default:
                    biaya = 0;
                    break;
            }
            console.log(biaya)
            biayaInput.val(biaya);
        });

        // function getSemesterKelasKhususOptions(handleData) {
        //     var html_results = "<option value=''>-- Pilih Semester --</option>" +
        //         "<option value='1'>1</option>" +
        //         "<option value='2'>2</option>" +
        //         "<option value='3'>3</option>" +
        //         "<option value='4'>4</option>" +
        //         "<option value='5'>5</option>" +
        //         "<option value='6'>6</option>";
        //     handleData(html_results);
        // }
        // Change the form field if a kelas khusus is chosen
        $('#layanan_kelas_id').on('change', function() {
            if ($(this).val() == 4) {
                $('#semester_wrapper').hide();
                $('#kelas_wrapper').hide();
                $('#semester_kelas_khusus_wrapper').removeClass('d-none');
                // getSemesterKelasKhususOptions(function(output) {
                //     $("#semester_kelas_khusus").html(output);
                // });

            } else {
                $('#semester_wrapper').show();
                $('#kelas_wrapper').show();
                $('#semester_kelas_khusus_wrapper').addClass('d-none');
            }
        });

        //Submit Call
        $('#submitPaketSpp').on('click', function(e) {
            e.preventDefault();
            var form = $("#formPaketSpp");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');
            var selectedCheckboxes = [];
            $('#formPaketSpp input[name="checkbox[]"]:checked').each(function() {
                selectedCheckboxes.push($(this).val()); // Push the value of the checked checkbox to the array
            });

            var data = {
                "_token": "{{ csrf_token() }}",
                'id': $('#formPaketSpp').find('#id').val(),
                'layanan_kelas_id': $('#formPaketSpp').find('#layanan_kelas_id').val(),
                'paket_kelas_id': $('#formPaketSpp').find('#paket_kelas_id').val(),
                'semester': $('#formPaketSpp').find('#semester').val(),
                'selected_kk': selectedCheckboxes,
                'biaya_kk': $('#formPaketSpp').find('#biaya_kelas_khusus').val(),
                'jumlah_smt_kk': totalChecked,
                // 'semester_khusus': $('#formPaketSpp').find('#semester_kelas_khusus').val(),
                'kelas': $('#formPaketSpp').find('#kelas').val(),
                'biaya': $('#formPaketSpp').find('#biaya').val(),
                'biaya_pendaftaran': $('#formPaketSpp').find('#biaya_pendaftaran').val(),
                'jenis_pendaftaran': $('#formPaketSpp').find('#jenis_pendaftaran').val(),
                'keterangan': $('#formPaketSpp').find('#keterangan').val(),
                'cabang_id': $('#formPaketSpp').find('#cabang_id').val(),
                'type': $('#formPaketSpp').find('#type').val(),
                'is_active': $('#formPaketSpp').find("#is_active").is(":checked"),
            }

            $.ajax({
                type: "POST",
                url: "{{ route('ajax.paket_spp.save') }}",
                data: data,
                success: function(res) {
                    console.log(res);
                    // $('#spinner-toast').modal('hide');

                    if (!res.error) {
                        $('#modalPaketSpp').modal('hide');
                        // $("#link-next").attr("href", "#");
                        // $('#success-modal').modal('show');
                        // $('#success-modal-btn-ok').on('click', function(){
                        //     $('#success-modal').modal('hide');
                        // });
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    } else {
                        
                        // $('#toastModalLabel').text(response.message)
                        // $('#toastModal').modal('show')
                    }
                }
            });
        });
    });
</script>
@endsection
