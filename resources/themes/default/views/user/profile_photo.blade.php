@extends('layouts.master')

@section('head_extra')
    <!-- Select2 css -->
    @include('partials._head_extra_select2_css')
@endsection

@section('content')

	@if (count($errors) > 0)
		<div class="alert alert-danger">
		    <strong>Whoops!</strong> There were some problems with your input.<br><br>
		    <ul>
		        @foreach ($errors->all() as $error)
		            <li>{{ $error }}</li>
		        @endforeach
		    </ul>
		</div>
	@endif

	<div class="tab-pane" id="tab_pix">
	    <div class="form-group">
	        <div class="box-body no-padding">
	            <img src="img/profile_picture/photo/{{ $user->avatar }}" class="offline" style="width: 150px; height: 150px; float: left; border-radius: 50%; margin-right: 25px;" alt="User Image"/>

	            <div style="width: 40%; margin-left: 30px;" class="form-group">
	            	{!! Form::open(['route' => 'user.profile.photo.patch', 'files' => true, 'id' => 'form_edit_picture', 'method' => 'PATCH']) !!}
						{!! Form::label('profile_picture', trans('general.status.profile.photo.update')) !!}
						{!! Form::file('avatar') !!}
						{!! Form::submit(trans('general.button.update'), ['class' => 'pull-right btn btn-sm btn-primary']) !!}
					{!! Form::close() !!}
	            </div>
	            
	        </div>
	    </div>
	</div><!-- /.tab-pane -->
@endsection





{{--{!! Form::open(['route' => 'user.profile.photo.patch', 'files' => true, 'id' => 'form_edit_picture', 'method' => 'PATCH']) !!}
	{!! Form::label('profile_picture', trans('general.status.profile.photo.update')) !!}
	{!! Form::file('avatar') !!}
	{!! Form::submit('general.button.update', ['class' => 'pull-right btn btn-sm btn-primary']) !!}
{!! Form::close() !!}--}}
