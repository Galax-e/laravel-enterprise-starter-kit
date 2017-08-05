@extends('layouts.master')

@section('head_extra')
    <!-- jVectorMap 1.2.2 -->
    {{--  <link href="{{ asset("/bower_components/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css") }}" rel="stylesheet" type="text/css" />  
     --}}
   
    @include('partials._head_extra_jstree_css') 
    @include('partials._head_extra_select2_css')
@endsection

@section('content')

  <style type="text/css">
    #read-time{
      
    }
    .box-footer{
      
    }
	.item{margin-top: 0.1em !important; margin-bottom: 0.1em !important;}
	.message{font-family: "Times New Roman", Times, serif; font-size: 15px;}
    .mailbox-attachment-icon{
      width:200px !important;
      height:105px !important;
     /* background-color: #efe;*/
    }
    .mailbox-attachment-info{
      width: 200px !important;
      height: 70px;
    }
    #activity-timeline{
      margin-top: -15px !important;
    }
  </style>
  
  <script>

 </script>

  <style type="text/css">
    .column{margin-top: -10px; float: right; }

	@media screen and (min-width: 991px) {
		.left-hand-activity {
			position:fixed;
			margin-bottom: 40px;
			width: 23%;
		}
	}
	
  </style>

  {{-- <script type="text/javascript" src="file-upload/scripts/jquery.min.js"></script> --}}
  <script type="text/javascript" src="{{ asset("file-upload/scripts/jquery.form.js") }}"></script>
  <script type="text/javascript" src="{{ asset("file-upload/scripts/upload.js") }}"></script>
  <link type="text/css" rel="stylesheet" href="{{ asset("file-upload/style.css") }}" /> 

  <script type="text/javascript" src="{{ asset("bower_components/admin-lte/plugins/moment/moment.min.js") }}"></script>
  

	{{--  <div class="content-wrapper">  --}}

<section class="content">

  	<div class='row'>
  
		<div class='col-md-3'> <!-- left hand div -->
			<!-- USERS LIST -->
			<div class="left-hand-activity col-md-7">
			<div class="box box-primary"> <!-- department div-->
				<div class="box-header with-border">
					<!-- @cpnwaugha: c-e: here we will allow users see the other users in their department
					and admin and registry see all the users that are in the system.
					-->
					{{--@unless(Auth::user()->isRoot()) --}}
					<div><h3 class="box-title">Dept: {{ substr((Auth::user()->department ?? "ICT"), 0, 15) }}</h3></div>
					{{--@endunless --}}
					<div class="box-tools pull-right">
							{{-- auto fetch the users in the department--}}
							<span class="label label-primary"><label id='users_online'>{{ $dept_size }} </label>&nbsp; user(s)</span> {{-- The span is to be auto generated --}}
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							{{-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> --}}
					</div><!-- /.box-tool -->
				</div><!-- /.box-header -->
				<div class="box-body no-padding">
					<ul class="users-list clearfix">
						@foreach($dept_users as $user)
                            @if($user->department == Auth::user()->department)
                                @if($user->email == Auth::user()->email)
                                    @continue
                                @endif
                                <li>
                                    {{--<img src="{{ Gravatar::get($user->email) }}" class="user-image" alt="User Image"/> --}}
                                    <img src="{{asset("/img/profile_picture/photo/".$user->avatar) }}" class="offline" style="width: 52px; height: 52px; top: 10px; left: 10px; border-radius: 50%;" alt="User Image"/>
                                    <?php $full_name = $user->first_name.', '.$user->last_name; ?>
                                    <a class="users-list-name" href="">{!! link_to_route('admin.users.show', $full_name, [$user->id], []) !!}</a>
                                    {{-- <span class="users-list-date">{{ $user->created_at }}</span> --}}
                                </li>
                            @endif
                        @endforeach
					</ul><!-- /.users-list -->
				</div><!-- /.box-body -->
				<div class="box-footer text-center">
					<a href="viewallcontacts" class="uppercase">View All Users</a>
				</div><!-- /.box-footer -->
			</div>
			<!-- BROWSER USAGE -->
			<!-- TO DO List -->
			<div id="activity-timeline" class="box box-primary">
				<div class="box-header">
					<i class="ion ion-clipboard"></i>
					<h3 class="box-title">File Tracking</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						{{-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> --}}
					</div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<ul class="todo-list">
						@foreach($activities as $activity)
							@if($activity->type == 'onfolder' )													
								<?php $folder = Illuminate\Support\Facades\DB::table('folders')->where('id', $activity->element_id)->first(); ?>
								@if($activity->activity_by && $activity->activity_by == Auth::user()->email)
									<?php $to_username = Illuminate\Support\Facades\DB::table('users')->where('email', $activity->activity_to)->first();
									 ?>
									<li>  
										<small>{{ Auth::user()->first_name }}, {{ Auth::user()->last_name }}&nbsp; &nbsp;<img src="{{asset("/img/smaller.png") }}" class="offline" style="width: 25px;"/>
										&nbsp; &nbsp;
										{{ $to_username->first_name }}, {{ $to_username->last_name }}							  
										</small>
										<div></span><small class=""><b>{{ $folder->folder_no }}</b><small class="label label-default pull-right"><i class="fa fa-clock-o"></i>
										<b>{{ date('F d, Y', strtotime($activity->created_at )) }}</b></small></small>
										</div>
									</li>
								@endif

								@if($activity->activity_by && $activity->activity_to == Auth::user()->email)
									<?php $from_username = Illuminate\Support\Facades\DB::table('users')->where('email', $activity->activity_by)->first();
									?>
									<li>  
										<small>{{ $from_username->first_name }}, {{ $from_username->last_name }} &nbsp; &nbsp;<img src="{{asset("/img/smaller.png") }}" class="offline" style="width: 25px;"/>
										&nbsp; &nbsp;
										{{ Auth::user()->first_name }}, {{ Auth::user()->last_name }}							  
										</small>
										<div></span><small class=""><b>{{ $folder->folder_no }}</b><small class="label label-default pull-right"><i class="fa fa-clock-o"></i>
										<b>{{ date('F d, Y', strtotime($activity->created_at )) }}</b></small></small>
										</div>
									</li>
								@endif									
							@endif
							{{--  @if($activity->type == 'memo' )	
								@if($activity->activity_by == Auth::user()->email)
									<li>  
										<small>{{ Auth::user()->first_name }}, {{ Auth::user()->last_name }}</small>
										<div></span><small class=""><b>{{ $activity->activity }}</b><small class="label label-default pull-right"><i class="fa fa-clock-o"></i>
										<b>{{ date('F d, Y', strtotime($activity->created_at )) }}</b></small></small>
										</div>
									</li>
								@endif
							@endif  --}}
						@endforeach
					</ul>
				</div><!-- /.box-body -->
				<div class="box-footer text-center">
					<a href="viewall" class="uppercase">View All Activity</a>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
			</div>        
		</div><!-- /.col  end left div -->

    <!--<div class='row pull-right'> -->
		<div class='col-md-9'> <!-- right hand div -->
			
			<?php $loopindex = 0; ?>

			@if(!$folders)
				<!-- Default box -->
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title"><span class="label label-info"><label>Empty</label></span></h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
											title="Collapse">
								<i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
								<i class="fa fa-times"></i></button>
						</div>
					</div>
					<div class="box-body">
						<label><b>No Folder on Desk</b></label>
					</div>
					<!-- /.box-body -->
					{{--  <div class="box-footer">
						Footer
					</div>  --}}
					<!-- /.box-footer-->
				</div>
				<!-- /.box -->
			@endif
			
			@foreach($folders as $folder)

			<script>

				$( function() {
				var availableTags = [
					@foreach($forward_to_users as $user) 
						@if($user->id == Auth::user()->id)
							@continue;
						@endif
						@if( $user->clearance_level >= $folder->clearance_level) 
							"{{ $user->first_name }}, {{ $user->last_name }}",
						@endif
					@endforeach
					""
				];
				// @if($user->position){{$user->position}} - @endif

				$(".js-parents").select2();
				$(".select-with-search").select2({
					theme: "bootstrap",
					placeholder: "Select Recipient",
					//minimumInputLength: 3,
					allowClear: true,
					data: availableTags,
					tags: false
				});
			})
			</script>

			<?php $loopindex++; ?>
			<div class='container-fluid'> <!-- external panel -->
				<div class="col-md-9"> <!-- pull right col-md-9 div for pdf view + comment + forward, and file activity -->
				
					<!-- SERVER HEALTH REPORT -->
					
					<div class="box box-primary"> <!-- div for pdf view -->
						<div class="box-body no-padding">
							<div class="mailbox-read-info">
								<h3>File Name: <b>{{ $folder->name }}</b></h3>
								<h6>From: {{ $folder->folder_by }} <i class="fa fa-user"></i> <span id="read-time" class="mailbox-read-time pull-right">{{ date('F d, Y', strtotime($folder->created_at)) }}</span></h6>
							</div><!-- /.mailbox-read-info getFullNameAttribute() pdf header -->
						
							<div class="mailbox-read-message">        
								{{--  <object data="{{ asset("/docs/files/1/".$folder->name."/".$folder->latest_doc) }}" type="application/pdf" style="width: 100%" height="450">  --}}
								<object data="{{ asset("/docs/files".$folder->path."/".$folder->latest_doc) }}" type="application/pdf" style="width: 100%" height="450">
									<!-- support older browsers -->
									<!-- <embed src="uploads/C_TAW12_731.pdf" type="application/pdf" width="900" height="500"/> -->
									<!-- For those without native support, no pdf plugin, or no js -->
									<p>It appears you do not have PDF support in this web browser. 
									<a href="{{ asset("/docs/files".$folder->path."/".$folder->latest_doc) }}" target="_blank">Click here to download the document.</a></p>
								</object>
							</div><!-- /.mailbox-read-message -->
						</div><!-- /.box-body first pdf view-->
						
						<div class="box-footer">
							<ul id="attachfile{{$loopindex}}" class="mailbox-attachments clearfix">
							@foreach($files as $file)
								@if($file->folder_id == $folder->id)
					<?php
                if (strpos($file->name, 'pdf') !== false) {
                	echo'
					<li><span class="mailbox-attachment-icon has-img"><i class="fa fa-file-pdf-o"></i></span>
							<div class="mailbox-attachment-info">
							<i class="fa fa-paperclip"></i> <a href="docs/files'.$folder->path.'/'.$file->name.'" style="color: #000000;" target="_blank"> '.$file->original_name.'</a><br/>
								<span class="mailbox-attachment-size">
								'.$file->created_at.'
									<a href="docs/files'.$folder->path.'/'.$file->name.'" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
								</span>
							</div>
					</li>';

				} else{
				echo '
					<li><span class="mailbox-attachment-icon has-img"><i class="fa fa-file-image-o"></i></span>
						<div class="mailbox-attachment-info">
						<a href="docs/files'.$folder->path.'/'.$file->name.'" target="_blank" class="mailbox-attachment-name"><i class="fa fa-camera"></i> '.$file->original_name.'</a>
							<span class="mailbox-attachment-size">
							'.$file->created_at.'
								<a href="docs/files'.$folder->path.'/'.$file->name.'" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
							</span>
						</div>
					</li>';
				}
				?>



								@endif
							@endforeach
							</ul>
						</div> <!-- end box-footer for other pdfs attachment -->

						@include('views.attachment_libs')
						<!-- tesying file attachment -->					

						<div class="container hidden">

							<form method="post" name="upload_form" id="upload_form" enctype="multipart/form-data" action="attachment">
								<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">   
								<input type = "hidden" id="attachfolder_id{{$loopindex}}" name = "folder_id" value = "{{ $folder->id }}"> 
							    <label>Attach files</label>
								<br><br>
							    <input type="file" name="upload_images[]" id="image_file" multiple >
							    <div class="file_uploading hidden">
							        <label>&nbsp;</label>
							        <img src="{{asset("assets/attachment/img/uploading.gif")}}" alt="Uploading......"/>
							    </div>
							</form>
							<!-- <div id="uploaded_images_preview"></div> -->

						</div>

						<div class="row hidden">
							<div class="gallery">
								<?php
								if(!empty($uploaded_images)){ 
									foreach($uploaded_images as $image){ ?>
									<ul>
										<li >
											<img class="images" src="<?php echo $image; ?>" alt="">
										</li>
									</ul>
								<?php }	}?>
							</div>
						</div>
					
						<div class="box"> <!-- div for comment header-->
							<div class="box-header"> 

					<script type="text/javascript" src="scripts3/jquery.form.js"></script>
					<script type="text/javascript" src="scripts3/upload.js"></script>
					<link type="text/css" rel="stylesheet" href="style.css" />

								<div style="width:350px" align="center">
									<div id='preview'></div>    
									<form id="image_upload_form" method="post" enctype="multipart/form-data" action='single_upload' autocomplete="off">
										<input type = "hidden" id="folder_id" name = "folder_id" value = "{{ $folder->id }}"> 
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="path" value="{{"docs/files".$folder->path."/"}}">
										
										<div class="browse_text"><label>Attach File/Image:</label></div>

										<div class="file_input_container">
											<div class="upload_button"><div class="btn btn-info btn-file">
												<i class="fa fa-paperclip"></i> Attachment
											<input type="file" name="photo" id="photo" class="file_input" />
											</div>
											<p class="help-block">Max. 32MB</p></div>
										</div><br clear="all">
									</form>
								</div>
											     				        												
							</div>
							<div class="box-footer">
								<ul class="list-inline">
									<li class="pull-left">
										<a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments</a></li>
								</ul>
							</div>
						</div>  <!-- end box -->
					
					<!-- chat item -->
					<div class='chat'>					
						<div id="reload_comment{{$loopindex}}" class="divcomment">	<!-- comment on file -->
							@foreach($comments as $comment)
							@if($comment->folder_id == $folder->id)
								<div class="item">

									<?php $user = Illuminate\Support\Facades\DB::table('users')->where('email', $comment->comment_by)->first();
	                    
										$temp = array();
										foreach($user as $field => $val ){
											$temp[$field] = $val;
										}	                    
										$user_avatar = $temp['avatar']; $comment_user_name = $temp['first_name'] . ', '.$temp['last_name'];									
									?>
									{{--<img src="{{ Gravatar::get(Auth::user()->email), 'tiny'}}" class="offline" alt="User Image"/>--}}
									<img src="img/profile_picture/photo/{{ $user_avatar }}" class="offline" style="width: 42px; height: 42px; top: 10px; left: 10px; border-radius: 50%;" alt="User Image"/>
									<!--<img src="{{ asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}" alt="user image" class="offline"/>-->
									<p class="message">
										<a href="#" class="name"> <!-- @cpnwaugha: c-e: comments to have date and time -->
											<small class="text-muted pull-right">
												<i class="fa fa-clock-o"></i> {{ date('M d, Y', strtotime($comment->created_at)) }}
											</small> 
											 
											{{ $comment_user_name }}
										</a>
										{{ $comment->comment }}
									</p>
								</div>
							@endif
							@endforeach
						</div> 
					</div> <!-- end div comment -->

					<script>
						$(function(){

							$.ajaxSetup({
								headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
							});

							// posting comments...
							$(document).on('click', "button#submitPostBtn{{$loopindex}}", function(e){
								e.preventDefault();
								e.stopPropagation();

								if ($("#comment{{$loopindex}}").val() == ''){
									alert('Comment cannot be empty');
									return;
								}
								$('#postPinModal').modal('show');
								// when you click on the modal send button...
								$("#postPinBtn").on('click', function(e){
									e.preventDefault();
									e.stopPropagation();
									$('#postPinModal').modal('hide');

									var postPinForm = $('#post_pin_form').serialize();
									$('#post_pin_input').val(''); // cancel the value in the input field

									var data = postPinForm;

									$.ajax({
										url:"authpin",
										method:"GET",
										dataType:"text",
										data: data
									}).done(function(returnVal){
										if(returnVal == "true"){
											console.log('good, right pin');											
											var formData  = $("#commentForm{{$loopindex}}").serialize();
											postCommentForm(formData);
										}else{											
											$.toast({
												heading: 'PIN Verification',
												text: 'Wrong pin: Enter the correct PIN',
												icon: 'success',
												//bgColor: '#E01A31',
												hideAfter: 5000,
												showHideTransition: 'slide',
												loader: false,        // Change it to false to disable loader
												loaderBg: '#9EC600'  // To change the background
											});
											console.log('bad, wrong pin.');
										}
									}).fail(function(){										
										console.log('No connection to pin controller');
									});
								});
							});

							// forwarding new files...
							$(document).on('click', "button#forwardBtn{{$loopindex}}", function(e){
								e.preventDefault();
								e.stopPropagation();
								$('#forwardPinModal').modal('show');

								$("#forwardPinBtn").on('click', function(e){
									e.preventDefault();
									e.stopPropagation();
									$('#forwardPinModal').modal('hide');

									var forwardPinForm = $('#forward_pin_form').serialize();
									$('#forward_pin_input').val('');

									var data = forwardPinForm;

									$.ajax({
										url:"authpin",
										method:"GET",
										dataType:"text",
										data: data
									}).done(function(returnVal){
										console.log(returnVal);
										if(returnVal == "true"){
											console.log('good, right pin');											
											var formData  = $("#forwardForm{{$loopindex}}").serialize();
											forwardForm(formData);
										}else{
											console.log('bad, wrong pin.');
										}
									}).fail(function(returnData){
										console.log('No connection to pin controller');
									});
								});
							});		

							function postCommentForm(formData){

								var folder_id = $("#folder_id{{$loopindex}}").val();
								var comment_by= $("#comment_by{{$loopindex}}").val();
								var activity  = $("#activity{{$loopindex}}").val();
								var comment   = $("#comment{{$loopindex}}").val();
								var data = formData; // {comment: comment, comment_by: comment_by, folder_id: folder_id, activity: activity, '_token': $('input[name=_token]').val()};
								$("#comment{{$loopindex}}").val('');
								created_at = moment().format('ll'); //moment().startOf('hour').fromNow();  // an hour ago
									
								var renderComment = `
								<div class="item">
									<img src="img/profile_picture/photo/{{ Auth::user()->avatar }}" class="offline" style="width: 42px; height: 42px; top: 10px; left: 10px; border-radius: 50%;" alt="User Image"/>
									<p class="message">
									<a href="#" class="name"> 
									<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> ${created_at}</small> 
									${ comment_by }
									</a>
									${ comment }
									</p>
								</div>
								`;
								
								$("#reload_comment{{$loopindex}}").append(renderComment); 

								$.ajax({
									url:"ajaxcomment",
									method:"GET",
									dataType:"json",
									data: data
								}).done(function(returnData){
									console.log('Good, comment added to database.');
								}).fail(function(returnData){
									console.log('Bad, not connected');
								});

								$.toast({
									heading: 'New Comment',
									text: 'Comment added to Folder',
									icon: 'success',
									//bgColor: '#E01A31',
									hideAfter: 5000,
									showHideTransition: 'slide',
									loader: false,        // Change it to false to disable loader
									loaderBg: '#9EC600'  // To change the background
								});
							};

							// foward the folder
							function forwardForm(formData){

								var data = formData;
								$.ajax({
									url:"forward",
									method:"POST",
									dataType:"json",
									data: data
								}).done(function(returnData){
									location.href=location.href;
									console.log('Good, folder forward successful.');
								}).fail(function(returnData){
									console.log('Bad, not connected');
								});

								$.toast({
									heading: 'Folder Forwarded',
									text: 'Folder forwarded from Your Desk',
									icon: 'success',
									// bgColor: '#E01A31',
									hideAfter: 5000,
									showHideTransition: 'slide',
									loader: false,        // Change it to false to disable loader
									loaderBg: '#9EC600'  // To change the background
								});
							}

							function toastFunc(heading='heading', test='test', hideAfter=5000){
								$.toast({
									heading: heading,
									text: test,
									icon: 'success',
									// bgColor: '#E01A31',
									hideAfter: hideAfter,
									showHideTransition: 'slide',
									loader: false,        // Change it to false to disable loader
									loaderBg: '#9EC600'  // To change the background
								});
							}
						})
					</script>
				<!--</div> --><!-- end div chat-box -->

				<div><!-- div comment: Form to receive user's comment.-->
					<form action="comment" id="commentForm{{$loopindex}}" class='commentFormClass' method="post" enctype="multipart/form-data">
						<input type="hidden" id="comment_by{{$loopindex}}" name="comment_by" value="{{ Auth::user()->email }}">
						<input type="hidden" id="folder_id{{$loopindex}}" name="folder_id" value="{{ $folder->id }}">
						<input type="hidden" id="activity{{$loopindex}}" name="activity" value="{{ substr($folder->name, 3) }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="box-footer">
							<div class="input-group">
								<input class="form-control" id="comment{{$loopindex}}" name="comment" placeholder="Type message..."/>
								<div class="input-group-btn">
									<button id="submitPostBtn{{$loopindex}}" class="btn btn-primary commentrefresh"><i class="fa fa-plus"> Post</i></button>
								</div>
							</div>
						</div>
					</form>
				</div> <!-- end div -->
			
				<div class=""> <!--div forward file -->
					<form action="{{route('forward')}}" id="forwardForm{{$loopindex}}"  method="post">
						<input type = "hidden" name="_token" value="<?php echo csrf_token(); ?>">
						<input type="hidden" name="activity" value="{{ substr($folder->name, 3) }}">
						<input type="hidden" name="fold_name" value="{{ $folder->name }}">
						
						 
						<div class="box-footer">
							<div style="margin-left:5px"><label><b>Enter Recipient Email:</b></label></div>
							<div class="form-group">														              
								<div class="input-group">					 
									<div class="pmd-textfield pmd-textfield-floating-label img-responsive">       
										<select id="forward_to_user" class="form-control select-with-search select2" name="share-input" placeholder="Recipient Email..."></select>
									</div> 
									<div class="input-group-btn">
										<button id='forwardBtn{{$loopindex}}' class="btn btn-success"><i class="fa fa-share"></i> Forward</button>
									</div>
								</div>                   
							</div>
						</div>
					</form>
				</div><!-- /.box-footer --> <!--div forward file -->
						
				</div> <!-- div for pdf view -->	  <!-- Main content -->
			
				<!-- PROJECT STATUS -->
			</div><!-- /.col md-->
			
			<div class='col-md-3'>
				<div id="activity-timeline" class="box box-primary">
					<div class="box-header">
						<i class="fa fa-folder-open-o"></i>
						<h3 class="box-title">File Movement</h3>
						<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<ul class="todo-list">
						@foreach($file_movement as $activity)
							@if($activity->element_id == $folder->id)
								<li> 
									<small>{{ $activity->activity }}  </small>                  
									<small class="label label-info"> 
									<i class="fa fa-clock-o"></i>
									<b>{{ date('F d, Y', strtotime( $activity->created_at )) }}</b></small>
								</li>             
							@endif
						@endforeach
						</ul>
					</div><!-- /.box-body -->
				</div><!-- /.box -->        
			</div><!-- /.col -->
		</div><!-- /.container fluid -->
		@endforeach
			
			</div> <!-- end right div -->
 	</div><!-- /.row -->
</section><!-- content -->
<!-- </div> -->
@endsection