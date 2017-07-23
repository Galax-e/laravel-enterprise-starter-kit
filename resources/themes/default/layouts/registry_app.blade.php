<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>{{ Setting::get('app.short_name') }} | {{ $page_title or "Page Title" }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Set a meta reference to the CSRF token for use in AJAX request -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- From Laravel File Manager Chrome, Firefox OS and Opera Yaayy from registry_app.blade.php-->
    <meta name="theme-color" content="#75C7C3">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#75C7C3">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#75C7C3">


    <!-- Material Design fonts -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Material Design to be included-->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/bootstrap-material-design/dist/css/bootstrap-material-design.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/bootstrap-material-design/dist/css/ripples.min.css") }}"> -->  

    <!-- Font Awesome Icons 4.4.0 -->
    <link href="{{ asset("/bower_components/admin-lte/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.1 -->
    <link href="{{ asset("/bower_components/admin-lte/ionicons/css/ionicons.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css") }}" rel="stylesheet" type="text/css" />

    <!-- Application CSS-->
    <link href="{{ asset(elixir('css/all.css')) }}" rel="stylesheet" type="text/css" />

    <!-- @cpnwaugha jQuery Toast -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/jquery.toast.css") }}" rel="stylesheet" type="text/css" />

    <!-- From Laravel File Manager -->
    <link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/cropper.min.css') }}">
    <style>{!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/css/lfm.css')) !!}</style>
    {{-- Use the line below instead of the above if you need to cache the css. --}}
    {{-- <link rel="stylesheet" href="{{ asset('/vendor/laravel-filemanager/css/lfm.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/mfb.css') }}">
    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/jQueryUI/jquery-ui-1.12.1/jquery-ui.min.css") }}">

    

    
    <!-- Head -->
    @include('partials._head')

      <!-- REQUIRED JS SCRIPTS -->

      <!-- jQuery 2.1.4 -->
      <script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
      <!-- Bootstrap 3.3.2 JS -->
      <script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
      <!-- AdminLTE App -->
      <script src="{{ asset ("/bower_components/admin-lte/dist/js/app.min.js") }}" type="text/javascript"></script>
      <!-- @cpnwaugha jQuery Toast -->
      <script src="{{ asset ("/bower_components/admin-lte/dist/js/jquery.toast.js") }}" type="text/javascript"></script>

      <!-- Optionally, you can add Slimscroll and FastClick plugins.
            Both of these plugins are recommended to enhance the
            user experience. Slimscroll is required when using the
            fixed layout. -->

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

      <!-- Application JS-->
      <script src="{{ asset(elixir('js/all.js')) }}"></script>

      <!-- Optional header section  -->
      @yield('head_extra')

  </head>

  <!-- Body -->
  @include('partials._body')

</html>
