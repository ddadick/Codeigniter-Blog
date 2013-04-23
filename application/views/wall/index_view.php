<?php
if(isset($items) && count($items)){ 
	
	foreach($items as $item){
//var_dump($item);
?>

<div>
	<h2><?php echo $item->title ?></h2>
	<div>
		<p><?php echo ($item->text===NULL)?'':$item->text?></p>

<?php if(_is_create_comment($this)){?>
<div id="wall-comment-text-<?php echo $item->id?>" class="wall-comment-text" >
	<a id="wall-comment-text-add-<?php echo $item->id?>" class="wall-comment-text-add" href="javascript:;" onclick="Wall.comment_view('<?php echo $item->id?>');" style="display:block;"">Create Comment</a>
	<a id="wall-comment-text-cancel-<?php echo $item->id?>" class="wall-comment-text-cancel" href="javascript:;" onclick=" Wall.comment_link('','<?php echo $item->id?>');" style="display:none;"">Cancel Comment</a>
</div>
<?php } ?>

<?php if(_is_edit_post($this) && _is_edit_foreign_post($this,$item->user)){?>
<div>
<a href="#">Edit Post</a>
</div>
<?php } ?>

<?php if(_is_hide_post($this) && _is_hide_foreign_post($this,$item->user)){?>
<div>
<a href="#">Hide Post</a>
</div>
<?php } ?>

<?php if(_is_del_post($this) && _is_del_foreign_post($this,$item->user)){?>
<div>
<a href="#">Delete Post</a>
</div>
<?php } ?>
<div  id="wall-comment-<?php echo $item->id?>" class="wall-comment" style="display:none;"></div>
		<div id="comment-list-<?php echo $item->id ?>" class="comment-list-<?php echo $item->id ?>">
			<?php 
			$items=$this->comment_model->get_list($this,$item->id);
			ob_start();
			$this->load->view('comment/list_view',array('items'=>$items));
			$content=ob_get_contents();
			ob_end_clean();
			echo $content;
			?>
		</div>
	</div>

	
</div>
<?php }}?>
