<style>
    .sidebar-menu li > a .fa-angle-left{
        margin-right: 17px;
        right: 5px;
    }
    .sidebar-menu li.active>a .fa-angle-left{
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform:rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }
    .main-sidebar {
        position:fixed;
        top:0px;
    }
</style>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            @if (Auth::check())
                <div class="pull-left image">
                    {{-- <img src="{{ Gravatar::get(Auth::user()->email , 'small') }}" class="img-circle" alt="User Image" /> --}}
                    <img src="{{ asset('/img/profile_picture/photo/'.Auth::user()->avatar) }}" class="user-image" style="width: 62px; height: 52px; top: 10px; left: 10px; border-radius: 50%;" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->full_name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            @endif
        </div>

        @if ( Setting::get('app.search_box') )
            <!-- search form (Optional) -->
            <form action="searchactivity" method="post" class="sidebar-form">
            {{ csrf_field() }}
                <div class="input-group">
                     <input type="text" name="search" class="form-control input-sm" placeholder="Search..."/>
                  <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span>
                </div>
            </form>
             
            <!-- /.search form -->
        @endif

        {!! MenuBuilder::renderMenu('home')  !!}

        @if (Auth::check())
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="treeview menu-open">
                    <a href="#">
                        <i class="fa fa-tag"></i> <span>Actions</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/viewall') }}"><i class="fa fa-exchange"></i> My Activities</a></li>
                        <li><a href="{{ url('/viewall') }}"><i class="fa fa-exchange"></i> Position Activities</a></li>
                        <li>
                            <a href="{{url('inbox')}}">
                                <i class="fa fa-envelope-o"></i><span> eDispatch</span>
                                <span class="pull-right-container pull-right">
                                    <small id="inbox_on_mailbox" class="label bg-red"></small>
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#" data-toggle="modal" data-target="#createPinModal">
                               <i class="fa fa-key"></i> Change Pin
                            </a>
                        </li>
                        <li class=""><a href="#" data-toggle="modal" data-target="#requestFileModal"><i class="fa fa-file-o"></i> Request File</a></li>
                    </ul>
                </li>
                
                @if(Auth::user()->roles->count() > 1)
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-files-o"></i>
                            <span>Registry</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                <span class="label label-primary pull-right folder_req_notif"></span>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ url('/viewallrequest') }}">
                                    <i class="fa fa-files-o"></i><span> Folder Requests</span>
                                    <span class="pull-right-container">
                                        <small class="label pull-right bg-blue folder_req_notif"></small>
                                    </span>
                                </a>
                            </li>
                            <li><a href="{{ url('registry') }}"><i class="fa fa-folder"></i> File Manager</a></li>
                            <li><a href="pages/layout/fixed.html"><i class="fa fa-share-square-o"></i> Shared</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        @endif

        {!! MenuBuilder::renderMenu('admin', true)  !!}
    </section>
    <!-- /.sidebar -->
</aside>
