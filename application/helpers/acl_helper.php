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
			return TRUE;
		}
		return FALSE;
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
if ( ! function_exists('_is_check_comment'))
{
	function _is_check_comment($a)
	{
		return $a->acl_model->acl_post_c0($a->session->userdata('auth'));
	}
}
if ( ! function_exists('_is_create_comment'))
{
	function _is_create_comment($a)
	{
		return $a->acl_model->acl_post_c1($a->session->userdata('auth'));		
	}
}

if ( ! function_exists('_is_edit_comment'))
{
	function _is_edit_comment($a)
	{
		return $a->acl_model->acl_post_c2($a->session->userdata('auth'));
	}
}
if ( ! function_exists('_is_hide_comment'))
{
	function _is_hide_comment($a)
	{
		return $a->acl_model->acl_post_c3($a->session->userdata('auth'));
	}
}
if ( ! function_exists('_is_del_comment'))
{
	function _is_del_comment($a)
	{
		return $a->acl_model->acl_post_c4($a->session->userdata('auth'));
	}
}
if ( ! function_exists('_is_edit_foreign_comment'))
{
	function _is_edit_foreign_comment($a,$user)
	{
		return $a->acl_model->acl_post_cr2($a->session->userdata('auth'),$user);
	}
}
if ( ! function_exists('_is_hide_foreign_comment'))
{
	function _is_hide_foreign_comment($a,$user)
	{
		return $a->acl_model->acl_post_cr3($a->session->userdata('auth'),$user);
	}
}
if ( ! function_exists('_is_del_foreign_comment'))
{
	function _is_del_foreign_comment($a,$user)
	{
		return $a->acl_model->acl_post_cr4($a->session->userdata('auth'),$user);
	}
}


if ( ! function_exists('_is_create_post'))
{
	function _is_create_post($a)
	{
		return $a->acl_model->acl_post_p1($a->session->userdata('auth'));
	}
}
if ( ! function_exists('_is_edit_post'))
{
	function _is_edit_post($a)
	{
		return $a->acl_model->acl_post_p2($a->session->userdata('auth'));
	}
}
if ( ! function_exists('_is_hide_post'))
{
	function _is_hide_post($a)
	{
		return $a->acl_model->acl_post_p3($a->session->userdata('auth'));
	}
}
if ( ! function_exists('_is_del_post'))
{
	function _is_del_post($a)
	{
		return $a->acl_model->acl_post_p4($a->session->userdata('auth'));
	}
}
if ( ! function_exists('_is_edit_foreign_post'))
{
	function _is_edit_foreign_post($a,$user)
	{
		return $a->acl_model->acl_post_pr2($a->session->userdata('auth'),$user);
	}
}
if ( ! function_exists('_is_hide_foreign_post'))
{
	function _is_hide_foreign_post($a,$user)
	{
		return $a->acl_model->acl_post_pr3($a->session->userdata('auth'),$user);
	}
}
if ( ! function_exists('_is_del_foreign_post'))
{
	function _is_del_foreign_post($a,$user)
	{
		return $a->acl_model->acl_post_pr4($a->session->userdata('auth'),$user);
	}
}

/* End of file auth_helper.php */
/* Location: ./application/helpers/auth_helper.php */