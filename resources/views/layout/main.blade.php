<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.header')
</head>

<body>
<!--*******************
    Preloader start
********************-->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--*******************
    Preloader end
********************-->

<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header">
        <a href="{{route('dashboard.index')}}" class="brand-logo">
            <img class="logo-abbr" src="{{URL::asset('assets/images/icon-home.png')}}" alt="">
            <h4 class="brand-title mt-2" style="color: white">SIAMI</h4>
        </a>

        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>
    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
    Header start
    ***********************************-->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left" style="margin-top: 1em">
                        <h4>SISTEM INFORMASI AUDIT MUTU INTERNAL</h4>
                    </div>

                    <ul class="navbar-nav header-right">
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <i class="mdi mdi-account"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item" data-toggle="modal"
                                   data-backdrop="static" data-keyboard="false"
                                   data-target="#profileUser">
                                    <i class="icon-user"></i>
                                    <span class="ml-2">Profile </span>
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal"
                                   data-backdrop="static" data-keyboard="false"
                                   data-target="#ubahPassword">
                                    <i class="icon-pencil"></i>
                                    <span class="ml-2">Ubah Password </span>
                                </a>
                                <a href="{{route('logout.user')}}" class="dropdown-item">
                                    <i class="icon-key"></i>
                                    <span class="ml-2">Logout </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->

    <!--**********************************
            Sidebar start
    ***********************************-->
    <div class="quixnav">
        @include('layout.sidebar')
    </div>
    <!--**********************************
            Sidebar end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Hi, {{session('namaUserLogin')}}!</h4>
                        <span class="ml-1">{{$title}}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>
    <!--**********************************
    Content body end
    ***********************************-->

    <div class="footer">
        <div class="copyright">
            <p>Copyright © 2024 SI-AMI All rights reserved.</p>
        </div>
    </div>

    <!-- Modal Profile User -->
    <div class="modal fade" id="profileUser">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Profile User</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-0">
                        <div class="col-sm-3">
                            <img src="{{URL::asset(session('fotoUserLogin'))}}" alt="image" width="180" height="280"
                                 style="border: 3px solid #215576">
                        </div>
                        <div class="col-sm-8">
                            <h4 class="text-center">{{session('namaUserLogin')}}</h4>
                            <hr class="badge-info mt-0 w-50">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="font-weight-bold" style="color: #0b3564">Email:</p>
                                    <h6 class="text-muted mt-0">{{session('emailUserLogin')}}</h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="font-weight-bold" style="color: #0b3564">No. Telp:</p>
                                    <h6 class="text-muted mt-0">+62{{session('telpUserLogin')}}</h6>
                                </div>
                            </div>

                            <hr class="badge-info mt-0">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="font-weight-bold" style="color: #0b3564">Jabatan:</p>
                                    <h6 class="text-muted mt-0">{{session('jabatanUserLogin')}}</h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="font-weight-bold" style="color: #0b3564">Role:</p>
                                    <h6 class="text-muted mt-0">{{session('roleUserLogin')}}</h6>
                                </div>
                            </div>
                            <hr class="badge-info mt-0">
                            <p class="font-weight-bold" style="color: #0b3564">Jam login:</p>
                            <h6 class="text-muted mt-0">{{session('jamLogin')}}</h6>

                        </div>
                    </div>
                </div>
                {{--                    <div class="profile-news">--}}
                {{--                        <div class="media pt-3 pb-3">--}}
                {{--                            <img src="{{URL::asset(session('fotoUserLogin'))}}" alt="image" class="mr-3" width="150"--}}
                {{--                                 style="border: 3px solid black">--}}
                {{--                            <div class="media-body">--}}
                {{--                                <h5 class="m-b-5">{{session('namaUserLogin')}}</h5>--}}
                {{--                                <p style="color: #0b3564">Email: {{session('emailUserLogin')}}</p>--}}
                {{--                                <p style="color: #0b3564">Jabatan: {{session('jabatanUserLogin')}}</p>--}}
                {{--                                <p style="color: #0b3564">Role: {{session('roleUserLogin')}}</p>--}}
                {{--                                <p style="color: #0b3564">Jam Login: {{session('jamLogin')}}</p>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah Password User -->
<div class="modal fade" id="ubahPassword">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah password</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form action="{{route('user.ubah.password')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-sm-3 col-form-label" for="val-username">
                            Password lama
                        </label>
                        <div class="col">
                            <input type="password" class="form-control input-rounded"
                                   placeholder="Masukan password lama..."
                                   name="password-lama" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-sm-3 col-form-label" for="val-username">
                            Password baru
                        </label>
                        <div class="col">
                            <input type="password" class="form-control input-rounded" name="password-baru"
                                   placeholder="Masukan password baru..." required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label style="color: #222f3e" class="col-sm-3 col-form-label" for="val-username">
                            Konfirmasi password
                        </label>
                        <div class="col">
                            <input type="password" class="form-control input-rounded"
                                   name="konfirmasi-password" placeholder="Masukan kembali password baru..."
                                   required>
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

</div>

@include('layout.footer')
</body>

</html>
