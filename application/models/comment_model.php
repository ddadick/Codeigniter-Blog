<?php

class Comment_model extends CI_Model
{

	
  function __construct()
  {
    parent::__construct();

    $this->tableName = 'comment';
    
  }
  function get_list($a,$post,$user=NULL){
  	
  	$acl=_if_auth($a);
  	if(_is_check_comment($a)){
  		$this->db->where(array('comment.post'=>$post,));
  	}else{
  		if($acl){
  			$this->db->where(array('comment.post'=>$post,'comment.check'=>'1'));
  		}else{
  			$this->db->where(array('comment.post'=>$post,'comment.active'=>'1','comment.check'=>'1'));
  		}
  	}
  	$this->db->select('comment.id as comment_id, comment.text, comment.user, comment.post,comment.active,comment.check');
  	$this->db->order_by('comment.timestamp','desc');
  	if(!$acl){
  		$query=$this->db->get('comment', 10);
  	}else{
  		$query=$this->db->get('comment');
  	}
  	//var_dump($query->result());exit;
  	$array=array();
  	foreach($query->result() as $item_comment){
  		if($acl && !isset($count_comment)){
  			$count_comment=0;
  		}elseif($acl && isset($count_comment) && $count_comment<10){
  			$count_comment=$count_comment+1;
  		}elseif($acl && isset($count_comment) && $count_comment>10){
  			break;
  		}
  		if($item_comment->user===NULL){
  			$item_comment->username=_find_user_from_id_auth($this,_get_id_guest_auth($a));
  		}else{
  			$item_comment->username=_find_user_from_id_auth($a,$item_comment->user);
  		}
  		//$item_comment->text=$comment;
  		if($acl && $item_comment->user==$user && !$item_comment->active){
  			array_push($array,$item_comment);
  		}else{
  			array_push($array,$item_comment);
  		}
  		
  	}
  	//var_dump($array);exit;
  	return $array;
  }
  function get_item($a,$id){
  	$this->db->select('*');
  	$this->db->where(array('comment.id'=>$id));
  	$query=$this->db->get('comment')->result();
  	return $query[0];
  }
  function update($id,$options=array()){
  	$options=array_change_key_case($options,CASE_LOWER);
  	if(isset($options['text']) && strlen(trim($options['text']))){
  		$this->db->where('id', $id);
  		$this->db->update('comment',array('text'=>$options['text']));
  	}else{
  		return false;
  	}
  }
  function del($id){
  	$this->db->delete('comment',array('id'=>$id));
  }
  function hide($id){
  	$this->db->where('id', $id);
  	$this->db->update('comment',array('active'=>'0'));
  }
  function show($id){
  	$this->db->where('id', $id);
  	$this->db->update('comment',array('active'=>'1'));
  }
  function check($id){
  	$this->db->where('id', $id);
  	$this->db->update('comment',array('check'=>'1'));
  }
  function insert($options=array()){
  	$options=array_change_key_case($options,CASE_LOWER);
  	if(isset($options['text']) && strlen(trim($options['text']))){
  		$this->db->insert('comment', $options);
  	}else{
  		return false;
  	}
  }

}

