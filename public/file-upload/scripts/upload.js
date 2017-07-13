$(document).ready(function() {		
	$('#photo').on('change', function()			{ 
		$("#preview").html('');
		$("#preview").html('<img src="loader.gif" alt="Uploading...."/>');
	$("#image_upload_form").ajaxForm({
				target: '#preview'
}).submit();

	});
}); 