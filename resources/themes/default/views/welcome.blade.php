@extends('layouts.master')

@section('content')
    <div class="login-logo" style="padding-top:-20px;"><img src="{{ asset ("/assets/themes/default/img/fms.png") }}" alt="User Image" style="width:90%; height: 50%;">
        <br><h1>{{ trans('general.text.home-header') }}</h1>
    </div>
    {{--  <div class="box-body"><p class="text-center">FMS is a file messaging and logging software that allows users to pass files to one another without keeping a copy on their local device. The system has the following modules. 
    </p></div>  --}}

@endsection
