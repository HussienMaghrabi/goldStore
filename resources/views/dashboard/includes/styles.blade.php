@php
  // App::setLocale('en')
@endphp
{{-- {{App::getLocale()}} --}}

@if(App::getLocale() == 'ar')
  {{-- <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css"> --}}
  <link rel="stylesheet" href="{{ asset('storage/assets/admin/ar/dist/css/AdminLTE-rtl.min.css') }}">
  <link rel="stylesheet" href="{{ asset('storage/assets/admin/ar/dist/css/_all-skins-rtl.min.css') }}">
  <link rel="stylesheet" href="{{ asset('storage/assets/admin/ar/dist/fonts/font-face.css') }}">
@else
  <link rel="stylesheet" href="{{ asset('storage/assets/admin/dist/css/AdminLTE.min.css') }}">
@endif
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{ asset('storage/assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('storage/assets/admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{ asset('storage/assets/admin/bower_components/Ionicons/css/ionicons.min.css') }}">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{ asset('storage/assets/admin/dist/css/skins/_all-skins.min.css') }}">
<!-- Morris chart -->
<link rel="stylesheet" href="{{ asset('storage/assets/admin/bower_components/morris.js/morris.css') }}">
<!-- jvectormap -->
<link rel="stylesheet" href="{{ asset('storage/assets/admin/bower_components/jvectormap/jquery-jvectormap.css') }}">
<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset('storage/assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('storage/assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="{{ asset('storage/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<!-- jQuery 3 -->
<script src="{{ asset('storage/assets/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>

<style>
    ::-webkit-scrollbar {
        height: 2px;
        width: 4px;
        background: hsla(0, 0%, 100%, 0);
    }

    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(185, 12, 12, 0);
        background: rgba(255, 255, 255, 0)
    }

    ::-webkit-scrollbar-thumb {
        background-color: #222d32;
        border-radius: 50px;
    }
</style>
