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

if ( ! function_exists('_comment_entries'))
{
	function _comment_entries($a,$post)
	{
		return $a->comment_model->get_entries($a,$post);		
	}
}
if ( ! function_exists('_comment_list'))
{
	function _comment_list($a,$post)
	{
		return $a->comment_model->get_comment($a,$post);
	}
}
/* End of file auth_helper.php */
/* Location: ./application/helpers/auth_helper.php */