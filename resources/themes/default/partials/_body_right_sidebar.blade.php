<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">

<!-- Make the home nav active if user is not root user, else make layout nav active -->
    @if(Auth::check())
        @if(Auth::user()->isRoot())
            <!-- Create the tabs @cpnwaugha removed active class-->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li class=""><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
            </ul>
        @else
            <!-- Create the tabs @cpnwaugha removed active class-->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
            </ul>
        @endif
    @endif

    <!-- Tab panes -->
    <div class="tab-content">

        <!-- @cpnwaugha: c-e: Make the home tab active if user is not root user, else make layout tab active -->
        @if(Auth::check())
            @if(Auth::user()->isRoot())
                <!-- Home tab content @cpnwaugha removed class="active" -->
                <div class="tab-pane" id="control-sidebar-home-tab">
                    <h3 class="control-sidebar-heading">Recent Activity</h3>
                    <ul class='control-sidebar-menu'>
                        <li>
                            <a href='javascript::;'>
                                <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Shittu's Birthday</h4>
                                    <p>Will be 23 on April 24th</p>
                                </div>
                            </a>
                        </li>
                    </ul><!-- /.control-sidebar-menu -->

                    <h3 class="control-sidebar-heading">Tasks Progress</h3>
                    <ul class='control-sidebar-menu'>
                        <li>
                            <a href='javascript::;'>
                                <h4 class="control-sidebar-subheading">
                                    Custom Template Design
                                    <span class="label label-danger pull-right">70%</span>
                                </h4>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                </div>
                            </a>
                        </li>
                    </ul><!-- /.control-sidebar-menu -->

                    <h3 class="control-sidebar-heading">Timeline: Sent Files</h3>
                    <ul class='control-sidebar-menu'>
                        <li>
                            <a href='javascript::;'>
                                <h4 class="control-sidebar-subheading">
                                    File A to James
                                    <span class="label label-danger pull-right">Date: 25-02-2017</span>
                                </h4>
                                <h4 class="control-sidebar-subheading">
                                    File B to Aminat
                                    <span class="label label-danger pull-right">Date: 27-02-2017</span>
                                </h4>
                                <h4 class="control-sidebar-subheading">
                                    File C to Nnamdi
                                    <span class="label label-danger pull-right">Date: 02-03-2017</span>
                                </h4>
                                <h4 class="control-sidebar-subheading">
                                    File Q to Amin
                                    <span class="label label-danger pull-right">Date: 05-03-2017</span>
                                </h4>
                                <label>Activiness in the system:</label>
                                <div class="progress progress-xxs">                            
                                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                </div>
                            </a>
                        </li>
                    </ul><!-- /.control-sidebar-menu -->

                </div><!-- /.tab-pane -->
            @else
                <!-- Home tab content @cpnwaugha removed class="active" -->
                <div class="tab-pane active" id="control-sidebar-home-tab">
                    <h3 class="control-sidebar-heading">Recent Activity</h3>
                    <ul class='control-sidebar-menu'>
                        <li>
                            <a href='javascript::;'>
                                <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Shittu's Birthday</h4>
                                    <p>Will be 23 on April 24th</p>
                                </div>
                            </a>
                        </li>
                    </ul><!-- /.control-sidebar-menu -->

                    <h3 class="control-sidebar-heading">Tasks Progress</h3>
                    <ul class='control-sidebar-menu'>
                        <li>
                            <a href='javascript::;'>
                                <h4 class="control-sidebar-subheading">
                                    Custom Template Design
                                    <span class="label label-danger pull-right">70%</span>
                                </h4>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                </div>
                            </a>
                        </li>
                    </ul><!-- /.control-sidebar-menu -->

                    <h3 class="control-sidebar-heading">Timeline: Sent Files</h3>
                    <ul class='control-sidebar-menu'>
                        <li>
                            <a href='javascript::;'>
                                <h4 class="control-sidebar-subheading">
                                    File A to James
                                    <span class="label label-danger pull-right">Date: 25-02-2017</span>
                                </h4>
                                <h4 class="control-sidebar-subheading">
                                    File B to Aminat
                                    <span class="label label-danger pull-right">Date: 27-02-2017</span>
                                </h4>
                                <h4 class="control-sidebar-subheading">
                                    File C to Nnamdi
                                    <span class="label label-danger pull-right">Date: 02-03-2017</span>
                                </h4>
                                <h4 class="control-sidebar-subheading">
                                    File Q to Amin
                                    <span class="label label-danger pull-right">Date: 05-03-2017</span>
                                </h4>
                                <label>Activiness in the system:</label>
                                <div class="progress progress-xxs">                            
                                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                </div>
                            </a>
                        </li>
                    </ul><!-- /.control-sidebar-menu -->

                </div><!-- /.tab-pane -->
            @endif
        @endif
        
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>
                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked />
                    </label>
                    <p>
                        Some information about this general settings option
                    </p>
                </div><!-- /.form-group -->
            </form>
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>
