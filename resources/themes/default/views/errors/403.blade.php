<?php
    $page_title = 'LockScreen';
    $page_description = trans('general.error.description-403');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>KDSG | Lockscreen</title>
    <!-- Tell the browser to be responsive to screen width -->
       <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Set a meta reference to the CSRF token for use in AJAX request -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Material Design fonts -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />

    <!-- jQuery UI -->
    <link href="{{ asset("/bower_components/admin-lte/plugins/jQueryUI/jquery-ui-1.12.1/jquery-ui.min.css") }}" rel="stylesheet" />

    <!-- Bootstrap Material Design to be included-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/bootstrap-material-design/dist/css/bootstrap-material-design.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/bootstrap-material-design/dist/css/ripples.min.css") }}"> --}} 

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

    <!-- @cpnwaugha Sleek select using propeller.js -->

    <!-- Select2 css -->
    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/propellerkit/components/select2/css/select2.min.css") }}">
    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/propellerkit/components/select2/css/select2-bootstrap.css") }}" >
    <!-- Propeller typography -->
    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/propellerkit/assets/css/typography.css") }}">
    <!-- Propeller text fields -->
    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/propellerkit/components/textfield/css/textfield.css") }}"  >
    <!-- Propeller select2 -->
    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/propellerkit/components/select2/css/pmd-select2.css") }}" >


    
    <!-- Head -->
    @include('partials._head')

      <!-- REQUIRED JS SCRIPTS -->

      <!-- jQuery 2.1.4 -->
      <script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
      <!-- Bootstrap 3.3.2 JS -->
      <script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
      <!-- JQuery UI js-->
      <script src="{{ asset("/bower_components/admin-lte/plugins/jQueryUI/jquery-ui-1.12.1/jquery-ui.min.js") }}"></script>
      <!-- AdminLTE App -->
      <script src="{{ asset ("/bower_components/admin-lte/dist/js/app.min.js") }}" type="text/javascript"></script>
      <!-- @cpnwaugha jQuery Toast -->
      <script src="{{ asset ("/bower_components/admin-lte/dist/js/jquery.toast.js") }}" type="text/javascript"></script>

      <!-- Additional jQuery here. Note that some more jQuery for layout designs are in patials._body.blade.php-->

      <script src="{{asset("/bower_components/admin-lte/plugins/propellerkit/components/textfield/js/textfield.js")}}"></script>
      <script src="{{asset("/bower_components/admin-lte/plugins/propellerkit/components/select2/js/select2.full.js")}}"  ></script>
      <script src="{{asset("/js/custom.js")}}"></script>
      <script src="{{asset("/bower_components/admin-lte/plugins/propellerkit/components/select2/js/pmd-select2.js")}}"></script>


  </head>
  <body class="lockscreen">

    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
        <a href="/"><b>Defence Files</b></br>FMS | LockScreen</a>
      </div>
      <!-- User name -->
      <div class="lockscreen-name"></div>

      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
          <img src="{{ asset ("/img/profile_picture/photo/".$user->avatar) }}" alt="User Image">
        </div>
        <!-- /.lockscreen-image -->

        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials" method="POST" action="{!! route('loginPost') !!}">
        {!! csrf_field() !!}
          <div class="input-group">
          <?php $user_email = Illuminate\Support\Facades\Cache::get("user{{$user->id}}"); ?>
            <input type="hidden" id="email" name="email" class="form-control" placeholder="Email" value="{{$user_email}}" required autofocus/>
             <input type="password" id="password" name="password" class="form-control" placeholder="Password" required/>
            <div class="input-group-btn">
              <button class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
            </div>
          </div>
        </form><!-- /.lockscreen credentials -->

      </div><!-- /.lockscreen-item -->
      <div class="help-block text-center">
        Enter your password to retrieve your session
      </div>
      <div class='text-center'>
        <a href="{{ url('auth/login') }}">Or sign in as a different user</a>
      </div>
      <div class='lockscreen-footer text-center'>
        Copyright &copy; 2017-2018 <b><a href="/" class='text-black'>kaduna State Government</a></b><br>
        All rights reserved
      </div>
    </div><!-- /.center -->

    <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  </body>
</html>