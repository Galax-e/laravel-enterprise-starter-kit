<?php 
include('header.php');
include_once("db_connect.php");
session_start();
$session_id='1'; 
?>
<title>Image Upload</title>
<?php include('container.php');?>
<script type="text/javascript" src="scripts/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type="text/javascript" src="scripts/upload.js"></script>
<link type="text/css" rel="stylesheet" href="style.css" />
<div class="container">
	<h2>Image Upload without Page Refresh with PHP and jQuery</h2>	
	<br />
	<div class="upload_container">
		<br clear="all" />
		<center>
			<div style="width:350px" align="center">
				<div id='preview'></div>	
				<form id="image_upload_form" method="post" enctype="multipart/form-data" action='image_upload.php' autocomplete="off">
					<div class="browse_text">Browse Image File:</div>
					<div class="file_input_container">
						<div class="upload_button"><input type="file" name="photo" id="photo" class="file_input" /></div>
					</div><br clear="all">
				</form>
			</div>
		</center>
		<br clear="all" />
	</div>
</div>
<?php include('footer.php');?>