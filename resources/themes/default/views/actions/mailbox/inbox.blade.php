@extends('layouts.special_master')

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
            <a href="{{route('compose')}}" class="btn btn-primary btn-block margin-bottom">To Compose</a>
            @include('views.actions.mailbox.left_mail_menu')
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><b>Inbox</b></h3>

            </div><!-- /.box-header -->
            <div class="box-body no-padding">
            <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Email From</th>
                <th>Mail</th>
                <th>Time</th>
            </tr>
            </thead>
            <tbody>
            
            @foreach($memos as $memo)
            <tr>
                <td>{{ $memo->emailfrom }}</td>
                <td><a href="read_memo/{{ $memo->id }}"><b>{{ str_limit($memo->subject, 25) }} </b></a> | <em>{{ str_limit(strip_tags(substr($memo->message, 0, -6)), 70) }}</em></td>
                <td>{{ date('F d, Y', strtotime($memo->created_at)) }}</td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>Email From</th>
                <th>Mail</th>
                <th>Time</th>
            </tr>
            </tfoot>
            </table>
        </div>
            </div><!-- /.box-body -->
            
            </div><!-- /. box -->
        </div><!-- /.col -->
      </div><!-- /.row -->

  </section><!-- /.content -->

  <!-- page script -->
    <script>
        $(function () {
            $('#example1').DataTable()
            $('#example2').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
            })
        })
    </script>
@endsection
