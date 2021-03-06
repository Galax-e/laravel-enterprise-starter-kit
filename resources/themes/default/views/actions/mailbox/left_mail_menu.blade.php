<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Memo</h3>
    <div class='box-tools'>
      <button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
    </div>
  </div>
  <div class="box-body no-padding">
    <ul class="nav nav-pills nav-stacked">
      {{--  <li id="inbox_left_li"><a href="inbox"><i class="fa fa-inbox"></i> Inbox <span id="inbox_left" class="label label-primary pull-right"></span></a></li>  --}}
      <li>
        <a href="{{url('compose')}}">
            <i class="fa fa-edit"></i><span> Compose</span>
        </a>
      </li>
      <li id="inbox_left_li">
        <a href="{{url('inbox')}}">
            <i class="fa fa-inbox"></i><span> Incoming</span>
            <span class="pull-right-container">
                <small id="inbox_left" class="label pull-right bg-red"></small>
            </span>                                
        </a>
      </li>
      {{--  <li><a href="sent"><i class="fa fa-envelope-o"></i> Sent</a></li>  --}}
      <li>
        <a href="{{url('sent')}}">
            <i class="fa fa-envelope-square"></i><span> Outgoing</span>
            <span class="pull-right-container">
                <small id='sent_left' class="label pull-right"></small>
            </span>
        </a>
      </li>
      {{--  <li>
        <a href="{{url('draft')}}">
            <i class="fa fa-database"></i><span> Draft</span>
            <span class="pull-right-container">
                <small class="label pull-right bg-yellow">16</small>
            </span>
        </a>
      </li>  --}}
      {{--  <li><a href="trash"><i class="fa fa-trash-o"></i> Trash</a></li>  --}}
      {{--  <li>
        <a href="{{url('trash')}}">
            <i class="fa fa-trash-o"></i><span> Trash</span>
            <span class="pull-right-container">
                <small class="label pull-right bg-blue">21</small>
            </span>
        </a>
      </li>  --}}
    </ul>
  </div><!-- /.box-body -->

</div><!-- /. box -->
<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Actions</h3>
    <div class='box-tools'>
      <button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
    </div>
  </div><!-- /.box-header -->
  <div class="box-body no-padding">
    <ul class="nav nav-pills nav-stacked">
      <li><a href="{{url('dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
      <li><a href="{{url('viewall')}}"><i class="fa fa-exchange"></i> Activity Timeline</a></li>
    </ul>
  </div><!-- /.box-body -->
</div><!-- /.box -->