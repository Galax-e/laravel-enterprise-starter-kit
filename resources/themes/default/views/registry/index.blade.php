@extends('layouts.registry_app')

@section('head_extra')   
    @include('partials._head_extra_jstree_css') 
    @include('partials._head_extra_select2_css')
@endsection

@section('content')
<!-- think of removing the wrapper id and container fluid class-->

  <style>

    .filemanager{
      background-color: black;
    }
    .filemanager .search {
      position: absolute;
      padding-right: 30px;
      cursor: pointer;
      right: 0;
      font-size: 17px;
      color: #ffffff;
      display: block;
      width: 40px;
      height: 40px;
    }

    .filemanager .search:before {
      content: '';
      position: absolute;
      margin-top:12px;
      width: 12px;
      height: 13px;
      border-radius: 80%;
      border: 2px solid black;
      right: 8px;
    }

    .filemanager .search:after {
      content: '';
      width: 3px;
      height: 10px;
      background-color: black;
      border-radius: 2px;
      position: absolute;
      top: 23px;
      right: 6px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
    }

    .filemanager .search input[type=search] {
      border-radius: 2px;
      color: #4D535E;
      background-color: #FFF;
      width: 250px;
      height: 44px;
      margin-left: -215px;
      padding-left: 20px;
      text-decoration-color: #4d535e;
      font-size: 16px;
      font-weight: 400;
      line-height: 20px;
      display: none;
      outline: none;
      border: none;
      padding-right: 10px;
      -webkit-appearance: none;
    }

    .list-group-item ul{
      margin-top: 10px;
      margin-right: -15px;
      margin-bottom: -10px;
    }
    .list-group-item li{
      padding: 10px 15px 10px 3em;
      border-top: 1px solid #ddd;
    }
    .list-group-item li:before{
      content: '';
      display: block;
      position: absolute;
      left: 0;
      width: 100%;
      height: 1px;
      margin-top: -11px;
      background: #ddd;
    }
    .displayBtn{
        display: block;
        margin-top: -20px;
    }
    .removeBtn{
      display: none;
    }
  
  </style>
  <div class="container-fluid" id="wrapper">
    <div class="row">
      <div class="col-md-3 col-sm-3 hidden-xs">
        <div id="tree" class="list-group-item"></div>
        
        <!-- Activities -->
        <div id="activity-timeline" class="box box-primary active tab-pane" style="margin-top: 10px;">
          <div class="box-header">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">File Tracking</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div><!-- /.box-header -->

          <div class="box-body nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Forwarded</a></li>
              <li><a href="#shared" data-toggle="tab">Shared</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <ul class="todo-list">
                
                
                @foreach($activities as $activity)                  
                    
                  <?php                     
                    $folder = Illuminate\Support\Facades\DB::select('select forwarded_by, folder_to from folders where folder_no=?', [$activity->folder_id] );  
                    $folder_to = null;
                    $forwarded_by = null;
                    foreach($folder as $fold ){
                        $folder_to = ((array)$fold)['folder_to'];
                        $forwarded_by = ((array)$fold)['forwarded_by'];
                    }                         
                  ?>                 
                  @if($forwarded_by)
                  <li>
                    <?php  
                      $temp_user = Illuminate\Support\Facades\DB::select('select first_name, last_name, avatar from users where email=?', [$forwarded_by] ); 
                      foreach($temp_user as $user ){
                          $user_avatar = ((array)$user)['avatar'];
                          $user_name = ((array)$user)['first_name'].', '.((array)$user)['last_name'];;
                      }
                      $temp_user_to = Illuminate\Support\Facades\DB::select('select first_name, last_name from users where email=?', [$folder_to] );                      
                      foreach($temp_user_to as $user ){                          
                          $user_to_name = ((array)$user)['first_name'].', '.((array)$user)['last_name'];;
                      }
                    ?>                    
                    <div>
                      <div class="pull-left" style="margin-right: 5px;">
                        <img src="img/profile_picture/photo/{{ $user_avatar }}" class="offline" style="width: 42px; height: 42px; top: 10px; left: 10px; border-radius: 50%;" alt="User Image"/>
                      </div>
                      <small>{{ $user_name }}  &nbsp; &nbsp;<img src="{{asset("/img/smaller.png") }}" 
                        class="offline" style="width: 20px;" alt="User Image"/>  
                        &nbsp; &nbsp; {{$user_to_name}}
                      </small><br/>
                      <small class="pull-left">
                        <b>{{ $activity->folder_id }}</b>
                      </small>
                      <small class="label label-default pull-right"><i class="fa fa-clock-o"></i>
                        <b>{{ date('F d, Y', strtotime($activity->created_at )) }}</b>
                      </small>
                    </div>
                    </li>
                  @endif            
                  {{--  @endif  --}}
                @endforeach
                </ul>
              </div><!-- /.box-body active tab-pane -->
              <div class="tab-pane" id="shared">
                <ul class="todo-list">                
                
                @foreach($reg_activities as $activity)                
                    
                  <?php 
                    
                    $folder = Illuminate\Support\Facades\DB::select('select folder_by, shared_by, folder_to from folders where folder_no=?', [$activity->folder_id] );  
                    $folder_to = null;
                    $shared_by = null;
                    $folder_by = null;
                    foreach($folder as $fold ){
                        $folder_to = ((array)$fold)['folder_to'];
                        $shared_by = ((array)$fold)['shared_by'];
                        $folder_by = ((array)$fold)['folder_by'];
                    }                         
                  ?>
                  

                  @if($shared_by)
                    <li>
                    <?php  
                      $temp_user = Illuminate\Support\Facades\DB::select('select first_name, last_name, avatar from users where email=?', [$shared_by] );  
                      foreach($temp_user as $user ){
                          $user_avatar = ((array)$user)['avatar'];
                          $user_name = ((array)$user)['first_name'].', '.((array)$user)['last_name'];
                      }
                      $temp_user_to = Illuminate\Support\Facades\DB::select('select first_name, last_name from users where email=?', [$folder_to] );                      
                      foreach($temp_user_to as $user ){                          
                          $user_to_name = ((array)$user)['first_name'].', '.((array)$user)['last_name'];;
                      }
                    ?>
                    <div>
                      <div class="pull-left" style="margin-right: 5px;">
                        <img src="img/profile_picture/photo/{{ $user_avatar }}" class="offline" style="width: 42px; height: 42px; top: 10px; left: 10px; border-radius: 50%;" alt="User Image"/>
                      </div>
                      <small>{{ $user_name }}  &nbsp; &nbsp;<img src="{{asset("/img/smaller.png") }}" 
                        class="offline" style="width: 20px;" alt="User Image"/>  
                        &nbsp; &nbsp; {{$user_to_name}}
                      </small>
                      <small class="pull-left">
                        <b>{{ $activity->folder_id }}</b>
                      </small>
                      <small class="label label-default pull-right"><i class="fa fa-clock-o"></i>
                        <b>{{ date('F d, Y', strtotime($activity->created_at )) }}</b>
                      </small>
                    </div>
                  </li>
                  @endif
                @endforeach
                </ul>
              </div>
            </div> <!-- ./tab content -->
          </div> <!-- ./box-body nav-tab custom -->
          <div class="box-footer text-center">
            <a href="{{route('registry_viewall')}}" class="uppercase">View All</a>
          </div><!-- /.box-footer -->
        </div><!-- /.box -->
      </div> <!-- ./col-md-3 -->

      <div class="col-md-9 col-sm-9 col-xs-12" id="main">
        <nav class="navbar navbar-default" id="nav">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-buttons">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand clickable hide" id="to-previous">
              <i class="fa fa-arrow-left"></i>
              <span class="hidden-xs">{{ trans('registry/lfm.nav-back') }}</span>
            </a>
            <a class="navbar-brand visible-xs" href="#">{{ trans('registry/lfm.title-panel') }}</a>
          </div>
          <div class="collapse navbar-collapse" id="nav-buttons">
            <ul class="nav navbar-nav navbar-right">

              {{-- <li>
                <div class="filemanager" title="search a folder">
                <i id="search_icon" class="fa fa-search fa-fw" data-toggle="search" data-target="#search" aria-hidden="true"></i>
                  <span id="search" class="search">
                    <input id="search_input" type="search" placeholder="Search..."/>
                  </span>
                </div>
              </li> --}}

              <li style="display: inline-flex;margin-top: 8px">
                <input id="keyword" name="keyword" class="form-control" onkeypress="searchFieldKeyPress(event)"/>
                <button id="searchBtn" style="" class="btn btn-default" onclick="loadSearchItems()">
                  <span class="fa fa-search fa-fw"></span>
                </button>
              </li>
              <li>
                <a class="clickable" id="thumbnail-display">
                  <i class="fa fa-th-large"></i>
                  <span>{{ trans('registry/lfm.nav-thumbnails') }}</span>
                </a>
              </li>
              <li>
                <a class="clickable" id="list-display">
                  <i class="fa fa-list"></i>
                  <span>{{ trans('registry/lfm.nav-list') }}</span>
                </a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  {{ trans('registry/lfm.nav-sort') }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="#" id="list-sort-alphabetic">
                      <i class="fa fa-sort-alpha-asc"></i> {{ trans('registry/lfm.nav-sort-alphabetic') }}
                    </a>
                  </li>
                  <li>
                    <a href="#" id="list-sort-time">
                      <i class="fa fa-sort-amount-asc"></i> {{ trans('registry/lfm.nav-sort-time') }}
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <div class="visible-xs" id="current_dir" style="padding: 5px 15px;background-color: #f8f8f8;color: #5e5e5e;">
        </div>
        <div id="alerts"></div>
        <div id="content"></div>
      </div><!-- /col. -->

      <ul id="fab">
        <li>
          <a href="#"></a>
          <ul id="mat_design_btn" class="hide">                
            
              <li id="add-folder-li">
                <a href="#" id="add-folder" data-mfb-label="{{ trans('laravel-filemanager::lfm.nav-new') }}">
                  <i id="add-folder-i" class="fa fa-folder"></i>
                </a>
              </li>            
              <li id="upload-li">
                <a href="#" id="upload" data-mfb-label="{{ trans('laravel-filemanager::lfm.nav-upload') }}">
                  <i id="upload-i" class="fa fa-upload"></i>
                </a>
              </li>           
          </ul>
        </li>
      </ul>
    </div> <!-- /row -->
  </div><!-- /container wrapper -->

    <!-- upload modal -->
  <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aia-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">{{ trans('registry/lfm.title-upload') }}</h4>
        </div>
        <div class="modal-body">
          <form action="newdocument" role='form' id='uploadForm' name='uploadForm' method='post' enctype='multipart/form-data'>
            <div class="form-group" id="attachment">
              <label for='upload' class='control-label'>{{ trans('registry/lfm.message-choose') }}</label>
              <div class="controls">
                <div class="input-group" style="width: 100%">
                  <input type="file" id="upload" name="upload[]" multiple="multiple">
                </div>
              </div>
            </div>
            <input type="hidden" name="comment_by" value="registry@hallowgate.com">
            <input type="hidden" name="activity" value="{{Auth::user()->full_name}} added a new document">
            <input type='hidden' name='working_dir' id='working_dir'>
            <input type='hidden' name='type' id='type' value='{{ request("type") }}'>
            <input type='hidden' name='_token' value='{{csrf_token()}}'>
          </form>
        </div>
        <div class="modal-footer">        
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('registry/lfm.btn-close') }}</button>
          <button type="button" class="btn btn-primary" id="upload-btn">{{ trans('registry/lfm.btn-upload') }}</button>
        </div>
      </div>
    </div>
  </div>

  {{-- add folder modal --}}
  <div class="modal fade" id="add-folderModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">        
      <div class="box box-info">
        <div class="box-header">
          <i class="fa fa-folder"></i>
          <h3 class="box-title">New Folder</h3>
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button class="btn btn-info btn-sm" data-dismiss="modal" title="Remove"><i class="fa fa-times"></i></button>
          </div><!-- /. tools -->
        </div> 
        <div class="box-body">       
        <form action="{{route('newfolder')}}" role='form' id='add-folderForm' role="form" name='uploadForm' method='post' enctype='multipart/form-data'>
            {{ csrf_field() }}
            <input type="hidden" name="activity" value="new folder created by system">
            <input type='hidden' name='working_dir'>
            <input type='hidden' name='folder_by' id='folder_by' value='{{ Auth::user()->email }}'>
            
              <div class="form-group">
                <input type="text" class="form-control" id="folder_no" name="folder_no" placeholder="File No"/>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="fold_name" name="fold_name" placeholder="File name/ Subject"/>
              </div>               
              <div>
                <label>Enter Description</label>
                <textarea class="form-control" id="add_folder_description" name="add_folder_description" rows="3" style="">
                </textarea>
              </div>  
                           
              <div class="form-group">                
                <label>Ministry</label>
                <select id="agency_dept" class="form-control" name="agency_dept">
                  <option value='agric'>Agric</option>
                  <option value='education'>Education</option>
                  <option value='health'>Health</option>
                  <option value='rural'>Rural</option>
                  <option value='works'>Works</option>
                  <option value='budget'>Budget</option>
                  <option value='environment'>Environment</option>
                  <option value='jsutice'>Justice</option>
                  <option value='water'>Water</option>
                  <option value='youth'>Youth</option>
                  <option value='commerce'>Commerce</option>
                  <option value='finance'>Finance</option>
                  <option value='localgov'>Local Gov</option>
                  <option value='women'>Women</option>
                  <option value='hos'>HOS</option>
                  <option value='bpsr'>BPSR</option>
                  <option value='gh'>GH</option>
                  <option value='csc' selected="true">CSC</option>
                  <option value='asc'>ASC</option>
                </select>
              </div>

              {{--  <div class="form-group">                
                <label>Department</label>
                <select id="dept" class="form-control" name="dept">
                  <option value='secretreg'>Secret Registry</option>
                  <option value='openreg'>Open Registry</option>
                  <option value='finance'>Finance</option>
                  <option value='hr'>Human Resources</option>
                  <option value='gsl'>General Services and Logistics</option>
                  <option value='adminsupply'>Admin and Supply</option>
                  <option value='procurement'>Procurement</option>
                  <option value='permsec'>Permanent Secretary and GOC</option>
                  <option value='ict' selected="true">ICT and Communications</option>
                  <option value='legal'>Legal</option>
                </select>
              </div>  --}}

              <div class="form-group">
              <label>Clearance Level</label>
                <select id="clearance_level" class="form-control" name="clearance_level">
                  <option>5</option>
                  <option>6</option>
                  <option>7</option>
                  <option selected="true">8</option>
                  <option>9</option>
                  <option>10</option>
                  <option>11</option>
                  <option>12</option>
                  <option>13</option>
                  <option>14</option>
                  <option>15</option>
                  <option>16</option>
                  <option>17</option>
                </select>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="category" name="category" placeholder="Tag"/>
              </div>
            </form>
          </div><!-- box-body -->          
          <div class="box-footer clearfix">
            <button type="button" style="margin: 5px;" class="btn btn-primary pull-right" id="add-folder-btn">{{ trans('registry/lfm.btn-folder') }} <i class="fa fa-arrow-circle-right"></i></button>
            <button type="button" style="margin: 5px;" class="btn btn-warning pull-right" data-dismiss="modal">{{ trans('registry/lfm.btn-close') }}</button>
          </div>     
        </div>
      </div>
    </div>
  </div>

  {{-- select script for forwarding --}}
  <script>

    $( function() {

    })
  </script>

  {{-- eoluwafemi share --}}
  <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aia-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">{{ trans('registry/lfm.file-share') }}</h4>
          </div>
          <div class="modal-body">
            <div id="current_holder"></div>
            <form action="{{route('share')}}" role='form' id='shareForm' name='shareForm' method='post'>
              
              <input type='hidden' name='folder_no' id='share_folder_no'>
              <input type='hidden' name='working_dir'>
              <input type="hidden" name="activity" value="">
              <input type='hidden' name='_token' value='{{csrf_token()}}'>

              <div style="margin-left:5px"><label><b>Enter Recipient Email:</b></label></div>
							<div class="form-group">														              
								<div class="input-group">					 
									<div class="pmd-textfield pmd-textfield-floating-label img-responsive">       
										<select id="share-input" class="form-control select-with-search select2" name="share-input" placeholder="Recipient Email..."></select>
                  </div> 									
								</div>                   
							</div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('registry/lfm.btn-close') }}</button>
                <button type="button" class="btn btn-primary" id="share-btn">{{ trans('registry/lfm.btn-share') }} <i class="fa fa-arrow-circle-right"></i></button>
              </div>			
            </form>
          </div>          
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aia-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">History</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <ul id="showactivities" class="todo-list">
                {{--  Folder hostory comes here. --}}
              </ul>
            </div><!-- /.box-body -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('registry/lfm.btn-close') }}</button>
          </div>
        </div>
      </div>
    </div>

    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>--}}
    
    <script src="{{ asset('bower_components/admin-lte/plugins/bootbox/bootbox.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/1.11.2/jquery-ui.min.js') }}"></script>    
    <script src="{{ asset('vendor/laravel-filemanager/js/cropper.min.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/jquery.form.min.js') }}"></script>
    <script>
      var route_prefix = "{{ url('/') }}";
      var lfm_route = "{{ url(config('lfm.prefix')) }}";
      var lang = {!! json_encode(trans('registry/lfm')) !!};
    </script>
    {{-- <script>{!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/script.js')) !!}</script> --}}
    {{-- <script>{!! \File::get(public_path('vendor/laravel-filemanager/js/script.js')) !!}</script> --}}
    {{-- Use the line below instead of the above if you need to cache the script. --}}
    
    <script>
      $.fn.fab = function () {
        var menu = this;
        menu.addClass('mfb-component--br mfb-zoomin').attr('data-mfb-toggle', 'hover');
        var wrapper = menu.children('li');
        wrapper.addClass('mfb-component__wrap');
        var parent_button = wrapper.children('a');
        parent_button.addClass('mfb-component__button--main')
          .append($('<i>').addClass('mfb-component__main-icon--resting fa fa-plus'))
          .append($('<i>').addClass('mfb-component__main-icon--active fa fa-times'));
        var children_list = wrapper.children('ul');
        children_list.find('a').addClass('mfb-component__button--child').addClass('hide');
        children_list.find('i').addClass('mfb-component__child-icon').addClass('hide');
        children_list.addClass('mfb-component__list').removeClass('hide');
      };
      $('#fab').fab({
        buttons: [
          {
            icon: 'fa fa-folder',
            label: "{{ trans('registry/lfm.nav-new') }}",
            attrs: {id: 'add-folder'}
          },
          {
            icon: 'fa fa-upload',
            label: "{{ trans('registry/lfm.nav-upload') }}",
            attrs: {id: 'upload'}
          }
        ]
      });
    </script>
    <script src="{{ asset('vendor/laravel-filemanager/js/script.js') }}"></script>

    {{-- Search script --}}
    @include('views.registry.folder_search_js')

@endsection