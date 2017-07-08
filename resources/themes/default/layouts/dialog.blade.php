<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ Setting::get('app.short_name') }} | {{ $page_title or "Page Title" }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Set a meta reference to the CSRF token for use in AJAX request -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons 4.4.0 -->
    <link href="{{ asset("/bower_components/admin-lte/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.1 -->
    <link href="{{ asset("/bower_components/admin-lte/ionicons/css/ionicons.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{{ asset("/bower_components/admin-lte/plugins/iCheck/square/blue.css") }}" rel="stylesheet" type="text/css" />
    
    <!-- Custom favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset ("/assets/themes/default/img/favicon.png") }}" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Optional header section  -->
    @yield('head_extra')

</head>
<body class="login-page">

<div class="box-body">
    @include('flash::message')
    @include('partials._errors')
</div>
<style type="text/css">
    .login-box{margin-top: -10px; width: 409px;}
</style>

<div class="login-box">
    <div class="login-logo">
        <div class="login-logo" style="padding-top:-20px;"><img src="{{ asset ("/assets/themes/default/img/fms.png") }}" alt="User Image"></div>
        {!! Setting::get('app.long_name') !!}<br/> FMS | {{ $page_title or "Page Title" }}
    </div><!-- /.login-logo -->
    <div class="login-box-body">

        <!-- Your Page Content Here -->
        @yield('content')

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
<!-- iCheck -->
<script src="{{ asset("/bower_components/admin-lte/plugins/iCheck/icheck.min.js") }}" type="text/javascript"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
