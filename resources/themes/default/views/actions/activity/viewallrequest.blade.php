@extends('layouts.master')

@section('head_extra')

@endsection

@section('content')

  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-9 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->

              <!-- Morris chart - Sales -->
              <div class="hidden chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
              <div class="hidden chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>

          <!-- /.nav-tabs-custom -->

         

          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Request Board List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
              <ul class="todo-list">


                @foreach($folder_requests as $folder_request)
                 <?php if ($folder_request->treated == 1) {?> 
                    <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <input type="checkbox" value="" name="" disabled/>


                        <?php $user = Illuminate\Support\Facades\DB::table('users')->where('email', '=', 'root@hallowgate.com')->first();
                          $temp = array();
                          foreach($user as $field => $val ){
                              $temp[$field] = $val;
                          } ?>
                        
                      <span class="text" style="color: #B8B8B8;"><strike><b> {{ $user->first_name }}, {{ $user->last_name }}</b> requsted for {{ $folder_request->folder_name }}, {{ $folder_request->folder_desc }}</strike></span>
                      
                      <small class="label label-default"><i class="fa fa-clock-o"></i> {{ date('H:i A | F d, Y', strtotime($folder_request->created_at )) }}</small>
                      
                    </li>
                    <?php } 
                      else {?> 
                     <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>

                      {{-- 
                       <form method="post" id="comment_form">
                         {{ csrf_field() }}
                           <input type="hidden" name="id" id="id" value="{{ $folder_request->id }}"/>
                          <div class="form-group">
                           <input type="submit" name="post" id="post" class="btn btn-info" value="Treat" />
                          </div>
                       </form>
                      --}}

                      <input type="checkbox" onclick="startAjax( {{ $folder_request->id, Auth::user()->email }} )" id="request{{ $folder_request->id }}" value="" name=""/>


                        <?php $user = Illuminate\Support\Facades\DB::table('users')->where('email', '=', 'root@hallowgate.com')->first();
                          $temp = array();
                          foreach($user as $field => $val ){
                              $temp[$field] = $val;
                          } ?>
                        
                      <span class="text"><b> {{ $user->first_name }}, {{ $user->last_name }}</b> requsted for {{ $folder_request->folder_name }}, {{ $folder_request->folder_desc }}</span>
                      
                      <small class="label label-primary"><i class="fa fa-clock-o"></i> {{ date('H:i A | F d, Y', strtotime($folder_request->created_at )) }}</small>
                      
                    </li>
                    <?php } ?>
                     @endforeach

              </ul>
              <div align="center"> <?php echo $folder_requests->render(); ?></div>
            </div>
            <!-- /.box-body -->
          
           <script type='text/javascript'>
    
            //AJAX function
            function startAjax(id=0, handleremail='root@hallowgate.com') {
              var data = {id: id, handleremail: handleremail};
              console.log(handleremail);
              $.ajax({
                method: "POST",
                url: "insert",
                data: data, // "id=3&treated=1",
                dataType: 'text'
              }).done(function(data){
                console.log(data);
              }).fail(function(data){
                console.log(data);
              });
            }
            
            //Call AJAX:
            $(document).ready(startAjax);
           </script>


          </div>
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-3 connectedSortable">


 <!-- ./col -->
        <div class="">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$request_count}}</h3>

              <p>Total Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Pool of request <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$completedrequest_count}}</h3>

              <p>Request Worked On</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Completed request <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
       

          <div class="hidden box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Sales Graph</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div>
          </div>
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
    </section>


<script src="{{ asset("/bower_components/jquery/dist/jquery.min.js") }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset("/bower_components/jquery-ui/jquery-ui.min.js") }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset("/bower_components/bootstrap/dist/js/bootstrap.min.js") }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset("/bower_components/raphael/raphael.min.js") }}"></script>
<script src="{{ asset("/bower_components/morris.js/morris.min.js") }}"></script>
<!-- Sparkline -->
<script src="{{ asset("/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js") }}"></script>
<!-- jvectormap -->
<script src="{{ asset("/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js") }}"></script>
<script src="{{ asset("/plugins/jvectormap/jquery-jvectormap-world-mill-en.js") }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset("/bower_components/jquery-knob/dist/jquery.knob.min.js") }}"></script>
<!-- daterangepicker -->
<script src="{{ asset("/bower_components/moment/min/moment.min.js") }}"></script>
<script src="{{ asset("/bower_components/bootstrap-daterangepicker/daterangepicker.js") }}"></script>
<!-- datepicker -->
<script src="{{ asset("/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js") }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset("/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js") }}"></script>
<!-- Slimscroll -->
<script src="{{ asset("/bower_components/jquery-slimscroll/jquery.slimscroll.min.js") }}"></script>
<!-- FastClick -->
<script src="{{ asset("/bower_components/fastclick/lib/fastclick.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("/dist/js/adminlte.min.js") }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset("/dist/js/pages/dashboard.js") }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset("/dist/js/demo.js") }}"></script>
@endsection