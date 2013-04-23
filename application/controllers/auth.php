<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	
	public function __construct()
   {
      parent::__construct();
      $this->load->helper('url');
      $this->load->library('form_validation');
      $this->load->model('acl_model');
   }
	
	public function index()
	{
		_auth($this);
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			if(false===$this->form_validation->run()){
				ob_start();
				$this->load->view('auth/login_view',array('error'=>true));
				$content=ob_get_contents();
				ob_end_clean();
				//var_dump($content);
				echo json_encode(array('status'=>'ERROR','html'=>$content));
				exit;
			}else{
				if(!$this->acl_model->find_user($this->input->post('login'),$this->input->post('password'))){
					ob_start();
					$this->load->view('auth/login_view',array('form_error'=>'Incorrectly typed or user name or password'));
					$content=ob_get_contents();
					ob_end_clean();
					echo json_encode(array('status'=>'ERROR','html'=>$content));
					exit;
				}
				if(false===$this->acl_model->set_auth(_set_auth($this),$this->input->post('login'))){
					ob_start();
					$this->load->view('auth/login_view',array('form_error'=>'Blog temporarily not available. Conducting technical work.'));
					$content=ob_get_contents();
					ob_end_clean();
					echo json_encode(array('status'=>'ERROR','html'=>$content));
					exit;
				}
				echo json_encode(array('status'=>'OK'));
				exit;
			}
		}else{
        	ob_start();
        	$this->load->view('auth/login_view');
        	$content=ob_get_contents();
        	ob_end_clean();
        	$this->load->view('auth_layout',array('content'=>$content));
		}
	}
	public function logout()
	{
		_del_auth($this);
		exit;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */