<?php
include_once("db_connect.php");
session_start();
$session_id='1'; 
$path = "uploads/";
$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","pdf");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
	$name = $_FILES['photo']['name'];
	$size = $_FILES['photo']['size'];
	if(strlen($name)) {
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext,$valid_formats)) {
			if($size<(1024*1024)) {
				$image_name = time().$session_id.".".$ext;
				$tmp = $_FILES['photo']['tmp_name'];
				if(move_uploaded_file($tmp, $path.$image_name)){
					mysqli_query($conn, "UPDATE users SET profile_photo='$image_name' WHERE uid='1'");
					echo "<img src='file-upload/uploads/".$image_name."' class='preview'>";
				}
				else
				echo "Image Upload failed";
			}
			else
			echo "Image file size max 1 MB";
		}
		else
		echo "Invalid file format..";
	}
	else
	echo "Please select image..!";
	exit;
}
?>