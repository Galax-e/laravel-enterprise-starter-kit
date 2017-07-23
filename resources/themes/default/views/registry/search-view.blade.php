{{-- @if((sizeof($files) > 0) || (sizeof($directories) > 0)) come back to link back to grid view --}}
@if( $count > 0)

    <div class="row">
        @foreach($folders as $folder)
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 img-row">

                <div class="square clickable folder-item" id="searchView" name="searchView" data-id="{{ $folder->path }}">
                    {{--  <i class="fa fa-folder fa-5x"></i>  --}}
                    <img src="{{ asset('/img/folder.png') }}" width="150">
                </div>

                {{--  <div><a href="{{ $folder->path }}"><img src="{{ asset('/img/folder.png') }}" width="150">
                </a></div>  --}}
                

                <div class="caption text-center">
                    <div class="btn-group">
                        <button type="button" id='folder_no' data-id="{{ $folder->folder_no }}" class="item_name btn btn-default btn-xs -item">
                        {{ $folder->folder_no }}
                        </button>
                        <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:rename('{{ $folder->folder_no }}')"><i class="fa fa-share-square-o fa-fw"></i> Share</a></li>
                            <li><a href="javascript:history('{{ $folder->folder_no }}')"><i class="fa fa-arrows fa-fw"></i> History</a></li>
                            <li><a href="javascript:move('{{ $folder->folder_no }}')"><i class="fa fa-external-link fa-fw"></i> Move</a></li>
                            <li><a href="javascript:trash('{{ $folder->folder_no }}')"><i class="fa fa-trash fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-delete') }}</a></li>
                        </ul>
                    </div>
                </div>
                </div>
        @endforeach
    </div>

@else
<p>{{ Lang::get('laravel-filemanager::lfm.message-empty') }}</p>
@endif
