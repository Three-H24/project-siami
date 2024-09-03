@extends('layout.main')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}}</h4>
            </div>
            <div class="card-body">
                @error('nama_standar')
                <div class="alert alert-outline-danger alert-dismissible fade show">
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                class="mdi mdi-close"></i></span>
                    </button>
                    <strong>Gagal!</strong> Nama standar yang Anda input sudah ada!
                </div>
                @enderror

                <form action="{{route('standar.add')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Nama Standar
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col">
                            <input type="text" name="nama_standar" class="form-control input-rounded @error('nama_standar') is-invalid @enderror"
                                   placeholder="Masukan Nama standar..." required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Tambah Standar <span class="btn-icon-right"><i class="fa fa-plus-circle"></i></span></button>
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
@endsection
