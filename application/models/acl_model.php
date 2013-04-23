<?php

class Acl_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();

    
  }
  
  function get_roles(){
  	$this->db->select('user.nickname as orders, roles.name as type, roles.comment as comment, roles.post as post', false);
  	$this->db->join("user", "user.role = roles.order", "inner");
  	$this->db->group_by("user.role");
  	$this->db->order_by("orders", "desc");
  	$user_role=$this->db->get('roles')->result_array();
  	foreach($user_role as $key=>$items){
  		$user_role[$key]=(object)$user_role[$key];
  	}
  	foreach($user_role as $key=>$items){
  		$items=(object)$items;
  		$array=array();
  		$tok = strtok($items->comment, "/");
  		while ($tok !== false) {
  			array_push($array,$tok);
  			$tok = strtok("/");
		}
		$user_role[$key]->comment=(object)$array;
		$array=array();
		$tok = strtok($items->post, "/");
		while ($tok !== false) {
			array_push($array,$tok);
			$tok = strtok("/");
		}
		$user_role[$key]->post=(object)$array;
  	}
  	return $user_role;
  }
  
  function find_user($user=NULL,$pass=NULL){
  	$this->db->select('*', false);
  	$this->db->where(array('nickname'=>$user,'passnocesret'=>$pass));
  	return (count($a=$this->db->get('user')->result_array()))?$a:false;
  	
  }
  
  function find_user_from_id($id=NULL){
  	if($id===NULL){
  		return false;
  	}
  	$this->db->select('nickname', false);
  	$this->db->where(array('id'=>$id));
  	return (count($a=$this->db->get('user')->result_array()))?$a[0]['nickname']:false;
  	 
  }
  
  function set_auth($auth=NULL,$user=NULL){
  	if(NULL===$auth && NULL===$user){
  		return false;
  	}
  	$this->db->select('id', false);
  	$this->db->where(array('nickname'=>$user,));
  	if(false===((count($a=$this->db->get('user')->result_array()))?$a:false)){
  		return false;
  	}
  	$this->db->select('id', false);
  	$this->db->where(array('user'=>$a[0]['id'],'hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		if(false===$this->db->insert('user_hash',array('hash'=>$auth, 'user'=>$a[0]['id']))){
  			return false;
  		}
  	}else{
  		if(false===$this->db->update('user_hash',array('hash'=>$auth),array('user'=>$a[0]['id']))){
  			return false;
  		}
  	}
	return true;
  	
  }
  
  function del_auth($auth=NULL){
  	if(NULL===$auth){
  		return false;
  	}
  	if(false===$this->db->delete('user_hash',array('hash'=>$auth))){
  		return false;
  	}
  	return true;
  	 
  }
  
  
  
  function default_role(){
  	return '1';
  }
  function default_id_guest(){
  	return '5';
  }
  private function defaul_find_function($auth=NULL){
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return $this->default_role();
  	}else{
  		$this->db->select('role', false);
	  	$this->db->where(array('id'=>$b[0]['user']));
  		if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  			return false;
  		}
  		return $b[0]['role'];
  	}
  }
  // Name of user of auth-name
  function acl_name_user($auth=NULL){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}else{
  		$this->db->select('nickname', false);
  		$this->db->where(array('id'=>$b[0]['user']));
  		if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  			return false;
  		}
  		return $b[0]['nickname'];
  	}
  }
  // Name of user of auth-name
  function acl_name_user_from_id($id=NULL){
  	if(NULL===$id){
  		return false;
  	}
  	$this->db->select('nickname', false);
  	$this->db->where(array('id'=>$id));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['nickname'];
  }
  // Name of user of auth-key
  function acl_name_id($auth=NULL){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}else{
  		$this->db->select('id', false);
  		$this->db->where(array('id'=>$b[0]['user']));
  		if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  			return false;
  		}
  		return $b[0]['id'];
  	}
  }
  
  /**
   * ACL for create comment
   * @param string $auth
   * @return boolean
   */
  
  function acl_post_c0($auth=NULL){
  	if(NULL===$auth){
  		return false;
  	}
  	if(false===($b[0]['role']=$this->defaul_find_function($auth))){
  		return false;
  	}
  	$this->db->select('c0', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['c0'];
  }
  
  function acl_post_c1($auth=NULL){
	if(NULL===$auth){
  		return false;
  	}
  	if(false===($b[0]['role']=$this->defaul_find_function($auth))){
  		return false;
  	}
  	$this->db->select('c1', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['c1'];
  }
  
  function acl_post_c2($auth=NULL){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('c2', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['c2'];
  }
  
  function acl_post_c3($auth=NULL){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('c3', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['c3'];
  }
  
  function acl_post_c4($auth=NULL){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('c4', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['c4'];
  }
  
  function acl_post_cr2($auth=NULL,$user){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	if((int)$user==(int)$b[0]['user']){
  		return true;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('cr2', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['cr2'];
  }
  
  function acl_post_cr3($auth=NULL,$user){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	if((int)$user==(int)$b[0]['user']){
  		return true;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('cr3', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['cr3'];
  }
  
  function acl_post_cr4($auth=NULL,$user){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	if((int)$user==(int)$b[0]['user']){
  		return true;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('cr4', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['cr4'];
  }
  

  
  /**
   * ACL for create post
   * @param string $auth
   * @return boolean
   */
  function acl_post_p1($auth=NULL){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('p1', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['p1'];
  }
  
  function acl_post_p2($auth=NULL){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('p2', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['p2'];
  }
  
  function acl_post_p3($auth=NULL){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('p3', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['p3'];
  }
  
  function acl_post_p4($auth=NULL){
  	if(NULL===$auth){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('p4', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['p4'];
  }
  
  function acl_post_pr2($auth=NULL,$user=NULL){
  	if(NULL===$auth || NULL===$user){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	if((int)$user==(int)$b[0]['user']){
  		return true;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){  		
  		return false;
  	}
  	$this->db->select('pr2', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}  	 
  	return $b[0]['pr2'];
  }
  
  function acl_post_pr3($auth=NULL,$user=NULL){
  	if(NULL===$auth || NULL==$user){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	if((int)$user==(int)$b[0]['user']){
  		return true;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('pr3', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['pr3'];
  }
  
  function acl_post_pr4($auth=NULL,$user=NULL){
  	if(NULL===$auth || NULL==$user){
  		return false;
  	}
  	$this->db->select('user', false);
  	$this->db->where(array('hash'=>$auth));
  	if(false===((count($b=$this->db->get('user_hash')->result_array()))?$b:false)){
  		return false;
  	}
  	if((int)$user==(int)$b[0]['user']){
  		return true;
  	}
  	$this->db->select('role', false);
  	$this->db->where(array('id'=>$b[0]['user']));
  	if(false===((count($b=$this->db->get('user')->result_array()))?$b:false)){
  		return false;
  	}
  	$this->db->select('pr4', false);
  	$this->db->where(array('order'=>$b[0]['role']));
  	if(false===((count($b=$this->db->get('roles')->result_array()))?$b:false)){
  		return false;
  	}
  	return $b[0]['pr4'];
  }
  
  
}

