@extends('layout.main')
@section('content')

    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-user text-info border-info"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Users</div>
                    <div class="stat-digit">{{$users}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-archive text-primary border-primary"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Standar</div>
                    <div class="stat-digit">{{$standars}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-file text-warning border-warning"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Total dokumen</div>
                    <div class="stat-digit">{{$dokumen_pendukung}}</div>
                </div>
            </div>
        </div>
    </div>

    @foreach($indikators as $standar)
        <div class="col-lg-6 col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$standar['nama_standar']}}</h4>
                </div>
                <div class="card-body">
                    <canvas id="barChart_1-{{$loop->index}}"></canvas>
                </div>
            </div>
        </div>

        <script>
            var ctx = document.getElementById('barChart_1-{{$loop->index}}').getContext('2d');

            ctx.height = 100;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    defaultFontFamily: 'Poppins',
                    labels: {!! json_encode(array_column($standar['indikatorData'], 'butir_indikator')) !!},
                    datasets: [
                        {
                            label: "Jumlah dokumen pendukung",
                            data: {!! json_encode(array_column($standar['indikatorData'], 'jumlah_dokumen')) !!},
                            borderColor: '#8854d0',
                            borderWidth: "1",
                            backgroundColor: '#9980FA'
                        }
                    ]
                },
                options: {
                    legend: false,
                    plugins: {
                        title: {
                            display: true,
                            text: '(Butir Indikator)',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endforeach

    <script>
        @if(session('message'))

            toastr.options = {
            positionClass: "toast-top-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        }
        toastr.success("{{session('message')}}", "Success")
        @endif

            @if(session('Error-ubah-pass1'))

            toastr.options = {
            positionClass: "toast-top-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        }
        toastr.error("{{session('Error-ubah-pass1')}}", "Gagal")
        @endif

            @if(session('Error-ubah-pass2'))

            toastr.options = {
            positionClass: "toast-top-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        }
        toastr.error("{{session('Error-ubah-pass2')}}", "Gagal")
        @endif

            @if(session('message'))

            toastr.options = {
            positionClass: "toast-top-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !0,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        }
        toastr.success("{{session('message')}}", "Success")
        @endif

    </script>
@endsection()
