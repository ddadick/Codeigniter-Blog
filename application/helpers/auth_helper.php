<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
 * Parse out the attributes
 *
 * Some of the functions use this
 *
 * @access	private
 * @param	array
 * @param	bool
 * @return	string
 */
if ( ! function_exists('_auth'))
{
	function _auth($a,$url=NULL)
	{
		$url=(NULL===$url && !strlen(trim($url)))?$a->uri->config->item('base_url'):$url;
		if(false!==($s=$a->session->userdata('auth')) && false!==($c=$a->input->cookie('test_auth')) && $s==$c){
			header('Location: '.$url);
			exit;
		}
	}
}
if ( ! function_exists('_if_auth'))
{
	function _if_auth($a)
	{
		if(false!==($s=$a->session->userdata('auth')) && false!==($c=$a->input->cookie('test_auth')) && $s==$c){
			return $a->acl_model->acl_name_user($a->session->userdata('auth'));
			//return TRUE;
		}
		return FALSE;
	}
}
if ( ! function_exists('_get_id_user_auth'))
{
	function _get_id_user_auth($a)
	{
		if(false!==($s=$a->session->userdata('auth')) && false!==($c=$a->input->cookie('test_auth')) && $s==$c){
			return $a->acl_model->acl_name_id($a->session->userdata('auth'));
			//return TRUE;
		}
		return NULL;
	}
}
if ( ! function_exists('_find_user_from_id_auth'))
{
	function _find_user_from_id_auth($a,$id=NULL)
	{
		return $a->acl_model->find_user_from_id($id);
	}
}
if ( ! function_exists('_get_id_guest_auth'))
{
	function _get_id_guest_auth($a)
	{
		return $a->acl_model->default_id_guest();
	}
}
if ( ! function_exists('_set_auth'))
{
	function _set_auth($a)
	{
		$auth=mt_rand().'-'.mt_rand().'-'.mt_rand().'-'.mt_rand();
		$a->input->set_cookie(
			array(
				'name'=>'auth',
				'value'=>$auth,
				'expire'=>'0',
				'domain' => '',
				'path' => '/',
				'prefix' => 'test_',
				TRUE
			)
		);
		if(false!==$a->session->userdata('auth')){
			$a->session->unset_userdata('auth');
		}
		$a->session->set_userdata('auth', $auth);
		return $auth;
	}
}
if ( ! function_exists('_del_auth'))
{
	function _del_auth($a)
	{
		$a->acl_model->del_auth($a->session->userdata('auth'));
		$a->session->unset_userdata('auth');
		header('Location: '.$a->uri->config->item('base_url'));
		_auth($a);
		
	}
}
/* End of file auth_helper.php */
/* Location: ./application/helpers/auth_helper.php */