@extends('layout.main')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}}</h4>
            </div>

            @error('standar')
            <div class="alert alert-dismissible alert-outline-danger fade show">
                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                            class="mdi mdi-close"></i></span>
                </button>
                <strong>Gagal!</strong> {{$message}}
            </div>
            @enderror

            @error('target_waktu')
            <div class="alert alert-dismissible alert-outline-danger fade show">
                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                            class="mdi mdi-close"></i></span>
                </button>
                <strong>Gagal!</strong> {{$message}}
            </div>
            @enderror

            <div class="card-body">
                <form action="{{route('ami.add')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Pilih Standar
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col">
                            <select class="form-control @error('standar') is-invalid @enderror" name="standar" required>
                                <option selected>Pilih Standar</option>
                                @foreach($standars as $standar)
                                    <option value="{{$standar->id}}">{{$standar->nama_standar}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Tahun
                            Target
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col">
                            <select class="form-control @error('target_waktu') is-invalid @enderror" name="target_waktu" required>
                                <option selected>Pilih Tahun Target</option>
                                @foreach($target_waktu as $targetWaktu)
                                    <option value="{{$targetWaktu->tahun_target}}">{{$targetWaktu->tahun_target}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-outline-success">Tambah AMI</button>
                </form>
            </div>
        </div>
    </div>

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
    </script>
@endsection()
