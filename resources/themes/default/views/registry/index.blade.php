@extends('layouts.registry_app')

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
  
  </style>
  <div class="container-fluid" id="wrapper">
    <div class="row">
      <div class="col-sm-2 hidden-xs">
        <div id="tree"></div>
      </div>

      <div class="col-sm-10 col-xs-12" id="main">
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
        <div class="visible-xs" id="current_dir" style="padding: 5px 15px;background-color: #f8f8f8;color: #5e5e5e;"></div>

        <div id="alerts"></div>

        <div id="content"></div>
      </div>

      <ul id="fab">
        <li>
          <a href="#"></a>
          <ul class="hide">
            <li>
              <a href="#" id="add-folder" data-mfb-label="{{ trans('registry/lfm.nav-new') }}">
                <i class="fa fa-folder"></i>
              </a>
            </li>
            <li>
              <a href="#" id="upload" data-mfb-label="{{ trans('registry/lfm.nav-upload') }}">
                <i class="fa fa-upload"></i>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    </div>

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
              <input type="hidden" name="comment_by" value="registry@kdsg.gov.ng">
			  <input type="hidden" name="activity" value="registry@kdsg.gov.ng Added new document to this file">
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
    {{-- eoluwafemi edit --}}
     <!-- Request file modal-->
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
        <form action="newfolder" role='form' id='add-folderForm' name='uploadForm' method='post' enctype='multipart/form-data'>
            {{ csrf_field() }}
            <input type='hidden' name='folder_by' id='folder_by' value='{{ Auth::user()->email }}'>
            <div class="box-body">
              <div class="form-group">
                <input type="text" class="form-control" id="folder_no" name="folder_no" placeholder="File No"/>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="fold_name" name="fold_name" placeholder="File name/ Subject"/>
              </div>               <div>
                <textarea class="textarea" name="add_folder_description" id="add_folder_description" placeholder="Full Description" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd

; padding: 10px;"></textarea>
              </div>               <div class="form-group">
                <input type="text" class="form-control" id="agency_dept" name="agency_dept" placeholder="Agency/ Department"/>
              </div>               <div class="form-group">
                <select id="clearance_level" class="form-control" name="clearance_level">
                     <option>Clearance Level</option>
                     <option>1</option>
                     <option>2</option>
                     <option>3</option>
                     <option>4</option>
                     <option>5</option>
                     <option>6</option>
                     <option>7</option>
                     <option>8</option>
                   </select>
              </div>
               <div class="form-group">
                <input type="text" class="form-control" id="category" name="category" placeholder="Category"/>
              </div>
          </div>
          <div class="box-footer clearfix">
            <button class="pull-right btn btn-default" name="post" id="post">Create <i class="fa fa-arrow-circle-right"></i></button>
          </div>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('registry/lfm.btn-close') }}</button>
           <button type="button" class="btn btn-primary" id="add-folder-btn">{{ trans('registry/lfm.btn-folder') }}</button>      
        </div>
    </div>
  </div>
</div>

	{{-- eoluwafemi rename --}}
	<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aia-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">{{ trans('registry/lfm.file-share') }}</h4>
          </div>
          <div class="modal-body">
            <form action="/share/8" role='form' id='shareForm' name='shareForm' method='post'>
              <div class="form-group" id="attachment">
                <label for='upload' class='control-label'>{{ trans('registry/lfm.file-to') }}</label>
                <div class="controls">
                  <div class="input-group" style="width: 100%">
                    <input type="text" id="share-input" name="share-input">
                  </div>
                </div>
              </div> 
			  <input type='hidden' name='fold_name' id='item_name'>
			  <input type="hidden" name="comment_by" value="registry@kdsg.gov.ng">
			 <input type="hidden" name="activity" value="registry@kdsg.gov.ng Forward this file to ">
              <input type='hidden' name='_token' value='{{csrf_token()}}'>
            </form>
          </div>
          <div class="modal-footer">
		    
			 <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('registry/lfm.btn-close') }}</button>
            <button type="button" class="btn btn-primary" id="share-btn">{{ trans('registry/lfm.btn-forward') }}</button>
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
              <ul class="todo-list">
                @foreach($activity as $folder_id)
                     @if($folder_id->folder_id == '/1/KDSG-HHH-1498582776631')
                    <li>                     
                      <small>{{ $folder_id->activity }} 
                      <i class="fa fa-clock-o"></i>
					          <b>{{ $folder_id->created_at }}</b></small>
                      </li>             
                        @endif
			          	@endforeach
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
    <script src="{{ asset('vendor/laravel-filemanager/js/script.js') }}"></script>
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
        children_list.find('a').addClass('mfb-component__button--child');
        children_list.find('i').addClass('mfb-component__child-icon');
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

    {{-- Search script --}}
    @include('views.registry.folder_search_js')

@endsection
