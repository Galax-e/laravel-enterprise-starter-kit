<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-blue sidebar-collapse sidebar-mini">

    <!-- Main body content -->
    @include('partials._body_content')


    <!-- Footer -->
    @include('partials._footer')

    <!-- Optional bottom section for modals etc... -->
    @yield('body_bottom')

    <!-- Body Bottom modal DEFAULT dialog-->
    <div class="modal fade" id="modal_dialog" tabindex="-1" role="dialog" aria-labelledby="modal_dialog_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <!-- Body Bottom modal PRIMARY dialog-->
    <div class="modal modal-primary fade" id="modal_dialog_primary" tabindex="-1" role="dialog" aria-labelledby="modal_dialog_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <!-- Body Bottom modal INFO dialog-->
    <div class="modal modal-info fade" id="modal_dialog_info" tabindex="-1" role="dialog" aria-labelledby="modal_dialog_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <!-- Body Bottom modal WARNING dialog-->
    <div class="modal modal-warning fade" id="modal_dialog_warning" tabindex="-1" role="dialog" aria-labelledby="modal_dialog_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <!-- Body Bottom modal SUCCESS dialog-->
    <div class="modal modal-success fade" id="modal_dialog_success" tabindex="-1" role="dialog" aria-labelledby="modal_dialog_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <!-- Body Bottom modal DANGER dialog-->
    <div class="modal modal-danger fade" id="modal_dialog_danger" tabindex="-1" role="dialog" aria-labelledby="modal_dialog_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

     <!-- Request file modal-->
   <div class="modal fade" id="requestFileModal" role="dialog">
   <div class="modal-dialog">
     <!-- Modal content-->
     <div class="modal-content">         
       <div class="box box-info">
         <div class="box-header">
           <i class="fa fa-envelope"></i>
           <h3 class="box-title">Request for file</h3>
           <!-- tools box -->
           <div class="pull-right box-tools">
             <button class="btn btn-info btn-sm" data-dismiss="modal" title="Remove"><i class="fa fa-times"></i></button>
           </div><!-- /. tools -->
         </div>          
         <form method="post" id="request_form" action="requestform">

             {{ csrf_field() }}
             <div class="box-body">
               <div class="form-group">
                 <input type="text" class="form-control" id="name" name="name" placeholder="File No/ Name"/>
               </div>
               <div>
                 <textarea class="textarea" name="desc" id="desc" placeholder="Enter a description about the folder or file ..." style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
               </div>
           </div>
           <div class="box-footer clearfix">
             <button id='requestFileBtn' type="submit" class="pull-right btn btn-primary btn-raised" name="post" id="post">Send <i class="fa fa-arrow-circle-right"></i></button>
           </div>
         </form>        
         </div>
     </div>
   </div>
 </div>
 
    <!-- Create pin modal-->
    <div class="modal fade" id="createPinModal" role="dialog">
    <div class="modal-dialog" style="width: 400px;">
    
        <!-- Modal content-->
        <div class="modal-content">      
            
            <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-key"></i>
                <h3 class="box-title">Create/Change PIN</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
            <button class="btn btn-info btn-sm" data-dismiss="modal" title="Remove"><i class="fa fa-times"></i></button></div><!-- /. tools -->
            </div>        
        <form method="post" action="storepinform">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <input type="password" class="form-control" id="new_pin" name="new_pin" placeholder="New PIN"/>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="confirmpin" name="confirmpin" placeholder="confirm PIN"/>
                </div>
            </div>
            <div class="box-footer clearfix">
                <button id="createPinBtn" type="submit" class="pull-right btn btn-info btn-raised" name="post" id="post">Send <i class="fa fa-arrow-circle-right"></i></button>
            </div>
        </form>             
        </div>    
        </div>
    </div>
    </div>

    <!-- pin verification -->
    <div class="modal fade" id="createPinModal" role="dialog">
    <div class="modal-dialog" style="width: 400px;">
    
        <!-- Modal content-->
        <div class="modal-content">      
            
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-key"></i>
                    <h3 class="box-title">Enter your PIN</h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button class="btn btn-info btn-sm" data-dismiss="modal" title="Remove"><i class="fa fa-times"></i></button>
                    </div><!-- /. tools -->
                </div> <!-- /. box-header -->
            </div>        
            <form method="post" id="verify_pin_form" action="verifypinform">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="pin_verification" name="pin_verification" placeholder="Enter your PIN"/>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <button id="verifPinBtn" type="button" class="pull-right btn btn-info btn-raised" name="post" id="post">Send <i class="fa fa-arrow-circle-right"></i></button>
                </div>
            </form>             
        </div> <!-- modal-content -->    
    </div>
    </div>

    <!-- @cpnwaugha: c-e needed to bring in all the pretty adminLTE functions-->
    <!--FastClick -->
    <script src="{{ asset("/bower_components/admin-lte/plugins/fastclick/fastclick.min.js") }}" type="text/javascript"></script>

    <!-- Sparkline -->
    <script src="{{ asset("/bower_components/admin-lte/plugins/sparkline/jquery.sparkline.min.js") }}" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="{{ asset("/bower_components/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("/bower_components/admin-lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js") }}" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="{{ asset("/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js") }}" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="{{ asset("/bower_components/admin-lte/plugins/chartjs/Chart.min.js") }}" type="text/javascript"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!--<script src="{{ asset("/bower_components/admin-lte/dist/js/pages/dashboard2.js") }}" type="text/javascript"></script>-->
    <!-- AdminLTE for demo purposes -->

    @if(Auth::check())
        @if(Auth::user()->isRoot())
            <script src="{{ asset("/bower_components/admin-lte/dist/js/demo.js") }}" type="text/javascript"></script>
        @endif
    @endif

    <script>
        $(function(){
            $('#navi').hover(function(){
                $(this).animate({width:'200px'},500);
            },function(){
                $(this).animate({width:'65px'},500);
            }).trigger('mouseleave');
        });
    </script>

    <script type="text/javascript" src="{{ asset ("/packages/barryvdh/elfinder/js/standalonepopup.min.js") }}"></script>

</body>
