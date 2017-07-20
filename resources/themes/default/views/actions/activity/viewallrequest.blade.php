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
                 <?php if ($folder_request->treated == 0) {?> 
                    <li>
{{-- 
                       <form method="post" id="comment_form">
                         {{ csrf_field() }}
                           <input type="hidden" name="id" id="id" value="{{ $folder_request->id }}"/>
                          <div class="form-group">
                           <input type="submit" name="post" id="post" class="btn btn-info" value="Treat" />
                          </div>
                       </form>

--}}

                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <input type="checkbox" value="" name=""/>


                        <?php $user = Illuminate\Support\Facades\DB::table('users')->where('email', '=', 'root@hallowgate.com')->first();
                          $temp = array();
                          foreach($user as $field => $val ){
                              $temp[$field] = $val;
                          } ?>
                        
                      <span class="text" style="color: #B8B8B8;"><strike><b> {{ $user->first_name }}, {{ $user->last_name }}</b> requsted for {{ $folder_request->folder_name }}, {{ $folder_request->folder_desc }}</strike></span>
                      
                      <small class="label label-success"><i class="fa fa-clock-o"></i> {{ date('H:i A | F d, Y', strtotime($folder_request->created_at )) }}</small>
                      
                    </li>
                    <?php } ?>
                     @endforeach

              </ul>
              <div align="center"> <?php echo $folder_requests->render(); ?></div>
            </div>
            <!-- /.box-body -->
           


           <script>
$(document).ready(function(){

 $('#comment_form').on('submit', function(event){
  event.preventDefault();
   var form_data = $(this).serialize();
   $.ajax({
    url:"treatedrequest",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#comment_form')[0].reset();
    }
   })

 });
});
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

@endsection