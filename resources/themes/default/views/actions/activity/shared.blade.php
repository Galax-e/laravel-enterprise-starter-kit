@extends('layouts.master')

@section('head_extra')
    <!-- jVectorMap 1.2.2 -->
    <link href="{{ asset("/bower_components/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css") }}" rel="stylesheet" type="text/css" />  
    @include('partials._head_extra_jstree_css')
    @include('partials._head_extra_select2_css')
@endsection

@section('content')

  <style type="text/css">    
    .mailbox-attachment-icon{
      width:200px !important;
      height:105px !important;
    }
    .mailbox-attachment-info{
      width: 200px !important;
      height: 70px;
    }
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
          <li>
            <ul class="nav nav-tabs">
              <li class="pull-right"> 
                <div class="has-feedback">
                <form class="tg-formtheme tg-formsearch" method="GET" action="{{route('search_viewall')}}">
                    {{ csrf_field() }}
                    <input type="text" name="searchterm" class="form-control input-sm" placeholder="Search Activities"/>
                    <span class="form-control-feedback"><i class="fa fa-search"></i></span>
                  </form>
                </div>
                </li>
            </ul>
          </li>
          </br>
          <li>
            <i class="fa fa-file bg-purple"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> <?php echo date("l"). ", "; echo date('d M Y');?></span>
              <h3 class="timeline-header"><b>File Tracking</b><em> (current holders)</em></h3>
              <div class="timeline-body">
                <ul class="mailbox-attachments clearfix">
                @foreach($folders as $folder)
                  <?php
                    $current_holder = \App\User::where('email', $folder->folder_to)->first();
                    $current_holder = $current_holder->full_name;
                  ?>                                            
                  <li>
                    <span class="mailbox-attachment-icon"><i class="fa fa-folder-open"></i></span>
                    <div class="mailbox-attachment-info">
                      <a href="#" class="mailbox-attachment-name"><i class="fa fa-folder"></i>{{$folder->name}}</a><br/>
                        <span>
                          <small>Held by <label></label><b style="color: tomato;">{{$current_holder}}</b></small>
                        </span>
                        <span class="mailbox-attachment-size">
                          {{date('H:i A | F d, Y', strtotime($folder->created_at ))}}
                        </span>
                    </div>
                  </li>
                @endforeach
                </ul>
                <div align="center"> </div>
              </div><!-- ./timeline-body -->
            </div> <!-- ./timeline time -->
          </li>
        </ul>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
@endsection