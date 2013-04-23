<?php

class Post_model extends CI_Model
{

	
  function __construct()
  {
    parent::__construct();

    $this->tableName = 'post';
    
  }
  
  function get_entries()
  {
  	
  	/**
  	 * select first_post.id as id, first_post.user as user, first_post.text as post, first_comment.id as comment_id, first_comment.text as comment
  	 *  from first_post left outer join first_comment on (first_post.id=first_comment.post and first_comment.active='1' and first_comment.check='1') 
  	 *  where first_post.active='1' order by first_post.timestamp desc, first_comment.timestamp desc 
  	 */
   	//var_dump($this->load->database('swap_pre'));
   	/**
  	$this->db->select('post.id as id, post.user as user, post.text as post, comment.id as comment_id, comment.text');
  	$this->db->join("comment", "post.id=comment.post and {PRE}comment.active='1' and {PRE}comment.check='1'","left outer");
  	//$this->db->join("comment", "comment.active=1","left outer");
  	//$this->db->join("comment", "comment.check=1","left outer");
  	$this->db->where(array('post.active'=>'1'));
  	$this->db->order_by('post.timestamp','desc');
  	$this->db->order_by('comment.timestamp','desc');
  	$query=$this->db->get('post', 10);
*/
	
  	$this->db->select('*');
  	$this->db->order_by("timestamp", "desc");
  	$query = $this->db->get($this->tableName, 3);
  	//echo '<pre>';
  	//var_dump($query->result());
  	//echo '</pre>';
  	 
  	// return $query->result();
  	$array=array();
  	foreach($query->result() as $key=>$items){
  		if($items->user===NULL){
  			$items->usernamne=_find_user_from_id_auth($this,_get_id_guest_auth($this));
  		}else{
  			$items->username=_find_user_from_id_auth($this,$items->user);
  		}
  		array_push($array,$items);
  	}
  	//echo '<pre>';
  	//var_dump($array);
  	//echo '</pre>';
  	return $array;
  	
  	/**
  	$query = $this->db->get($this->tableName, 10);
  	return $query->result();
  	*/
  }

}

