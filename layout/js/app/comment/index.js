$(document).ready(function() {
	$('#myCommentId').submit(function(as) {
		var options = {
			url:Test.baseUrl+'comment/add',
			dataType: 'json',
			type:'post',
			success: function(resp){
				if(resp.status=='OK'){
					$('#wall-comment-'+resp.id).empty();
					$('#comment-list-'+resp.id).empty().html(resp.html);
					Wall.comment_link(true,resp.id);
					alert(resp.message);
				}else{
					$('#myCommentId').replaceWith(resp.html);
				}
			}
		};
    	$(this).ajaxSubmit(options); 
	    // return false to prevent normal browser submit and page navigation 
    	return false; 
	});
	$('#myCommentEdit').submit(function(as) {
		var options = {
			url:Test.baseUrl+'comment/edit',
			dataType: 'json',
			type:'post',
			success: function(resp){
				if(resp.status=='OK'){
					$('#myCommentEdit').remove();
					$('#comment-list-'+resp.id).empty().html(resp.html);
					Wall.comment_link(true,resp.id);
					alert(resp.message);
				}else{
					$('#myCommentEdit').replaceWith(resp.html);
				}
			}
		};
    	$(this).ajaxSubmit(options); 
	    // return false to prevent normal browser submit and page navigation 
    	return false; 
	});
});