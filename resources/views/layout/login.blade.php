<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Sistem Informasi Audit Mutu Internal</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{URL::asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/vendors/base/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/style.css')}}">
    <!-- endinject -->
    {{--    <link rel="stylesheet" href="{{URL::asset('assets_main/vendor/toastr/css/toastr.min.css')}}">--}}
    <link rel="shortcut icon" href="{{URL::asset('assets/images/logo-ukrim2.png')}}"/>
{{--    <link href="{{URL::asset('assets_main/css/style.css')}}" rel="stylesheet">--}}

</head>

<body>

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
            <div class="row flex-grow">
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <div class="auth-form-transparent text-left p-3">
                        <div class="brand-logo">
                            <img src="{{URL::asset('assets/images/logo-ukrim.png')}}" alt="logo">
                        </div>
                        <h4>Selamat datang!</h4>
                        <h6 class="font-weight-light">di Sistem Audit Mutu Internal</h6>
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible alert-alt solid fade show">
                                <strong>Gagal!</strong> {{session('error')}}
                            </div>
                        @endif
                        <form action="{{route('login.verify')}}" method="post" class="pt-3">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-email text-primary"></i>
                                            </span>
                                    </div>
                                    <input type="email" name="email" class="form-control form-control-lg border-left-0"
                                           id="exampleInputEmail" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-lock-outline text-primary"></i>
                                            </span>
                                    </div>
                                    <input type="password" name="password"
                                           class="form-control form-control-lg border-left-0" id="exampleInputPassword"
                                           placeholder="Password" required>
                                </div>
                            </div>
                            <div class="my-3">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        type="submit">LOGIN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 login-half-bg d-flex flex-row">
                    <p class="text-dark fw-medium text-center flex-grow align-self-end">Copyright &copy; 2024 SI-AMI All
                        rights reserved.</p>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- base:js -->
<script src="{{URL::asset('assets/vendors/base/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{URL::asset('assets/js/template.js')}}"></script>
<script src="{{URL::asset('assets_main/vendor/global/global.min.js')}}"></script>
<script src="{{URL::asset('assets_main/js/quixnav-init.js')}}"></script>
<script src="{{URL::asset('assets_main/js/custom.min.js')}}"></script>

<!-- endinject -->
<!-- plugin js for this page -->
<!-- End plugin js for this page -->
<!-- Custom js for this page-->
<!-- End custom js for this page-->
</body>

</html>
