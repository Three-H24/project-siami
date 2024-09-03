<!-- Favicon icon -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>SIAMI | {{$title}}</title>

{{--Chart JS--}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link rel="icon" href="{{URL::asset('assets/images/icon-fiskom.png')}}"/>
<link rel="stylesheet" href="{{URL::asset('assets_main/vendor/owl-carousel/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets_main/vendor/owl-carousel/css/owl.theme.default.min.css')}}">
<link href="{{URL::asset('assets_main/vendor/jqvmap/css/jqvmap.min.css')}}" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Toastr -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Datatable -->
<link href="{{URL::asset('assets_main/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

<link href="{{URL::asset('assets_main/css/style.css')}}" rel="stylesheet">
