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
    .column{margin-top: -10px; float: right; }
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

    <section class="content">
        <!-- row -->
        <div class="row">
            <!-- TO DO List -->
            <div class="box box-primary">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Waiting File Request</h3>
                    <div class="box-tools pull-right">
                    <?php echo $folder_requests->render(); ?>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <ul class="todo-list">
                    @foreach($folder_requests as $folder_request)
                    <li>
                        <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                        </span>
                        <input type="checkbox" value="" name=""/>
                        

                        <?php $user = Illuminate\Support\Facades\DB::table('users')->where('email', '=', 'root@email.com')->first();
                            $temp = array();
                            foreach($user as $field => $val ){
                                $temp[$field] = $val;
                            }
                            ?>


                        <span class="text"><b> {{ $user->first_name }}, {{ $user->last_name }}</b> requsted for {{ $folder_request->foldername }}, {{ $folder_request->desc }}</span>
                        <small class="label label-warning"><i class="fa fa-clock-o"></i> {{ date('H:i A | F d, Y', strtotime($folder_request->created_at )) }}</small>
                        <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                        </div>
                    </li>
                        @endforeach

                    </ul>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                    <?php echo $folder_requests->render(); ?>
                </div>
            </div><!-- /.box -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@endsection