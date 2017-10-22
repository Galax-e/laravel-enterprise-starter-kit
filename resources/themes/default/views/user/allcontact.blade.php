@extends('layouts.master')

@section('head_extra')
    <!-- jVectorMap 1.2.2 -->
    <link href="{{ asset("/bower_components/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css") }}" rel="stylesheet" type="text/css" />  
    @include('partials._head_extra_jstree_css')
    @include('partials._head_extra_select2_css')
@endsection

@section('content')
  <style type="text/css">
   
  </style>
 
  <section class="content">
    <!-- row -->
    <div class="row">
      <div class="col-xs-12">
        <!-- The time line -->
        <ul class="timeline">
          <!-- timeline time label -->
          <li class="time-label">
            <span class="bg-red">
              <?php echo date("l"). ", "; echo date('d M Y');?>
            </span>
          </li>
          <!-- /.timeline-label -->
          <li>
            <ul class="nav nav-tabs">
              <li class="pull-right"> 
                <div class="has-feedback">
                  <form class="tg-formtheme tg-formsearch" method="POST" action="{{route('searchcontact')}}">
                    {{ csrf_field() }}
                      <input type="text" name="search" class="form-control input-sm" placeholder="Search Contact"/>
                      <span class="form-control-feedback"><i class="fa fa-search"></i></span>
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
        </br>
      </div> <!-- ./col -->
    </div><!-- ./row -->

    <div class="row">
    @foreach($users as $user)
      <div class="col-md-2">
        <!-- USERS LIST -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Kaduna State Government</h3>
            <div class="box-tools pull-right"></div>
          </div><!-- /.box-header -->
          <div class="box-body no-padding">
            <div align="center">
              <img src="{{asset("/img/profile_picture/photo/".$user->avatar) }}" style="width: 60%; height: 120px;" alt="User Image"/>
              <a class="users-list-name" href="#" data-toggle="modal" data-target="#myModal">{{ $user->first_name }} {{ $user->last_name }}</a>
              <span class="users-list-date">{{ date('H:i A | F d, Y', strtotime( $user->created_at )) }}</span>
            </div>
            </br>
            <div>
              <span class="users-list-date">
                <ul class="list-group">
                  <li class="list-group-item">
                    <b>Position: </b> <a class="pull-right">{{ $user->position }}</a>
                  </li>
                  <li class="list-group-item">
                    @if($user->department)								
                      <em>
                        <?php $user_dept = ['secretreg' => 'Secret Registry', 'openreg' => 'Open Registry', 'finance' => 'Finance', 'hr' => 'Human Resources', 'gsl' => 'General Services and Logistics', 'adminsupply' => 'Admin and Supply', 'procurement' => 'Procurement', 'permsec' => 'Permanent Secretary and GOC', 'ict' => 'ICT and Communications', 'legal' => 'Legal']; ?>
                        <b>Department:</b>
                        <a class="pull-right" title="{{$user_dept[$user->department]}}">{{str_limit($user_dept[$user->department],10)}}</a>
                      </em>
                      @else
                        <label>No Department</label>
                    @endif
                    
                  </li>
                </ul>
              </span>
            </div>
          </div><!-- /.box-body -->
        </div><!--/.box -->
      </div><!-- /.col -->
    @endforeach 
    </div><!-- /.row -->
  </section><!-- /.content -->
@endsection