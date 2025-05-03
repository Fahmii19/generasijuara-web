<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.head')
        <!-- styleextra -->
        @yield('style_extra')
        <!-- endstyleextra -->
    </head>
    <body class="">
        <div id="">
            <div id="layoutSidenav_content">
                @yield('content')
                @include('includes.footer')
            </div>
        </div>

        <!-- Toast container -->
        <div style="position: fixed; top: 5rem; right: 1rem; z-index: 99999;">
            <!-- Toast -->
            <div class="toast" id="toastDanger" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
                <div class="toast-header bg-danger text-white">
                    <i data-feather="alert-circle"></i>
                    <strong class="me-auto">Error</strong>
                    <!-- <small class="text-white-50 ml-2">just now</small> -->
                    <button class="ml-2 mb-1 btn-close btn-close-white" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body text-danger">This toast uses the danger background color utility on the toast header.</div>
            </div>

            <div class="toast" id="toastSuccess" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
                <div class="toast-header bg-success text-white">
                    <i data-feather="bell"></i>
                    <strong class="me-auto">Success</strong>
                    <!-- <small class="text-white-50 ml-2">just now</small> -->
                    <button class="ml-2 mb-1 btn-close btn-close-white" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body text-success">This toast uses the danger background color utility on the toast header.</div>
            </div>

            <div class="toast" id="toastNoAutohide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
                <div class="toast-header">
                    <i data-feather="bell"></i>
                    <strong class="me-auto">Toast without Autohide</strong>
                    <small class="text-muted ml-2">just now</small>
                    <button class="ml-2 mb-1 btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">This is an example toast alert, you must close this toast alert manually.</div>
            </div>
        </div>
        @include('includes.plugins')
        @include('includes.helper')

        <script type="text/javascript">
            function getTahunAkademikOptions(handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.tahun_akademik.list')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        // console.log(res);
                        var html_results = "<option value=''>-- Pilih Tahun Akademik --</option>";
                        $.each(res.data, function (i, row) {
                            html_results += "<option value='"+row.id+"'>"+row.kode+" ("+row.keterangan+")</option>";
                        });
                        handleData(html_results);
                    }
                });
            }

            function getKelasOptions(handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.kelas.get_all')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        // console.log(res);
                        var html_results = "<option value=''>-- Pilih Kelas --</option>";
                        $.each(res.data, function (i, row) {
                            html_results += "<option value='"+row.id+"'>"+row.nama+"</option>";
                        });
                        handleData(html_results);
                    }
                });
            }

            function getTypeKelasOptions(handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.kelas.get_type')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        var html_results = "<option value=''>-- Pilih Type Kelas --</option>";
                        $.each(res.data, function (i, row) {
                            html_results += "<option value='"+i+"'>"+row+"</option>";
                        });
                        handleData(html_results); 
                    }
                });
            }

            function getLayananKelasOptions(handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.layanan_kelas.get_all')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        var html_results = "<option value=''>-- Pilih Layanan Kelas --</option>";
                        $.each(res.data, function (i, row) {
                            html_results += "<option value='"+row.id+"'>"+row.kode+"</option>";
                        });
                        handleData(html_results); 
                    }
                });
            }

            function getPaketKelasOptions(handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.paket_kelas.get_all')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        var html_results = "<option value=''>-- Pilih Paket Kelas --</option>";
                        $.each(res.data, function (i, row) {
                            html_results += "<option value='"+row.id+"'>"+row.nama+"</option>";
                        });
                        handleData(html_results); 
                    }
                });
            }

            function getMataPelajaranOptions(handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.mata_pelajaran.get_all')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        // console.log(res);
                        var html_results = "<option value=''>-- Pilih Mata Pelajaran --</option>";
                        $.each(res.data, function (i, row) {
                            html_results += "<option value='"+row.id+"'>"+row.nama+"</option>";
                        });
                        handleData(html_results);
                    }
                });
            }

            function getTutorOptions(handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.tutor.get_all')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        // console.log(res);
                        var html_results = "<option value=''>-- Pilih Tutor --</option>";
                        $.each(res.data, function (i, row) {
                            html_results += "<option value='"+row.id+"'>"+row.user_detail.name+"</option>";
                        });
                        handleData(html_results)
                    }
                });
            }

            function getPaketSppOptions(params, handleData) {
                params['_token'] = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.paket_spp.get_all')}}",
                    data: params,
                    success: function(res) {
                        var html_results = "<option value=''>-- Pilih Paket SPP --</option>";
                        $.each(res.data, function (i, row) {
                            let name = "Opsi "+(i+1)+" - ";
                            if(row.kelas != null) name += "Kelas: "+row.kelas+" | ";
                            if(row.semester != null) name += "Semester: "+row.semester+" | ";
                            if(row.layanan_kelas_detail != null) name += "Layanan: "+row.layanan_kelas_detail.kode+" | ";
                            if(row.paket_kelas_detail != null) name += "Paket: "+row.paket_kelas_detail.nama+" | ";
                            if(row.keterangan != null) name += "Ket: "+row.keterangan+" | ";
                            html_results += "<option value='"+row.id+"'>"+name+"</option>";
                        });
                        handleData(html_results)
                    }
                });
            }

            function getWBOptions(handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.ppdb.get_all')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        // console.log(res);
                        var html_results = "<option value=''>-- Pilih Warga Belajar --</option>";
                        $.each(res.data, function (i, row) {
                            html_results += "<option value='"+row.id+"'>"+row.nama+"</option>";
                        });
                        handleData(html_results);
                    }
                });
            }

            function getSemesterOptions(handleData) {
                var html_results = "<option value=''>-- Pilih Semester --</option>"+
                    "<option value='1'>1</option>"+
                    "<option value='2'>2</option>";
                handleData(html_results); 
            }

            function getJenisPendaftaranOptions(handleData) {
                var html_results = "<option value=''>-- Pilih Jenis Pendaftaran --</option>"+
                    "<option value='1'>Pendaftaran Baru</option>"+
                    "<option value='2'>Pendaftaran Ulang</option>"+
                    "<option value='3'>Pendaftaran Alumni</option>";
                handleData(html_results); 
            }

            function getKelasNumOptions(handleData) {
                var html_results = "<option value=''>-- Pilih Kelas --</option>"+
                    "<option value='1'>1</option>"+
                    "<option value='2'>2</option>"+
                    "<option value='3'>3</option>"+
                    "<option value='4'>4</option>"+
                    "<option value='5'>5</option>"+
                    "<option value='6'>6</option>"+
                    "<option value='7'>7</option>"+
                    "<option value='8'>8</option>"+
                    "<option value='9'>9</option>"+
                    "<option value='10'>10</option>"+
                    "<option value='11'>11</option>"+
                    "<option value='12'>12</option>";
                handleData(html_results); 
            }

            function getPeminatanOptions(handleData) {
                var html_results = "<option value=''>-- Pilih Peminatan --</option>"+
                    "<option value='IPA'>IPA</option>"+
                    "<option value='IPS'>IPS</option>"+
                handleData(html_results); 
            }

            function getJenisPendaftaranStr(data) {
                if (data == 1) {
                    return 'Pendaftaran Baru';
                }else if (data == 2){
                    return 'Pendaftaran Ulang';
                }else if (data == 3){
                    return 'Pendaftaran Alumni';
                }else{
                    return data;
                }
            }

            function getTypeKelasStr(data) {
                if (data == 0) {
                    return 'ABC';
                }else if (data == 1) {
                    return 'PAUD';
                }else if (data == 2) {
                    return 'Kelas Khusus';
                }else{
                    return data;
                }
            }

            function getActiveStatusStr(data) {
                if (data) {
                    return '<span class="badge bg-green-soft text-green">Aktif</span>';
                }else{
                    return '<span class="badge bg-yellow-soft text-yellow">Tidak Aktif</span>';
                }
            }

            function getKelasDetail(id, handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.kelas.get')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    },
                    success: function(res) {
                        if (!res.error) {
                            handleData(res.data);
                        }
                    }
                });
            }

            function getPaketSppDetail(id, handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.paket_spp.get')}}",
                    data: {
                        'id' : id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        console.log(res)
                        if (!res.error) {
                            handleData(res.data);
                        }
                    }
                });
            }

            function getKMPSettingDetail(kmpId, handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.kmp_setting.get')}}",
                    data: {
                        'kmp_id' : kmpId,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        console.log(res)
                        if (!res.error) {
                            handleData(res.data);
                        }
                    }
                });
            }

            function getMataPelajaranByKelasOptions(kelasId, handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.mata_pelajaran.get_by_kelas')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        kelas_id: kelasId,
                    },
                    success: function(res) {
                        // console.log(res);
                        var html_results = "<option value=''>-- Pilih Mata Pelajaran --</option>";
                        $.each(res.data, function (i, row) {
                            html_results += "<option value='"+row.id+"'>"+row.mata_pelajaran_detail.nama+"</option>";
                        });
                        handleData(html_results);
                    }
                });
            }

            function getAllNews(handleData) {
                $.ajax({
                    type: "POST",
                    url: "{{route('ajax.news.list')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        handleData(res.data);
                    }
                });
            }

            function checkPredikat(val) {
                if (val == null) return null;
                else if (val > 89) return 'A';
                else if (val > 79) return 'B';
                else if (val > 69) return 'C';
                else return 'D';
            }
        </script>
        <!-- jsextra -->
        @yield('js_extra')
        <!-- endjsextra -->
    </body>
</html>
