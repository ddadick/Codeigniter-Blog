var Comment = {
	delete:function(id,post){
		$.ajax({
			  url: Test.baseUrl+"comment/del",
			  data:{'id':id, 'post':post},
			  type: 'post',
			  dataType:'json',
			  
		}).done(function(resp) {
			if(resp.status=='OK'){
				$('#comment-list-'+resp.id).empty().html(resp.html);
				Wall.comment_link(true,resp.id);
			}
		}).error(function(jqXHR,textStatus,errorThrown){});
	},
	hide:function(id,post){
		$.ajax({
			url: Test.baseUrl+"comment/hide",
			data:{'id':id, 'post':post},
			type: 'post',
			dataType:'json',
		}).done(function(resp) {
			if(resp.status=='OK'){
				$('#comment-list-'+resp.id).empty().html(resp.html);
				Wall.comment_link(true,resp.id);
			}
		}).error(function(jqXHR,textStatus,errorThrown){});
	},
	show:function(id,post){
		$.ajax({
			url: Test.baseUrl+"comment/show",
			data:{'id':id, 'post':post},
			type: 'post',
			dataType:'json',
		}).done(function(resp) {
			if(resp.status=='OK'){
				$('#comment-list-'+resp.id).empty().html(resp.html);
				Wall.comment_link(true,resp.id);
			}
		}).error(function(jqXHR,textStatus,errorThrown){});
	},
	check:function(id,post){
		$.ajax({
			url: Test.baseUrl+"comment/check",
			data:{'id':id, 'post':post},
			type: 'post',
			dataType:'json',
		}).done(function(resp) {
			if(resp.status=='OK'){
				$('#comment-list-'+resp.id).empty().html(resp.html);
				Wall.comment_link(true,resp.id);
			}
		}).error(function(jqXHR,textStatus,errorThrown){});
	},
	edit:function(id,post){
		$.ajax({
			  url: Test.baseUrl+"comment",
			  data:{'id':id,'post':post},
			  type: 'post',
			  dataType:'json',
			  
		}).done(function(resp) {
			if(resp.status=='OK'){
				
			  $('#comment-'+id).empty().html(resp.html).fadeIn(600,function(){
				  Wall.comment_link(null,id);
			  });
			}
		}).error(function(jqXHR,textStatus,errorThrown){});
	}
	
}