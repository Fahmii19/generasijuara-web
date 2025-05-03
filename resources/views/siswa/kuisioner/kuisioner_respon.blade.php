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
                            Kuisioner
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        {{-- BUTTON --}}
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" id="form-kuisioner">
                    @csrf
                    <input type="hidden" name="kuisioner_id" value="{{ $kuisioner->id ?? '' }}">
                    <input type="hidden" name="tahun_akademik_id" value="{{ $kuisioner->tahun_akademik_id ?? '' }}">
                    <input type="hidden" name="ppdb_id" value="{{ $ppdb->id ?? '' }}">
                    <input type="hidden" name="destination" id="destination" value="{{ $destination ?? '' }}">
                    @php
                        $question = 1;
                    @endphp
                    @forelse ($kuisioner_items as $item)
                        {{$question . ". " . $item->item}} <br>
                        @if ($item->input_type == 'text')
                            <input type="hidden" name="kuisioner_item_id[{{ $question }}]" value="{{$item->id}}">
                            <textarea class="form-control" name="kuisioner_value[{{ $question }}]" id="" cols="30" rows="3" required></textarea>
                            <br>
                        @elseif($item->input_type == 'radio')
                            @foreach (json_decode($item->input_label) as $key => $value)
                            <div class="form-check">
                                <input type="hidden" name="kuisioner_item_id[{{ $question }}]" value="{{$item->id}}">
                                <input class="form-check-input" type="radio" name="kuisioner_value[{{ $question }}]" value="{{$value}}" required>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    {{$value}}
                                </label>
                            </div>
                            @endforeach
                            <br>
                        @endif
                        @php
                            $question++;
                        @endphp
                    @empty
                        <p class="text-center">Kuisioner belum dipublikasikan!</p>
                    @endforelse
                    <hr>
                    <button type="submit" class="btn btn-primary" id="submitKuisioner">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</main>
@stop

@section('style_extra')

<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

@endsection

@section('js_extra')

<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        validatorKuisioner = $("#form-kuisioner").validate({
            focusInvalid: true,
            errorClass: "is-invalid",
            success: "is-valid",
            rules: {
                'kuisioner_value[]': {
                    required: true
                },
            }
        });

        // Form Kuisioner Submit
        $('#form-kuisioner').submit(function(e) {
            e.preventDefault();
            var form = $("#form-kuisioner");
            var formData = new FormData(this);
            enableLoadingButton("#submitKuisioner");

            if (!$(form).valid()) {
                validatorKuisioner.focusInvalid();
                disableLoadingButton("#submitKuisioner");
                return false;
            }

            $.ajax({
                url: "{{route('ajax.kuisioner.save_respon')}}",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (!data.error) {
                        disableLoadingButton("#submitKuisioner");
                        $('#submitKuisioner').prop('disabled', true);
                        // showSuccess('Kuisioner berhasil disimpan!');
                        // setTimeout(function() {
                        //     window.location.href = "{{ route('web.siab.raport.print', request()->kelas_id) }}";
                        // }, 1500);
                        swalSuccess({
                            text: 'Kuisioner berhasil disimpan!',
                            timer: 1500,
                            withRedirect: true,
                            redirectUrl: $('#form-kuisioner').find('#destination').val()
                        })
                    } else {
                        // showError('Gagal!');
                        swalError({text: 'Kuisioner gagal disimpan!'});
                    }
                },
                cache: false,
                processData: false,
                contentType: false,
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitKuisioner");
                    ajaxCallbackError(response);
                }
            });
        });
    });
</script>

@endsection
