$(document).ready(function() {
	$('#myFormId').submit(function() { 
		var options = {
			url:$('#myFormId').attr('action'),
			dataType: 'json',
			success: function(request){
				if(request.status=='OK'){
					window.location=Test.baseUrl;
				}else{
					$('#myFormId').replaceWith(request.html);
				}
			}
		};
    	$(this).ajaxSubmit(options); 
	    // return false to prevent normal browser submit and page navigation 
    	return false; 
	});
});