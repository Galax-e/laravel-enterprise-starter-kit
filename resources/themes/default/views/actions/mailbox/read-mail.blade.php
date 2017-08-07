@extends('layouts.master')

@section('head_extra')
    <!-- jVectorMap 1.2.2 -->
    <link href="{{ asset("/bower_components/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <script>
        $( function() {
          var availableTags = [
        
          @foreach($users as $user)   
          "{{ $user->first_name}}, {{$user->last_name}}",
          @endforeach
           ""];
           availableTags.splice(0,0,' ');
          $(".select-add-tags").select2({
            data: availableTags,
            tags:false,
            theme: "bootstrap",
            minimumResultsForSearch: Infinity,
          });
        });
    </script>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <a href="{{route('inbox')}}" class="btn btn-primary btn-block margin-bottom">Back to Inbox</a>
                @include('views.actions.mailbox.left_mail_menu')
            </div><!-- /.col -->

            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Read Mail</h3>
                            <div class="box-tools pull-right">
                                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
                            </div>
                        </div><!-- /.box-header -->
                        @foreach($memos as $memo)
                        <div class="box-body no-padding">
                            <div class="mailbox-read-info">
                                <h3>{{ $memo->subject}}</h3>
                                <h6><b>From: </b>{!! $memo->emailfrom !!} 
                                    <span class="mailbox-read-time pull-right">
                                        {{ date('l jS \of F Y h:i:s A', strtotime($memo->created_at )) }}
                                    </span>
                                </h6>
                                <h6><b>To: </b>{!! $memo->emailto !!}
                            </div><!-- /.mailbox-read-info -->
                            <div class="mailbox-read-message">
                                <p>{!! $memo->message !!}</p>
                            </div><!-- /.mailbox-read-message -->
                 
                       </div><!-- /.box-body -->
                        @foreach($attachments as $attachment)
                           @if($attachment->memo_id == $memo->id)
                           <ul id="attach_image" class="mailbox-attachments clearfix attachdoc" style="margin-left: 10px;">
                           <?php
                           if (strpos($attachment->name, 'jpg') !== false) {
                           echo '
                               <li>
                                   <span class="mailbox-attachment-icon"><i class="fa fa-file-image-o"></i></span>
                                   <div class="mailbox-attachment-info">
                                           <i class="fa fa-paperclip"></i> <a href="../attachment_file/'.$attachment->name.'" style="color: #000000 ;" data-toggle="modal" data-target="#FileModal"> '.$attachment->original_name.'</a><br/> <!-- </a> -->
                                           <span class="mailbox-attachment-size">
                                               '.$attachment->created_at.'


<a href="#" data-toggle="modal" data-target="#FileModal" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>

<!-- Load file modal-->
   <div class="modal fade" id="FileModal" role="dialog">
   <div class="modal-dialog">
     <!-- Modal content-->
     <div class="modal-content">         
       <div class="box box-info">
         <div class="box-header">
           <i class="fa fa-image"></i>
           <h3 class="box-title">'.$attachment->original_name.'</h3>
           <!-- tools box -->
           <div class="pull-right box-tools">
             <button class="btn btn-info btn-sm" data-dismiss="modal" title="Remove"><i class="fa fa-times"></i></button>
           </div><!-- /. tools -->
         </div>          
             <div class="box-body">

                <object data="../attachment_file/'.$attachment->name.'" type="application/pdf" style="width: 100%" height="450">
                  <!-- support older browsers -->
                  <!-- <embed src="uploads/C_TAW12_731.pdf" type="application/pdf" width="900" height="500"/> -->
                  <!-- For those without native support, no pdf plugin, or no js -->
                  <p>It appears you do not have PDF support in this web browser. 
                  <a href="../attachment_file/'.$attachment->name.'" target="_blank">Click here to download the document.</a></p>
                </object>  
              
           </div>    
         </div>
     </div>
   </div>
 </div>
                                           </span>
                                       </div>
                               </li>';
                                 }
                                 else {
                               echo '
                               <li>
                                   <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                                   <div class="mailbox-attachment-info">
                                           <i class="fa fa-paperclip"></i> <a href="../attachment_file/'.$attachment->name.'" style="color: #000000 ;" target="_blank"> '.$attachment->original_name.'</a><br/> <!-- </a> -->
                                           <span class="mailbox-attachment-size">
                                               '.$attachment->created_at.'
<a href="#" data-toggle="modal" data-target="#FileModal" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>

<!-- Load file modal-->
   <div class="modal fade" id="FileModal" role="dialog">
   <div class="modal-dialog">
     <!-- Modal content-->
     <div class="modal-content">         
       <div class="box box-info">
         <div class="box-header">
           <i class="fa fa-file-pdf-o"></i>
           <h3 class="box-title">'.$attachment->original_name.'</h3>
           <!-- tools box -->
           <div class="pull-right box-tools">
             <button class="btn btn-info btn-sm" data-dismiss="modal" title="Remove"><i class="fa fa-times"></i></button>
           </div><!-- /. tools -->
         </div>          
             <div class="box-body">

                <object data="../attachment_file/'.$attachment->name.'" type="application/pdf" style="width: 100%" height="450">
                  <!-- support older browsers -->
                  <!-- <embed src="uploads/C_TAW12_731.pdf" type="application/pdf" width="900" height="500"/> -->
                  <!-- For those without native support, no pdf plugin, or no js -->
                  <p>It appears you do not have PDF support in this web browser. 
                  <a href="../attachment_file/'.$attachment->name.'" target="_blank">Click here to download the document.</a></p>
                </object>  
              
           </div>    
         </div>
     </div>
   </div>
 </div>


                                              <!-- <a href="../attachment_file/'.$attachment->name.'" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a> -->
                                           </span>
                                       </div>
                               </li>';
                                 }
                                 ?>
                           </ul>
                           @endif
                        @endforeach

                        @endforeach
                    
                        <div class="box-footer">
                            <div class="btn-group mailbox-controls with-border pull-right">
<script>
function myFunction() {
    window.print();
}
</script>
                               
                                <button onclick="myFunction()" class="btn btn-primary btn-raised"><i class="fa fa-print"></i> Print</button>
                            </div>
                        </div><!-- /.box-footer -->
                    </div><!-- /. box -->
                </div><!-- /.col -->
            </div><!-- /.content-wrapper -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@endsection