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
        color: tomato;
    }
    .box-footer{
      
    }
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
                    <?php echo date("l"). ", "; echo date('d M Y');?>
                  </span>
                </li>
                <!-- /.timeline-label -->
          



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
            </br>





                  <li>
                  <i class="fa fa-file bg-purple"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> <?php echo date("l"). ", "; echo date('d M Y');?></span>
                    <h3 class="timeline-header"> Shared Files or Live Files</h3>
                    <div class="timeline-body">
                      <ul class="mailbox-attachments clearfix">


        @foreach($folders as $folder)
                <?php

                echo '
                 
                 <li><span class="mailbox-attachment-icon"><i class="fa fa-folder-open"></i></span>
                        <div class="mailbox-attachment-info">
                          <a href="#" class="mailbox-attachment-name"><i class="fa fa-folder"></i> '.$folder->name.'</a>
                              <span class="mailbox-attachment-size">'
                                .date('H:i A | F d, Y', strtotime($folder->created_at )).'
                              </span>
                        </div>
                 </li>';

                ?>
        @endforeach

              </ul>
             <div align="center"> </div>

                </div>
                  </div>
                </li>





<!-- 
        
                if (strpos($activity_by->activity, 'login') !== false) {
                echo '
                <li>
                  <i class="fa fa-envelope bg-blue"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>
                    <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                    <div class="timeline-body">
                      Take me to your leader!
                      Switzerland is small and neutral!
                      We are more like Germany, ambitious and misunderstood!
                    </div>
                    <div class='timeline-footer'>
                      <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                    </div>
                  </div>
                </li>';
                  }
/.content -->








  






            </div><!-- /.col -->
          </div><!-- /.row -->
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