<div class="wrapper">

    <!-- Header -->
    @include('partials._body_header')
    

    <!-- Sidebar -->
    <div id="navi">
        @include('partials._body_left_sidebar')
    </div>
    

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style='margin-top: 50px;'>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $page_title or "Page Title" }}
                <small>{{ $page_description or "Page description" }}</small>
            </h1>
            {{--  @if(\Auth::user()->isRoot())
                {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false)  !!}
            @endif  --}}
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="box-body">
                @include('flash::message')
                @include('partials._errors')
            </div>

            <!-- Your Page Content Here -->
            @yield('content')

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Body Footer -->
    @include('partials._body_footer')

    @if ( Setting::get('app.right_sidebar') )
        <!-- Body right sidebar -->
        @include('partials._body_right_sidebar')
    @endif

{{-- custom scripts when user is authenticaated goes here. --}}
@if(Auth::check())
    @include('partials._body_bottom_custom_file_ctrl_js')
@endif

</div><!-- ./wrapper -->

