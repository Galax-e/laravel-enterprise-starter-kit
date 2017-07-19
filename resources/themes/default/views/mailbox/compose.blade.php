@extends('layouts.master')

@section('head_extra')
    <!-- jVectorMap 1.2.2 -->


    <link href="{{ asset("/bower_components/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <script>
        $( function() {
          var availableTags = [
            @foreach($users as $user)   
            "{{ $user->first_name}}, {{$user->last_name}}",
            @endforeach
            
            ""
           ];
           // availableTags.splice(0,0,' ');
          $(".select2").select2({
            data: availableTags,
            tags:false,
            minimumResultsForSearch: Infinity,
          });
        });
    </script>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          @include('views.mailbox.left_mail_menu')
        </div><!-- /.col -->
        
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Compose New Message</h3>
            </div><!-- /.box-header -->
			<form action="store_memo" method="post" enctype="multipart/form-data">
            <div class="box-body">
			<input type="hidden" name="email_name" value="{{ Auth::user()->email }} {{ Auth::user()->last_name }}">
			<input type="hidden" name="emailfrom" value="{{ Auth::user()->email }}">

            <div class="form-group"> 
                <label>To:</label>      
              <select id="forward_to_user" class="form-control select2" name="emailto[]" multiple="multiple" placeholder="Recipient Email..."></select>
            </div>

              <!--<div class="form-group">
                <input class="form-control" name="emailto" placeholder="To:"/>
              </div>-->
              <div class="form-group">
                <input class="form-control" name="subject" placeholder="Subject:"/>
              </div>
              <div class="form-group">
                <textarea id="compose-textarea" class="form-control" name="message" placeholder="Message" style="height: 300px">
                  
                </textarea>
              </div>
			  <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div><!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <button type="submit" id="" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
              	</form>
                <center>
                  <div class="form-group">
                    {!! Form::open(array('url'=>'upload/uploadFiles','method'=>'POST', 'files'=>true)) !!}
                    {!! Form::file('images[]', array('multiple'=>true)) !!}
                      <p>{!!$errors->first('images')!!}</p>
                      @if(Session::has('error'))
                        <p>{!! Session::get('error') !!}</p>
                      @endif
                    {!! Form::submit('Attach File', array('class'=>'btn btn-primary')) !!}
                    {!! Form::close() !!}
                  </div>
                </center>
            </div><!-- /.box-footer -->
		
          </div><!-- /. box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->

    <script src="{{ URL::asset('bower_components/admin-lte/plugins/ckeditor/ckeditor.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ URL::asset('bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script>
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('compose-textarea')
            //bootstrap WYSIHTML5 - text editor
            $('.textarea').wysihtml5()
        })
    </script>
@endsection