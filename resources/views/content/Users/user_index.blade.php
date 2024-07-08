@extends('layout.main')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}} Table</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if($errors->has('role'))
                        <span class="alert alert-warning row">
                        {{$errors->first('role')}}
                    </span>
                    @endif
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>No. telepon</th>
                            <th>Role</th>
                            <th>Foto</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody style="color: black">
                        @php($i = 1)
                        @foreach($users as $user)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$user->nama}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->jabatan}}</td>
                                <td>{{$user->telp}}</td>
                                <td>{{$user->role}}</td>
                                <td>
                                    <img src="{{URL::asset($user->foto)}}" alt="image" class="mr-3"
                                         style="border-radius: 0.5em"
                                         width="100">
                                </td>
                                <td>
                                    <a class="btn btn-info mb-1" href="#" data-toggle="modal"
                                       data-target="#ubahUser{{$user->id}}"><i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a class="btn btn-warning" href="#" data-toggle="modal"
                                       data-target="#resetPasswordUser{{$user->id}}"><i class="fa fa-refresh"></i>
                                    </a>
                                </td>
                            </tr>

                            {{--                            @dd('ini user foto dari database', $user->foto)--}}
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach($users as $user_row)
        <!-- Modal Ubah User -->
        <div class="modal fade" id="ubahUser{{$user_row->id}}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah data user</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form action="{{route('user.change', $user_row->id)}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Nama
                                    User
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="nama" class="form-control input-rounded"
                                           value="{{$user_row->nama}}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Email
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="email" class="form-control input-rounded"
                                           value="{{$user_row->email}}" required>
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
                                               class="form-control custom-file-input"
                                               accept="image/*"
                                               required>
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Jabatan
                                    User
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="jabatan" class="form-control input-rounded"
                                           value="{{$user_row->jabatan}}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">No.
                                    Handphone
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="telp" class="form-control input-rounded"
                                           value="{{$user_row->telp}}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Pilih
                                    role user
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <select class="form-control" name="role" required>
                                        <option selected>Pilih Role User...</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->value}}"
                                                    @if($user_row->role === $role->value) selected @endif>{{$role->value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Reset Password User -->
        <div class="modal fade" id="resetPasswordUser{{$user_row->id}}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reset Password User</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form action="{{route('user.reset.password', [$user_row->id])}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-sm-3 col-form-label" for="val-username">Nama
                                    User
                                </label>
                                <div class="col">
                                    <input type="text" class="form-control input-rounded"
                                           value="{{$user_row->nama}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-sm-3 col-form-label" for="val-username">Jabatan
                                    User
                                </label>
                                <div class="col">
                                    <input type="text" class="form-control input-rounded"
                                           value="{{$user_row->jabatan}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-sm-3 col-form-label" for="val-username">Role
                                    User
                                </label>
                                <div class="col">
                                    <input type="text" class="form-control input-rounded"
                                           value="{{$user_row->role}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endforeach

    {{--        @dd('ini roles' , $roles)--}}

    <script>
        @if(session('message-reset'))

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
        toastr.success("{{session('message-reset')}}", "Success")
        @endif

            @if(session('message-change'))

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
        toastr.success("{{session('message-change')}}", "Success")
        @endif
    </script>
@endsection
