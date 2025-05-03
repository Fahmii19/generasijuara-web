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
                            Hasil Respon Kuisioner
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="tbTagihan" width="100%" cellspacing="0">
                        <tr>
                            <th style="width: 30%;">NIS</th>
                            <td style="width: 70%;">{{ $ppdb->nis }}</td>
                        </tr>
                        <tr>
                            <th>Nama Siswa</th>
                            <td>{{ $ppdb->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Akademik</th>
                            <td>{{ $kuisioner->tahun_akademik->kode }} | {{ $kuisioner->tahun_akademik->keterangan }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <form action="" method="post" id="form-kuisioner">
                    @csrf
                    @php
                        $question = 1;
                    @endphp
                    @foreach ($kuisioner_items as $key => $item)
                        {{$question . ". " . $item->item}} <br>
                        @if ($item->input_type == 'text')
                            <textarea class="form-control" name="kuisioner_value[{{ $question }}]"
                                id="" cols="30" rows="3" disabled>{{ !empty($kuisioner_respon[$key]->value) ? $kuisioner_respon[$key]->value : '' }}</textarea>
                            <br>
                        @elseif($item->input_type == 'radio')
                            @foreach (json_decode($item->input_label) as $label_key => $value)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="kuisioner_value[{{ $question }}]"
                                    value="{{$value}}" {{ !empty($kuisioner_respon[$key]) ? ($kuisioner_respon[$key]->value == $value ? 'checked' : '') : '' }} disabled>
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
                    @endforeach
                </form>
            </div>
        </div>
    </div>
</main>
@stop

@section('style_extra')

@endsection

@section('js_extra')

@endsection
