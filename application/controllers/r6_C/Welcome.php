<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('session');
	}

	public function index()
	{
		$this->load->view('r6_V/welcome_message');
	}

	function welc(){
		$this->load->helper('url');
		$this->load->library('session');
		if (array_key_exists('uid', $this->session->userdata)){
			if ($this->session->userdata['user_type']==2){
				if ($this->session->userdata['uid']!=null)
					$this->session->set_userdata(array('tid'=>$this->session->userdata['uid']));
				$this->teacher();
				return;
			}
			if ($this->session->userdata['user_type']==1){
				if ($this->session->userdata['uid']!=null)
					$this->session->set_userdata(array('sid'=>$this->session->userdata['uid']));
				$this->student();
				return;
			}
			return;
		}
		
		if ($_SERVER["REQUEST_METHOD"]=='POST'){
			if ($_POST['type'] == 'Teacher'){
				$arr=array('tid'=>$_POST['id'], 'user_type'=>2, 'uid'=>$_POST['id']);
				$this->session->set_userdata($arr);
				//redirect('/welcome/teacher/', 'refresh');
				//$this->load->view('r6_V/welcome/Teacher');
				$this->teacher();
				return;
			}
			if ($_POST['type'] == 'Student'){
				$arr=array('sid'=>$_POST['id'], 'user_type'=>1, 'uid'=>$_POST['id']);
				$this->session->set_userdata($arr);
				//redirect('/welcome/student/', 'refresh');
				$this->load->view('r6_V/welcome/Student');
				return;
			}
		}
		$this->load->view('r6_V/welcome_message');
	}

	function teacher(){
		$this->load->view('r6_V/welcome/Teacher');
	}

	function student(){
		$this->load->view('r6_V/welcome/Student');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */