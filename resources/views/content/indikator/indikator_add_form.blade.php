@extends('layout.main')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}}</h4>
            </div>
            <div class="card-body">
                @error('standar')
                <div class="alert alert-dismissible alert-outline-danger fade show">
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                class="mdi mdi-close"></i></span>
                    </button>
                    <strong>Gagal!</strong> Standar wajib dipilih 1!
                </div>
                @enderror

                @error('butir_indikator')
                <div class="alert alert-dismissible alert-outline-danger fade show">
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                class="mdi mdi-close"></i></span>
                    </button>
                    <strong>Gagal!</strong> Butir indikator wajib diisi!
                </div>
                @enderror

                @error('satuan')
                <div class="alert alert-dismissible alert-outline-danger fade show">
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                class="mdi mdi-close"></i></span>
                    </button>
                    <strong>Gagal!</strong> Satuan belum di tentukan!
                </div>
                @enderror

                @error('keterangan_target')
                <div class="alert alert-dismissible alert-outline-danger fade show">
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                class="mdi mdi-close"></i></span>
                    </button>
                    <strong>Gagal!</strong> Keterangan target harus ditentukan!
                </div>
                @enderror

                <form action="{{route('indikator.add')}}" method="post">
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
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Butir Indikator
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col">
                            <textarea name="butir_indikator" class="form-control @error('butir_indikator') is-invalid @enderror" rows="4" placeholder="Masukan butir indikator..."></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Satuan
                            Indikator
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col">
                            <input type="text" name="satuan"
                                   class="form-control input-rounded @error('satuan') is-invalid @enderror"
                                   placeholder="Masukan satuan indikator..." required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-outline-success">Tambah Indikator</button>
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
