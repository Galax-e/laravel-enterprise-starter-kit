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
    #activity-timeline{
      margin-top: -15px !important;
    }
  </style>

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
              <?php echo date("l"). ", "; echo date('d M Y'); ?>
            </span>
          </li>
          <!-- /.timeline-label -->
          <li>
            <ul class="nav nav-tabs">
              <li class="pull-right"> 
              <div class="has-feedback">
                <form class="tg-formtheme tg-formsearch" method="POST" action="searchactivity">
                  {{ csrf_field() }}
                    <input type="text" name="search" class="form-control input-sm" placeholder="Search Activities"/>
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </form>
                </div>
              </li>
            </ul>
          </li>
          </br>
          @foreach($activity as $activity_by)
            <?php
            if (strpos($activity_by->activity, 'Comment') !== false) {
            echo '
            <li>
              <i class="fa fa-comments bg-yellow"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i A | F d, Y', strtotime($activity_by->created_at )).'</span>
                <h3 class="timeline-header"><a href="#">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> '.$activity_by->activity.'</h3>
                <div class="timeline-body">
                  '.Str_limit($activity_by->comment, 250).'
                </div>
                <div class="timeline-footer">   
                </div>
              </div>
            </li>';
              }
              elseif (strpos($activity_by->activity, 'mail') !== false) {
            echo '
            <li>
              <i class="fa fa-envelope bg-blue"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i A | F d, Y', strtotime($activity_by->created_at )).'</span>
                <h3 class="timeline-header"><a href="#">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> '.$activity_by->activity.'</h3>
                <div class="timeline-body">
                    <b>'.Str_limit($activity_by->comment, 250).'</b>, '.Str_limit($activity_by->memo, 250).'
                </div>
                <div class="timeline-footer">
                  
                </div>
              </div>
            </li>';
              }
            elseif (strpos($activity_by->activity, 'Successful') !== false) {
            echo '
            <li>
              <i class="fa fa-user bg-aqua"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i A | F d, Y', strtotime($activity_by->created_at )).'</span>
                <h3 class="timeline-header no-border"><a href="#">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> '.$activity_by->activity.'</h3>
              </div>
            </li>';
              }
              elseif (strpos($activity_by->activity, 'PIN') !== false) {
            echo '
            <li>
              <i class="fa fa-key bg-black"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i A | F d, Y', strtotime($activity_by->created_at )).'</span>
                <h3 class="timeline-header no-border"><a href="#">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> '.$activity_by->activity.'</h3>
              </div>
            </li>';
              }
            elseif (strpos($activity_by->activity, 'Forward') !== false) {
            echo '
            <li>
              <i class="fa fa-folder bg-purple"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i A | F d, Y', strtotime($activity_by->created_at )).'</span>
                <h3 class="timeline-header"><a href="#">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> '.$activity_by->activity.'</h3>
                <div class="timeline-body">
                  <img src="'.asset('/img/folder.png').'" width="150" alt="folder" class="margin" /><b>'.$activity_by->fileinfo.'</b>
                </div>
              </div>
            </li>';
              }
              elseif (strpos($activity_by->activity, 'Delete') !== false) {
            echo '
            <li>
              <i class="fa fa-folder bg-purple"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i A | F d, Y', strtotime($activity_by->created_at )).'</span>
                <h3 class="timeline-header"><a href="#">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> '.$activity_by->activity.'</h3>
                <div class="timeline-body">
                  <img src="'.asset('/img/folder.png').'" width="150" alt="folder" class="margin" /><b>'.$activity_by->fileinfo.'</b>
                </div>
              </div>
            </li>';
              }
              elseif (strpos($activity_by->activity, 'Move') !== false) {
            echo '
            <li>
              <i class="fa fa-folder bg-purple"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i A | F d, Y', strtotime($activity_by->created_at )).'</span>
                <h3 class="timeline-header"><a href="#">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> '.$activity_by->activity.'</h3>
                <div class="timeline-body">
                  <img src="'.asset('/img/folder.png').'" width="150" alt="folder" class="margin" /><b>'.$activity_by->fileinfo.'</b>
                </div>
              </div>
            </li>';
              }

                elseif (strpos($activity_by->activity, 'new folder') !== false) {
            echo '
            <li>
              <i class="fa fa-folder bg-purple"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i A | F d, Y', strtotime($activity_by->created_at )).'</span>
                <h3 class="timeline-header"><a href="#">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> '.$activity_by->activity.'</h3>
                <div class="timeline-body">
                  <img src="'.asset('/img/folder.png').'" width="150" alt="folder" class="margin" /><b>'.$activity_by->fileinfo.'</b>
                </div>
              </div>
            </li>';
              }
              elseif (strpos($activity_by->activity, 'Document') !== false) {
            echo '
            <li>
              <i class="fa fa-file bg-purple"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i A | F d, Y', strtotime($activity_by->created_at )).'</span>
                <h3 class="timeline-header"><a href="#">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> '.$activity_by->activity.'</h3>
                <div class="timeline-body">
                  <ul class="mailbox-attachments clearfix">
            
                  <li><span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                    <div class="mailbox-attachment-info">
                      <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> '.$activity_by->fileinfo.'</a>
                          <span class="mailbox-attachment-size">'
                            .date('H:i A | F d, Y', strtotime($activity_by->created_at )).'
                          </span>
                    </div>
              </li></ul></div>
              </div>
            </li>
            ';
              }
              elseif (strpos($activity_by->activity, 'Requested') !== false) {
            echo '
            <li>
              <i class="fa fa-folder bg-purple"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i A | F d, Y', strtotime($activity_by->created_at )).'</span>
                <h3 class="timeline-header"><a href="#">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> '.$activity_by->activity.'</h3>
                <div class="timeline-body">
                  <img src="'.asset('/img/folder.png').'" width="150" alt="folder" class="margin" /><b>'.$activity_by->fileinfo.'</b>
                </div>
              </div>
            </li>';
              }

              elseif (strpos($activity_by->activity, 'document') !== false) {
            echo '
            <li>
              <i class="fa fa-cloud-upload bg-purple"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i A | F d, Y', strtotime($activity_by->created_at )).'</span>
                <h3 class="timeline-header"><a href="#">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> '.$activity_by->activity.'</h3>
                <div class="timeline-body">
                  <i class="fa fa fa-file-pdf-o fa-5x"></i><b>'.$activity_by->fileinfo.'</b>
                </div>
              </div>
            </li>';
              }
            ?>
          @endforeach
          </ul>
        <div align="center"> <?php echo $activity->render(); ?></div>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
@endsection