@extends('layouts.master')

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

	<div class="content">
		<div class="row">
			<div class="col-md-4 col-sm-6 col-lg-6">
				<!-- Profile Image -->
				<div class="box box-primary">
					<div class="box-body box-profile">
						<div style="margin: 0 auto;">
							<img class="profile-user-img img-responsive img-circle center-block" src="{{ asset('/img/profile_picture/photo/'.$user->avatar) }}" alt="User profile picture">
						</div>

						<h3 class="profile-username text-center">{{$user->full_name}}</h3>

						{{--  <p class="text-muted text-center">{{$user->full_name}}</p>  --}}
						<ul class="list-group list-group-unbordered text-center">
							@if($user->position)
								<li class="list-group-item">
									<h6 class="category text-muted">{{$user->position}},  
							@endif
							@if($user->department)								
								<em class="">
									<?php $user_dept = ['secretreg' => 'Secret Registry', 'openreg' => 'Open Registry', 'finance' => 'Finance', 'hr' => 'Human Resources', 'gsl' => 'General Services and Logistics', 'adminsupply' => 'Admin and Supply', 'procurement' => 'Procurement', 'permsec' => 'Permanent Secretary and GOC', 'ict' => 'ICT and Communications', 'legal' => 'Legal']; ?>
									{{$user_dept[$user->department]}}
								</em>
							@endif
								</h6>
							</li>
						</ul>
						<div style="width: 70%; margin-left: 50px;" class="footer">
							{!! Form::open(['route' => 'user.profile.photo.patch', 'files' => true, 'id' => 'form_edit_picture', 'method' => 'PATCH']) !!}
								{!! Form::file('avatar') !!}
								{!! Form::submit(trans('general.button.update'), ['class' => 'pull-right btn btn-sm btn-primary']) !!}
							{!! Form::close() !!}
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
	</div>

@endsection

