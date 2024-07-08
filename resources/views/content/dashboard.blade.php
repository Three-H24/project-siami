@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">

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
                                <div class="stat-digit">{{$dokumen_pendukung_standar}}</div>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($indikators as $standar)
                    <div class="col-lg-6 col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{$standar->nama_standar}}</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="barChart_1-{{$standar->id}}"></canvas>
                            </div>
                        </div>
                    </div>

                    <script>
                        var ctx = document.getElementById('barChart_1-{{$standar->id}}').getContext('2d');

                        ctx.height = 100;

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                defaultFontFamily: 'Poppins',
                                labels: {!! json_encode($standar->indikator->pluck('satuan')) !!},
                                datasets: [
                                    {
                                        label: "Jumlah dokumen pendukung",
                                        data: {!! json_encode($standar->indikator->pluck('dokumen_pendukung_indikator_count')) !!},
                                        borderColor: '#8854d0',
                                        borderWidth: "1",
                                        backgroundColor: '#9980FA'
                                    }
                                ]
                            },
                            options: {
                                legend: false,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                @endforeach

            </div>
        </div>
    </div>

    {{--    <div class="col-lg-3 col-sm-6">--}}
    {{--        <div class="card">--}}
    {{--            <div class="stat-widget-one card-body">--}}
    {{--                <div class="stat-icon d-inline-block">--}}
    {{--                    <i class="ti-link text-danger border-danger"></i>--}}
    {{--                </div>--}}
    {{--                <div class="stat-content d-inline-block">--}}
    {{--                    <div class="stat-text">Referral</div>--}}
    {{--                    <div class="stat-digit">2,781</div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <!-- /# column -->
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

            @if(session('message-success'))

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
        toastr.success("{{session('message-success')}}", "Success")
        @endif

    </script>
@endsection
