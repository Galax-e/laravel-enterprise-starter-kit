@extends('layouts.master')

@section('head_extra')
    <!-- jVectorMap 1.2.2 -->
    <link href="{{ asset("/bower_components/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css") }}" rel="stylesheet" type="text/css" />  
    @include('partials._head_extra_jstree_css')
    @include('partials._head_extra_select2_css')
@endsection

@section('content')

  <style type="text/css">
    #read-time{
      color:  tomato;
    }
    .box-footer{
      
    }
    .mailbox-attachment-icon{
      width:200px !important;
      height:105px !important;
      background-color: #efe;
    }
    .mailbox-attachment-info{
      width: 200px !important;
      height: 70px;
    }
    #activity-timeline{
      margin-top: -15px !important;
    }
  </style>
  <script>
    $( function() {
      var availableTags = [
          @foreach($users as $user)   
             "@if($user->position){{$user->position}} - @endif {{ $user->first_name }}, {{$user->last_name}}",
          @endforeach
          ""
        ];

      availableTags.splice(0, 0,'Select Recipient');
      
      $(".select-with-search").select2({
        data: availableTags,
        placeholder: "Select Recipient",
        theme: "bootstrap",
        minimumResultsForSearch: Infinity
      });
    });
  </script>

  <style type="text/css">
    .column{margin-top: -10px; float: right; }
  </style>
 
            <section class="content">

          <!-- row -->
          <div class="row">
            <div class="col-md-12">
              <!-- The time line -->
              <ul class="timeline">
                <!-- timeline time label -->
                <li class="time-label">
                  <span class="bg-red">
                    <?php echo date("l"). ", "; echo date('d M Y');?>
                  </span>
                </li>
                <!-- /.timeline-label -->
          



            <ul class="nav nav-tabs">
               <li class="pull-right"> 
                <div class="has-feedback">
                 <form class="tg-formtheme tg-formsearch" method="POST" action="searchcontact">
                    {{ csrf_field() }}
                          <input type="text" name="search" class="form-control input-sm" placeholder="Search Contact"/>
                          <span class="glyphicon glyphicon-search form-control-feedback"></span>
                  </form>
                 </div>
                </li>
            </ul>
            </br>

<div class="row">
@foreach($users as $user)
      <div class="col-md-2">
                  <!-- USERS LIST -->
                  <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title">Kaduna State Government</h3>
                      <div class="box-tools pull-right">
                      </div>
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
                              <ul class="list-group list-group-unbordered">
                                  <li class="list-group-item">
                                    <b>Position</b> <a class="pull-right">{{ $user->position }}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Department</b> <a class="pull-right">{{ $user->department }}</a>
                                  </li>
                              </ul>
                          </span>
                          </div>
                    </div><!-- /.box-body -->
                   
                  </div><!--/.box -->
      </div><!-- /.col -->
@endforeach 
      </div>
      <!-- /.row -->
        </section><!-- /.content -->

    {{-- <script>
    // Work on this later. Fix like on Linked in
    // http://jsfiddle.net/FDv2J/1913/
    // https://css-tricks.com/scroll-fix-content/
    // https://forums.digitalpoint.com/threads/stop-scrolling-div-before-footer.2751269/
      // $(document).scroll(function(){
      //   $('.main-header').css('position', 'fixed');
      // }).mouseup(function(){
      //   $('.navbar').css('position', 'absolute');
      // }).keyup(function(){
      //   $('.navbar').css('position', 'relative');
      // });     
   //</script> --}}
@endsection