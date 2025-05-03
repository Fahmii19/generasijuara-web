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
                            Add News
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <form id="formNews" method="POST" action="" novalidate>
                    @csrf
                    <input class="form-control" id="id" type="hidden" />
                    <div class="row gx-3">
                        <div class="mb-3 col-md-12">
                            <label class="small mb-1" for="title">Title*</label>
                            <input class="form-control" id="title" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="small mb-1" for="content">Content*</label>
                            <textarea class="form-control" id="content"></textarea>
                        </div>
                        <div class="mb-3 col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="">
                                <label class="form-check-label" for="is_active">Set Aktif</label>
                            </div>
                        </div>
                        <!-- <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="published_for">Publishe *</label>
                            <select class="form-control" id="published_for">
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div> -->
                    </div>
                    <hr class="my-4" />
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-light" type="button" onclick="goBackWithRefresh();">Cancel</button>
                        <button class="btn btn-primary" type="button" id="submitPpdbBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@stop

@section('style_extra')

@endsection

@section('js_extra')

<script type="text/javascript">
    $(document).ready(function() {
        var table = null
        var id = "{{@$id}}";

        if (id != null) {
            getDetailPPDB();
        }

        function getDetailPPDB() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.news.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                },
                success: function(res) {
                    // console.log(res);
                    if (!res.error) {
                        $('#formNews').find('#id').val(res.data.id);
                        $('#formNews').find('#title').val(res.data.title);
                        $('#formNews').find('#content').val(res.data.content);
                        if (res.data.is_active) {
                            $('#formNews').find('#is_active').prop('checked', true);
                        }else{
                            $('#formNews').find('#is_active').prop('checked', false);
                        }
                    }
                }
            });
        }

        //Submit
        $('#submitPpdbBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formNews");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formNews').find('#id').val(),
                'title' : $('#formNews').find('#title').val(),
                'content' : $('#formNews').find('#content').val(),
                'is_active' : $('#formNews').find("#is_active").is(":checked"),
            }
            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.news.save')}}",
                data: data,
                success: function(res) {
                    // console.log(res);

                    if (!res.error) {
                        // alert('success');
                        // goBackWithRefresh();
                        swalSuccess({
                            text: 'Berita berhasil disimpan',
                            withGoBack: true
                        })
                    }else{
                        alert('failed');
                    }
                },
                error: function(xhr, textStatus, errorThrown){
                    // console.log(xhr.responseJSON.message)
                    alert('Warning: '+xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
