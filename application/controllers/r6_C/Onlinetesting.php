<?php
/*
	onlinetesting controller
	Set Exam for teacher
	Enter Exam for student
	get mark after submit
*/
class Onlinetesting extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('session');
	}

	function index(){
		$this->load->view('r6_V/onlinetest/error');
	}

/*
	uptype function
	gettype from _post
	Teacher's page for teacher
	Student's page for student
*/
	function uptype(){
		$this->load->library('session');
		if ($_SERVER["REQUEST_METHOD"]=='POST'){
			if ($this->session->userdata['user_type'] == 2){
				$this->load->model('r6_M/Onlinetestmodel');
				$this->load->helper('url');
				$pape=$this->Onlinetestmodel->get_paper($this->session->userdata['tid']);
				$pap = array();
				foreach($pape as $x){
					$pap[$x->PID]='Paper '.$x->PID;
				}
				$this->load->model('r2/search_model');
				$info = array('teacher_id'=>$this->session->userdata['tid']);
				$data = $this->search_model->classinfo($info);
				$arr=array('pap'=>$pap, 'alert'=>false, 'cids'=>$data);
				$this->load->view('r6_V/onlinetest/Tpage', $arr);
				return;
			}
			if ($this->session->userdata['user_type'] == 1){
				$this->load->model('r6_M/Onlinetestmodel');
				$this->load->helper('url');
				$probs=array();
				$prob=$this->Onlinetestmodel->get_exam($this->session->userdata['sid']);
				foreach($prob as $x){
					$probs[$x->EID] = $x->INFO;
				}
				$arr=array('probs'=>$probs);
				$this->load->view('r6_V/onlinetest/Spage', $arr);
				return;
			}
		}
		$this->load->view('r6_V/onlinetest/error');
	}

/*
	creat_exam function
	check teacher's form
	if ok, create a new exam, else alert.
	using pid, cid, info, times to describe an exam
*/
	function creat_exam(){
		if ($_SERVER["REQUEST_METHOD"]=='POST'){
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cid', 'cid', 'required');
			$this->form_validation->set_rules('info', 'info', 'required');
			$tim = (int)$_POST['length'];
			$flag=$this->form_validation->run();
			if ($tim<=0) $flag = false;
			
			if ($flag==false){
				$this->load->model('r6_M/Onlinetestmodel');
				$pape=$this->Onlinetestmodel->get_paper($this->session->userdata['tid']);
				$pap = array();
				foreach($pape as $x){
					$pap[$x->PID]='Paper '.$x->PID;
				}
				$arr=array('pap'=>$pap, 'alert'=>true);
				$this->load->view('r6_V/onlinetest/Tpage', $arr);
				return;
			}
			
			$arr=array("TID"=>$this->session->userdata['tid']);
			$arr["PID"]=$_POST['pid'];
			$arr["CID"]=$_POST['cid'];
			$arr["INFO"]=$_POST['info'];
			$arr["Stime"]=strtotime($_POST['stimeM'].' '.$_POST['stimeD'].' '.$_POST['stimeY']);
			$arr["Etime"]=strtotime($_POST['etimeM'].' '.$_POST['etimeD'].' '.$_POST['etimeY']);
			$arr["Last"]=(int)($_POST['length'])*60;
			$this->load->model('r6_M/Onlinetestmodel');
			$this->Onlinetestmodel->create_exam($arr);
			$arr=array('txt'=>"Create successfully!");
			$this->load->view('r6_V/onlinetest/feedback', $arr);
			return;
		}
		$this->load->view('r6_V/onlinetest/error');
	}

/*
	selecttest function
	selecting paper for student
	get eid, pid to show paper
	using different format to show different kinds questions
	if student has been joined in the exam, show a message
*/
	function selecttest(){
		$this->load->helper('url');
		if ($_SERVER["REQUEST_METHOD"]=='POST'){
			$this->load->model('r6_M/Onlinetestmodel');
			$arr=array();
			$this->session->set_userdata('eid', $_POST['eid']);
			$arr['pid']=$this->Onlinetestmodel->get_pid($this->session->userdata['eid']);
			$this->session->set_userdata('pid', $arr['pid']);
			$arr=$this->Onlinetestmodel->get_ques($arr['pid']);
			$probs=explode(',', $arr[0]->QID_ARRAY);
			$arr['Title']=$this->Onlinetestmodel->get_info($this->session->userdata['eid']);
			$arry=array();
			foreach ($probs as $x){
				$text=$this->Onlinetestmodel->get_text($x);
				$ty = $this->Onlinetestmodel->get_type($x);
				$nod=array('text'=>$text, 'type'=>$ty);
				if ($ty != 'JUDGE'){
					$choi=$this->Onlinetestmodel->get_choice($x);
					$choi=explode('\\%%', $choi);
					$nod['choi']=$choi;
				};
				$arry[$x]=$nod;
			}
			$arr['probs']=$arry;
			$this->session->set_userdata('stime', time());
			$arr['tim']=$this->Onlinetestmodel->get_time($this->session->userdata['eid']);
			if ($this->Onlinetestmodel->check_eid_sid($this->session->userdata['eid'], $this->session->userdata['sid'])){
				$this->load->view('r6_V/onlinetest/Paper', $arr);
				return;
			}
			
			$txt='已经参与过考试';
			$arr=array('txt'=>$txt);
			$this->load->view('r6_V/onlinetest/feedback', $arr);
			
			return;
		}
		$this->load->view('r6_V/onlinetest/error');
	}

/*
	submitanswer function
	after examing, submiting the paper, mark the paper
	get the key of questions to mark
	insert the mark into database
	finally feedback.
*/
	function submitanswer(){
		if ($_SERVER["REQUEST_METHOD"]=='POST'){
			$this->load->model('r6_M/Onlinetestmodel');
			$tim=time()-$this->session->userdata('stime');
			$las=$this->Onlinetestmodel->get_time($this->session->userdata('eid'));
			$pid=$this->session->userdata('pid');
			$ques=$this->Onlinetestmodel->get_ques($pid);
			$probs=explode(',', $ques[0]->QID_ARRAY);
			$a=100;
			$b=array();
			foreach ($probs as $q){
				$k=$this->Onlinetestmodel->get_key($q);
				$p=$this->Onlinetestmodel->get_level($q);
				$ans = 0;
				$an=$_POST[$q];

/*
	decoding the answer to fit different questions.
*/
				for($i=0; $i<count($an); $i++){
					if ($an[$i]=='A') $ans+=1;
					if ($an[$i]=='B') $ans+=2;
					if ($an[$i]=='C') $ans+=4;
					if ($an[$i]=='D') $ans+=8;
					if ($an[$i]=='T') $ans+=16;
					if ($an[$i]=='F') $ans+=32;
				}
				if ($k!=$ans) {$a-=$p;
				$b[count($b)]=$q;}
			}
			$txt = '您在考试中得到'.$a.'分';
			
			$arr=array('txt'=>$txt);
			$this->load->view('r6_V/onlinetest/feedback', $arr);
			$arr=array('EID'=>(int)$this->session->userdata['eid']);
			$arr['SID']=$this->session->userdata['sid'];
			$arr['WA_ARRAY']=implode(',', $b);
			$arr['Score']=$a;
			$this->Onlinetestmodel->insert_score($arr);
			return;
		}
		$this->load->view('r6_V/onlinetest/error');
	}
}

?>
