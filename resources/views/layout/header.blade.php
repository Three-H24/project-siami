<!-- Favicon icon -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>SIAMI | {{$title}}</title>

{{--Chart JS--}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link rel="icon" href="{{URL::asset('assets/images/logo-ukrim2.png')}}"/>
<link rel="stylesheet" href="{{URL::asset('assets_main/vendor/owl-carousel/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets_main/vendor/owl-carousel/css/owl.theme.default.min.css')}}">
<link href="{{URL::asset('assets_main/vendor/jqvmap/css/jqvmap.min.css')}}" rel="stylesheet">

<!-- Sweetalert -->
{{--<link href="{{URL::asset('assets_main/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">--}}

<!-- Toastr -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-
     alpha/css/bootstrap.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Datatable -->
<link href="{{URL::asset('assets_main/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

<link href="{{URL::asset('assets_main/css/style.css')}}" rel="stylesheet">
