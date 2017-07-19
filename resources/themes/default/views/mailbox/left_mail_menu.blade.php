<a href="inbox" class="btn btn-primary btn-block margin-bottom">Back to Inbox</a>
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
        <a href="inbox">
            <i class="fa fa-inbox"></i><span> Inbox</span>
            <span class="pull-right-container">
                <small id="inbox_left" class="label pull-right bg-red"></small>
            </span>                                
        </a>
      </li>
      {{--  <li><a href="sent"><i class="fa fa-envelope-o"></i> Sent</a></li>  --}}
      <li>
        <a href="sent">
            <i class="fa fa-envelope-square"></i><span> Sent</span>
            <span class="pull-right-container">
                <small class="label pull-right bg-green">12</small>
            </span>
        </a>
      </li>
      <li>
        <a href="pages/forms/advanced.html">
            <i class="fa fa-database"></i><span> Draft</span>
            <span class="pull-right-container">
                <small class="label pull-right bg-yellow">16</small>
            </span>
        </a>
      </li>
      {{--  <li><a href="trash"><i class="fa fa-trash-o"></i> Trash</a></li>  --}}
      <li>
        <a href="pages/forms/advanced.html">
            <i class="fa fa-trash-o"></i><span> Trash</span>
            <span class="pull-right-container">
                <small class="label pull-right bg-blue">21</small>
            </span>
        </a>
      </li>
    </ul>
  </div><!-- /.box-body -->

</div><!-- /. box -->
<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Labels</h3>
    <div class='box-tools'>
      <button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
    </div>
  </div><!-- /.box-header -->
  <div class="box-body no-padding">
    <ul class="nav nav-pills nav-stacked">
      <li><a href="dashboard"><i class="fa fa-circle-o text-red"></i> Dashboard</a></li>
      <li><a href="viewall"><i class="fa fa-circle-o text-yellow"></i> Activity Timeline</a></li>
    </ul>
  </div><!-- /.box-body -->
</div><!-- /.box -->