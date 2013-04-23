$(document).ready(function() {
	/**
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
	*/
});
var Wall = {
		comment_view:function(id){
			$.ajax({
				  url: Test.baseUrl+"comment",
				  data:{'id':id},
				  type: 'post',
				  dataType:'json',
				  
			}).done(function(resp) {
				if(resp.status=='OK'){
				  $('#wall-comment-'+id).empty().html(resp.html).fadeIn(600,function(){
					  Wall.comment_link(null,id);
				  });
				}
			}).error(function(jqXHR,textStatus,errorThrown){
				
			});
		},
		comment_link:function(action,id){
			if($('#wall-comment-'+id).css('display')=='block' && typeof action === 'object'){
				$('#wall-comment-text-add-'+id).hide();
				$('#wall-comment-text-cancel-'+id).show();
			}else{
				$('#wall-comment-'+id).empty().fadeOut(600, function(){
					$('#wall-comment-text-cancel-'+id).hide();
					$('#wall-comment-text-add-'+id).show();
				});
			}
		}
}