<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('comment_model');
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			header('Location: '.$this->uri->config->item('base_url'));
			exit;
		}
	}
	
	public function index()
	{
		if(_is_edit_comment($this) && NULL!==$this->input->post('post') && NULL!==$this->input->post('post')){
			$items=$this->comment_model->get_item($this,$this->input->post('id'));
			ob_start();
			$this->load->view('comment/edit_view',array('content'=>$items));
			$contents=ob_get_contents();
			ob_end_clean();
			echo json_encode(array('status'=>'OK','html'=>$contents));
			exit;
		}
		if(_is_create_comment($this)){
			ob_start();
			$this->load->view('comment/index_view',array('id'=>$this->input->post('id')));
			$content=ob_get_contents();
			ob_end_clean();
			echo json_encode(array('status'=>'OK','html'=>$content));
		}else{
			echo json_encode(array('status'=>'ERROR','message'=>'Access denied...'));
		}
		//$this->load->view('comment/index_view');
	}
	public function add()
	{
		if(_is_create_comment($this)){
			//var_dump($this->input->post('id'));
			$this->form_validation->set_rules('id', 'id', 'integer|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|xss_clean');
			if(false===$this->form_validation->run()){
				ob_start();
				$this->load->view('comment/index_view',array('id'=>$this->input->post('id')));
				$content=ob_get_contents();
				ob_end_clean();
				echo json_encode(array('status'=>'ERROR','html'=>$content));
			}else{
				/**
				$user
				$this->db->insert('comment', array(''));
				*/
				//var_dump($this->acl_model->acl_name_id(_if_auth($this)));exit;
				/**
				var_dump(_get_id_user_auth($this));exit;
				if(false!==_if_auth($this)){
					
				}
				*/
				if(NULL===_get_id_user_auth($this)){
					$array=array('text'=>$this->input->post('comment'),'post'=>$this->input->post('id'));
				}else{
					$array=array('user'=>_get_id_user_auth($this),'text'=>$this->input->post('comment'),'post'=>$this->input->post('id'));
				}
				$this->comment_model->insert($array);
				//$this->db->insert('comment', array(''));
				//$user=(false===($a=$this->acl_model->acl_name_id(_if_auth($this))))?NULL:$a;
				
				/**
				$this->db->select('user.nickname as user, comment.text as text, comment.id as id', false);
				$this->db->join("user", "user.id = comment.user", "inner");
				//$this->db->group_by("user.role");
				$this->db->order_by("id", "desc");
				
				var_dump($this->db->get('comment')->result_array());exit;
				*/
				
				$items=$this->comment_model->get_list($this,$this->input->post('id'));
				ob_start();
				$this->load->view('comment/list_view',array('items'=>$items));
				$content=ob_get_contents();
				ob_end_clean();
				echo json_encode(array('status'=>'OK','html'=>$content,'id'=>$this->input->post('id'),'message'=>'Your comment has been saved and will be verified by the moderator.'));
			}
		}else{
			echo json_encode(array('status'=>'ERROR','message'=>'Your request is not valid. Contact your system administrator.'));
		}
	}
	public function edit()
	{
		if(_is_edit_comment($this)){
			$this->form_validation->set_rules('id', 'id', 'integer|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|xss_clean');
			if(false===$this->form_validation->run()){
				$item=new stdClass();
				$item->id=$this->input->post('id');
				$item->text=$this->input->post('comment');
				$item->post=$this->input->post('post');
				ob_start();
				$this->load->view('comment/edit_view',array('content'=>$item));
				$content=ob_get_contents();
				ob_end_clean();
				echo json_encode(array('status'=>'ERROR','html'=>$content));
			}else{
				$this->comment_model->update($this->input->post('id'),array('text'=>$this->input->post('comment')));
				$items=$this->comment_model->get_list($this,$this->input->post('post'));
				ob_start();
				$this->load->view('comment/list_view',array('items'=>$items));
				$content=ob_get_contents();
				ob_end_clean();
				echo json_encode(array('status'=>'OK','html'=>$content,'id'=>$this->input->post('post'),'message'=>'Your message successfuly edited.'));
			}
		}else{
			echo json_encode(array('status'=>'ERROR','message'=>'Your request is not valid. Contact your system administrator.'));
		}
	}
	public function del()
	{
		if(_is_del_comment($this)){
			if(NULL===$this->input->post('id') && NULL===$this->input->post('post')){
				echo json_encode(array('status'=>'ERROR', 'message'=>'Your request is not valid. Contact your system administrator.'));
			}
			$this->comment_model->del($this->input->post('id'));
			$items=$this->comment_model->get_list($this,$this->input->post('post'));
			ob_start();
			$this->load->view('comment/list_view',array('items'=>$items));
			$content=ob_get_contents();
			ob_end_clean();
			echo json_encode(array('status'=>'OK','html'=>$content,'id'=>$this->input->post('post'),'message'=>'Your comment has been saved and will be verified by the moderator.'));
		}else{
			echo json_encode(array('status'=>'ERROR', 'message'=>'Your request is not valid. Contact your system administrator.'));
		}
	}
	public function hide()
	{
		if(_is_hide_comment($this)){
			if(NULL===$this->input->post('id') && NULL===$this->input->post('post')){
				echo json_encode(array('status'=>'ERROR', 'message'=>'Your request is not valid. Contact your system administrator.'));
			}
			$this->comment_model->hide($this->input->post('id'));
			$items=$this->comment_model->get_list($this,$this->input->post('post'));
			ob_start();
			$this->load->view('comment/list_view',array('items'=>$items));
			$content=ob_get_contents();
			ob_end_clean();
			echo json_encode(array('status'=>'OK','html'=>$content,'id'=>$this->input->post('post'),'message'=>'Your comment has been saved and will be verified by the moderator.'));
		}else{
			echo json_encode(array('status'=>'ERROR', 'message'=>'Your request is not valid. Contact your system administrator.'));
		}
	}
	public function show()
	{
		if(_is_hide_comment($this)){
			if(NULL===$this->input->post('id') && NULL===$this->input->post('post')){
				echo json_encode(array('status'=>'ERROR', 'message'=>'Your request is not valid. Contact your system administrator.'));
			}
			$this->comment_model->show($this->input->post('id'));
			$items=$this->comment_model->get_list($this,$this->input->post('post'));
			ob_start();
			$this->load->view('comment/list_view',array('items'=>$items));
			$content=ob_get_contents();
			ob_end_clean();
			echo json_encode(array('status'=>'OK','html'=>$content,'id'=>$this->input->post('post'),'message'=>'Your comment has been saved and will be verified by the moderator.'));
		}else{
			echo json_encode(array('status'=>'ERROR', 'message'=>'Your request is not valid. Contact your system administrator.'));
		}
	}
	public function check()
	{
		if(_is_hide_comment($this)){
			if(NULL===$this->input->post('id') && NULL===$this->input->post('post')){
				echo json_encode(array('status'=>'ERROR', 'message'=>'Your request is not valid. Contact your system administrator.'));
			}
			$this->comment_model->check($this->input->post('id'));
			$items=$this->comment_model->get_list($this,$this->input->post('post'));
			ob_start();
			$this->load->view('comment/list_view',array('items'=>$items));
			$content=ob_get_contents();
			ob_end_clean();
			echo json_encode(array('status'=>'OK','html'=>$content,'id'=>$this->input->post('post'),'message'=>'Your comment has been saved and will be verified by the moderator.'));
		}else{
			echo json_encode(array('status'=>'ERROR', 'message'=>'Your request is not valid. Contact your system administrator.'));
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */