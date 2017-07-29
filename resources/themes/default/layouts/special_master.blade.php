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

    <!-- Material design Icons -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/material-design-icons/iconfont/material-icons.css") }}">
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />

    <!-- jQuery UI -->
    <link href="{{ asset("/bower_components/admin-lte/plugins/jQueryUI/jquery-ui-1.12.1/jquery-ui.min.css") }}" rel="stylesheet" />
    <!-- Font Awesome Icons 4.4.0 -->
    <link href="{{ asset("/bower_components/admin-lte/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.1 -->
    <link href="{{ asset("/bower_components/admin-lte/ionicons/css/ionicons.min.css") }}" rel="stylesheet" type="text/css" />
    

    <!-- Colorbox -->
    <link href="{{ asset("/assets/colorbox/example1/colorbox.css") }}" rel="stylesheet" type="text/css" />

    <!-- @cpnwaugha jQuery Toast -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/jquery.toast.css") }}" rel="stylesheet" type="text/css" />

    <!-- AdminLTE select2 -->
    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/select2/dist/css/select2.min.css") }}" >

    <!-- Theme style -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css") }}" rel="stylesheet" type="text/css" />

    <!-- MUI -->
    <link href="{{ asset("/bower_components/admin-lte/mui/css/mui.min.css") }}" rel="stylesheet" type="text/css" />


    <script src="{{ asset("/bower_components/admin-lte/mui/js/mui.min.js") }}"></script>

    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/propellerkit/components/select2/css/pmd-select2.css") }}" >
    <link rel="stylesheet" type="text/css" href="{{asset('/bower_components/admin-lte/plugins/datatables/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/bower_components/admin-lte/plugins/datatables/material.min.css') }}"> 
    <link rel="stylesheet" type="text/css" href="{{asset('/bower_components/admin-lte/plugins/datatables/dataTables.material.min.css') }}">  

    <!-- Theme style -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css") }}" rel="stylesheet" type="text/css" />

    <!-- Application CSS-->
    <link href="{{ asset(elixir('css/all.css')) }}" rel="stylesheet" type="text/css" />

    
    <!-- Head -->
    @include('partials._head')

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
    {{--  <script src="{{ asset ("/assets/attachment/scripts/jquery.min.js") }}"></script>  --}}

    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>

    <!-- JQuery UI js-->
    <script src="{{ asset("/bower_components/admin-lte/plugins/jQueryUI/jquery-ui-1.12.1/jquery-ui.min.js") }}"></script>

      <script src="{{ asset ("/bower_components/admin-lte/dist/js/jquery.toast.js") }}" type="text/javascript"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset ("/bower_components/admin-lte/dist/js/app.min.js") }}" type="text/javascript"></script>

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

      <!-- AdminLTE Select2 -->
    <script src="{{asset("/bower_components/admin-lte/select2/dist/js/select2.full.min.js")}}"></script>

    <script type="text/javascript" src="{{ asset('/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/bower_components/admin-lte/plugins/datatables/dataTables.material.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    

    <!-- Colorbox -->
    <script type="text/javascript" src="{{ asset ("/assets/colorbox/jquery.colorbox-min.js") }}"></script>

    <script src="{{asset("/bower_components/material-dashboard/assets/js/material.min.js") }}" type="text/javascript"></script>

    <!--  Notifications Plugin  -->
    <script src="{{asset("/bower_components/material-dashboard/assets/js/bootstrap-notify.js") }}"></script>

    <!-- Material Dashboard javascript methods -->
    <script src="{{asset("/bower_components/material-dashboard/assets/js/material-dashboard.js") }}"></script>

    
    <!-- Application JS-->
    <script src="{{ asset(elixir('js/all.js')) }}"></script>

    <!-- Optional header section  -->
    @yield('head_extra')

  </head>

  <!-- Body -->
  @include('partials._body')

</html>
