<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wall extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
	
		$this->load->model('post_model');
		$this->load->model('comment_model');
		
	}
	
	public function index()
	{
		$items=$this->post_model->get_entries();
		$request=(object)array('items'=>$items);
		ob_start();
		$this->load->view('wall/index_view',$request);
		$content=ob_get_contents();
		ob_end_clean();
		$this->load->view('wall_layout',array('content'=>$content));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */