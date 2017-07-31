<style type="text/css">
    #image_view_update:hover{
       /* box-shadow: 0 0 5px #8E8E38; */
    }
    .main-header {
        width:100%;
        position:fixed;
        top:0px;
    }
</style>
<script type="text/javascript">
    $(function(){
        var imageBgCol = $('.user-header').css('background-color');
        $('#image_view_update').css('background-color', imageBgCol);
    });
    
</script>


<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{{ Setting::get('app.short_name') }}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{!! Setting::get('app.long_name') !!}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                @if (Auth::check())

                    {{--  @if ( Setting::get('app.context_help_area') && (isset($context_help_area)))
                        {!! $context_help_area   !!}
                    @endif  --}}

                    @if ( Setting::get('app.notification_area') )
                        <!-- Messages: style can be found in dropdown.less-->                        

                        <li class="">
                           <!-- Request File button -->
                           <a href="{{route('dashboard')}}" class="btn btn-block" title="Home">
                               <i id="" class="fa fa-home"></i>
                           </a>
                       </li>

                       <li class="">
                           <!-- Request File button -->
                           <a href="{{route('compose')}}" class="btn btn-block" title="eDispatch">
                               <i id="" class="fa fa-send"></i>
                           </a>
                       </li>

                        <li class="">
                           <!-- Request File button -->
                           <a href="#" class="btn btn-block" title="Request file" data-toggle="modal" data-target="#requestFileModal">
                               <i id="" class="fa fa-file"></i>
                           </a>
                       </li>                        
                       {{--  <li class="">
                           <!-- Create Pin button -->
                            <a href="#" class="btn btn-block btn-success" title="Create Pin" data-toggle="modal" data-target="#createPinModal">
                               <i class="fa fa-key"></i>
                           </a>
                       </li>  --}}

                        <li class="dropdown messages-menu">
                            <!-- Menu toggle button -->
                             <a href="#" id="memo_toggle" class="dropdown-toggle" data-toggle="dropdown">
                                <i id="memo_notif_icon" class="fa fa-envelope-o"></i>
                                <span id="memo_notif" class="label label-success"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Messages</li>
                                <li>
                                    <!-- inner menu: contains the messages -->
                                    <ul class="menu">
                                        <?php $useremail = Auth::user()->email; $memos = Illuminate\Support\Facades\DB::select('select * from memos where emailto = ? and treated=0 order by created_at desc limit 5', [$useremail]); ?>
                                        <?php $loopindex = 0; ?>
                                        @foreach($memos as $memo)  
                                            <?php $loopindex++; ?>

                                            <script>
                                                $(function(){
                                                    $('#memo_toggle, #inbox_left_li').on("click", function(){
                                                        $.ajax({
                                                            url:"seen_memo/{{ $loopindex }}",
                                                            method:"GET",
                                                            dataType:"json",
                                                            success:function(data)
                                                            {
                                                                console.log('success seen memo');
                                                            },
                                                            error:function(){
                                                                console.log('error, connecting to memo notification controller ');
                                                            }
                                                        });
                                                    });
                                                })
                                            </script>

                                            <li id="seen_memo{{ $loopindex }}"><!-- start message -->
                                                <a href="{{url('read_memo/'.$memo->id) }}">
                                                    <div class="pull-left">
                                                        <!-- User Image -->
                                                        <?php $user = Illuminate\Support\Facades\DB::table('users')->where('email', '=', $memo->emailfrom)->first();
                                                        
                                                        $temp = array();
                                                        foreach($user as $field => $val ){
                                                            $temp[$field] = $val;
                                                        }
                                                        
                                                        $user_avatar = $temp['avatar']; $user_name = $temp['first_name'] . ', '.$temp['last_name']  ?>
                                                        <img src="{{ asset('/img/profile_picture/photo/'.$user_avatar) }}" class="img-circle" alt="User Image"/>
                                                    </div>
                                                    <!-- Message title and timestamp -->
                                                    <h4>
                                                        {{ $user_name }}
                                                        <small class="label label-primary pull-right">{{ date('F d h:i:s A', strtotime($memo->created_at )) }} </small>
                                                        <i class="fa fa-clock-o pull-right"></i>
                                                    </h4>
                                                    <!-- The message -->
                                                    <p>{{ $memo->subject}}</p>
                                                </a>
                                            </li><!-- end message -->                                                 
                                        @endforeach 
                                    </ul><!-- /.menu -->
                                </li>
                                <li class="footer"><a href="{{url('inbox')}}">See All Messages</a></li>
                            </ul>
                        </li><!-- /.messages-menu -->
                        <!-- Notifications Menu -->

                         @if(Auth::user()->roles->count() > 1)
                            <li class="dropdown notifications-menu">
                                <!-- Menu toggle button -->
                                <a href="#" id="request_file_toggle" class="dropdown-toggle" data-toggle="dropdown">
                                    <i id="request_file_notif_icon" class="fa fa-bell-o"></i>
                                    <span id='request_file_notif' class="label label-warning"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Folder Requests</li>
                                   
                                    <li>
                                        <!-- Inner Menu: contains the notifications -->
                                        
                                        <ul class="menu">
                                        <?php $folder_requests = Illuminate\Support\Facades\DB::select('select * from folder_requests where treated != 1 order by created_at desc limit 5'); ?>
                                        
                                         @foreach($folder_requests as $folder_request)
                                         <?php $user = Illuminate\Support\Facades\DB::table('users')->where('email', '=', $folder_request->from)->first();
                                                        
                                                        $temp = array();
                                                        foreach($user as $field => $val ){
                                                            $temp[$field] = $val;
                                                        }  ?>
                                            <li><!-- start notification -->
                                                <a href="viewallrequest">
                                                    <i class="fa fa-user text-red"></i><b>{{$user->first_name}} {{$user->last_name}}</b> | {{$folder_request->folder_name}}
                                                </a>
                                            </li><!-- end notification -->
                                             @endforeach
                                        </ul>
                                       
                                    </li>
                                    
                                    <li class="footer"><a href="viewallrequest">View all</a></li>
                                </ul>
                            </li>
                         @endif

                        <!-- Tasks Menu -->
                        <li class="dropdown tasks-menu">
                            <!-- Menu Toggle Button -->
                            <a href="" id="notif_toggle" class="dropdown-toggle" data-toggle="dropdown" >
                                <i id="folder_notif_icon" class="fa fa-folder-open-o"></i><!-- @cpnwaugha:c-e -->
                                <span id="folder_notif" class="label label-danger"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Folders on Desk</li>
                                <li>
                                    <!-- Inner menu: contains the tasks -->
                                    <ul class="menu">                                        
                                        <?php $usertoemail = Auth::user()->email; $query = "%to $usertoemail%";  $activity = Illuminate\Support\Facades\DB::select('select * from activities where activity like ? order by created_at desc limit 5', [$query]); ?>
                                        
                                        @foreach($activity as $activity_by)
                                            @if($activity_by->activity_by == Auth::user()->email || Auth::user()->username)
                                                <li> 
                                                    <a href="#">                   
                                                        <div class="xs">
                                                            <small><b>{{ str_limit($activity_by->activity, 35) }}</b></small>
                                                            <span><i class="fa fa-clock-o"></i>
                                                                <small>{{ date('F d', strtotime($activity_by->created_at )) }}</small>
                                                            </span>                                                        
                                                        </div>
                                                    </a>
                                                </li>                                                 
                                            @endif
                                        @endforeach
                                                            
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="position: relative; padding-left: 50px;">
                            <!-- The user image in the navbar-->
                            <!--@cpnwaugha: c-e: adding new user image from picture upload-->
                            {{--<img src="{{ Gravatar::get(Auth::user()->email , 'tiny') }}" class="user-image" alt="User Image"/>--}}

                             <img src="{{ asset('/img/profile_picture/photo/'.Auth::user()->avatar) }}" class="user-image" style="width: 32px; height: 32px; position: absolute; top: 10px; left: 10px;border-radius: 50%;" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->username }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <a id="image_view_update" class="users-list-name" href="{{route('user.profile.photo')}}"><img src="{{ asset('/img/profile_picture/photo/'.Auth::user()->avatar) }}" class="img-circle" style="width: 130px; height: 100px; border-radius: 50%; margin-right: 25px;" alt="User Image"/>
                                </a>

                                {{-- @cpnwaugha: c-e: removed <img src="{{ Gravatar::get(Auth::user()->email , 'medium') }}" class="img-circle" alt="User Image" /> --}}

                                {{--<a class="users-list-name" href="">{!! link_to_route('admin.users.show', $user->full_name, [$user->id], []) !!}</a>--}}
                                <p>
                                    {{ Auth::user()->full_name }}
                                    <small>Member since {{ Auth::user()->created_at->format("F, Y") }}</small>
                                </p>
                            </li>

                            @if ( Setting::get('app.extended_user_menu') )
                                <!-- <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li> -->
                                </br>
                                
                            @endif
                            <!-- Menu Footer-->
                            <!-- @cpnwaugha changed button default->color, and flat-raised-->
                            <li class="user-footer">
                                @if ( Setting::get('app.user_profile_link') )
                                    <div class="pull-left">
                                        {!! link_to_route('user.profile', 'Profile', [], ['class' => "btn btn-info btn-raised"]) !!}
                                    </div>
                                @endif
                                <!-- @cpnwaugha: c-e work on this for profile photo updata -->
                                <div class="pull-right">
                                    {!! link_to_route('logout', 'Sign out', [], ['class' => "btn btn-danger btn-raised"]) !!}
                                </div>
                            </li>
                        </ul>
                    </li>
                    @if ( Setting::get('app.right_sidebar') )
                        <!-- Control Sidebar Toggle Button -->
                        {{--  <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>  --}}
                    @endif
                @else
                    <li>{!! link_to_route('login', 'Sign in') !!}</li>
                    @if (Setting::get('app.allow_registration'))
                        <li>{!! link_to_route('register', 'Register') !!}</li>
                    @endif
                @endif
            </ul>
        </div>
    </nav>
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
</header>