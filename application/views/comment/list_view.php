<?php foreach($items as $item){ 
				if($item->text!==NULL){
			
			?>
			<div id="comment-<?php echo $item->comment_id ?>" class="comment-<?php echo $item->comment_id ?>">
			
				<div  id="comment-item-autor" class="comment-item-autor"><?php echo 'comment\'s '.$item->username; ?></div>
				<div  id="comment-item-text" class="comment-item-text">
					<?php echo $item->text?>
				</div>
				<?php if(!$item->check){?>
				<?php if(_is_check_comment($this)){?>
				<div><a href="javascript:;" onclick="return Comment.check('<?php echo $item->comment_id; ?>','<?php echo $item->post; ?>');">Check comment</a></div>
				<?php } ?>
				<?php } ?>
				<?php if(_is_edit_comment($this) && _is_edit_foreign_comment($this,$item->user)){?>
				<div><a href="javascript:;" onclick="return Comment.edit('<?php echo $item->comment_id; ?>','<?php echo $item->post; ?>');">Edit comment</a></div>
				<?php } ?>
				<?php if($item->active){?>
				<?php if(_is_hide_comment($this) && _is_hide_foreign_comment($this,$item->user)){?>
				<div><a href="javascript:;" onclick="return Comment.hide('<?php echo $item->comment_id; ?>','<?php echo $item->post; ?>');">Hide comment</a></div>
				<?php } ?>
				<?php }else{?>
				<?php if(_is_hide_comment($this) && _is_hide_foreign_comment($this,$item->user)){?>
				<div><a href="javascript:;" onclick="return Comment.show('<?php echo $item->comment_id; ?>','<?php echo $item->post; ?>');">Show comment</a></div>
				<?php } ?>
				<?php }?>
				<?php if(_is_del_comment($this) && _is_del_foreign_comment($this,$item->user)){?>
				<div><a href="javascript:;" onclick="return Comment.delete('<?php echo $item->comment_id; ?>','<?php echo $item->post; ?>');">Delete comment</a></div>
				<?php } ?>
				
				
			</div>
			<?php }} ?>