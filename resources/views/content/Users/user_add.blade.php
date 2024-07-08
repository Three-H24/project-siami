@extends('layout.main')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}}</h4>
            </div>
            <div class="card-body">
                @error('email')
                <div class="alert alert-outline-danger alert-dismissible fade show">
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                class="mdi mdi-close"></i></span>
                    </button>
                    <strong>Gagal!</strong> Email yang Anda input telah digunakan!
                </div>
                @enderror

                @error('foto')
                <div class="alert alert-dismissible alert-outline-danger fade show">
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                class="mdi mdi-close"></i></span>
                    </button>
                    <strong>Gagal!</strong> Maksimal ukuran foto 2058 kb!
                </div>
                @enderror

                @error('telp')
                <div class="alert alert-dismissible alert-outline-danger fade show">
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                class="mdi mdi-close"></i></span>
                    </button>
                    <strong>Gagal!</strong> No handphone harus angka dan maks. 12!
                </div>
                @enderror

                @error('role')
                <div class="alert alert-dismissible alert-outline-danger fade show">
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                class="mdi mdi-close"></i></span>
                    </button>
                    <strong>Gagal!</strong> Wajib pilih 1 role user!
                </div>
                @enderror
                <form action="{{route('user.create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Nama User
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col">
                            <input type="text" name="nama" class="form-control input-rounded"
                                   placeholder="Masukan Nama User..." required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Email
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col">
                            <input type="text" name="email"
                                   class="form-control input-rounded @error('email') is-invalid @enderror"
                                   placeholder="Masukan email user..." required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Password
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col">
                            <input type="text" name="password" class="form-control input-rounded"
                                   placeholder="Masukan password user..." required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Foto
                            User</label>
                        <div class="input-group mb-3 col">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="foto"
                                       class="form-control custom-file-input @error('foto') is-invalid @enderror"
                                       accept="image/*"
                                       required>
                                <label class="custom-file-label">Choose file</label>
                            </div>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Jabatan User
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col">
                            <input type="text" name="jabatan" class="form-control input-rounded"
                                   placeholder="Masukan jabatan user..." required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">No. Handphone
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col">
                            <input type="number" name="telp"
                                   class="form-control input-rounded @error('telp') is-invalid @enderror"
                                   placeholder="Masukan no handphone user..." required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Pilih role user
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col">
                            <select class="form-control" name="role" required>
                                <option selected>Pilih Role User...</option>
                                <option value="admin">Admin</option>
                                <option value="auditee">Auditee</option>
                                <option value="auditor">Auditor</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-outline-success">Tambah User</button>
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
