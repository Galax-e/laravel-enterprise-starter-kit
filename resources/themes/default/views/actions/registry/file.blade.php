@extends('layouts.master')

@section('head_extra')
    <!-- jVectorMap 1.2.2 -->
    <link href="{{ asset("/bower_components/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Add Document to your folder  
            <small>Document</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <!-- form start -->
                <form action="store" method="post" enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Folder Name</label>
                      <select type="text" name="folder_id" value="">
                      @foreach ($folders as $user)
                        <option> {{ $user->id }} </option>
                      @endforeach
                      </select>
                    </div>
			
                    <div class="form-group">
                      <label for="exampleInputPassword1">File Name</label>
                      <input type="text" class="form-control" name="name" placeholder="File Name">
                    </div>
                    <input type="hidden" name="file_by" value="{{ Auth::user()->email }}">
					
                    <div class="form-group">
                      <label for="exampleInputEmail1">image</label>
                      <input type="file" name="image" value="">
                    </div>
		
					          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>

                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

            </div><!--/.col (right) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection
