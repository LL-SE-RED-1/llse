<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//用于生成试卷
class Paper extends CI_Controller {
	
	
	/*function test()
	{
		$this->load->model("r6_M/Paper_model");
		$a=$this->Paper_model->user_select_question(1);
		var_dump($a);
		$str=$a[0]->QUESTION." ".$a[0]->CHOICE;
		
		echo $str;
	}*/
	function login()//临时登录界面
	{
		$this->load->helper('url');
		$this->load->library("session");
		$this->load->model("r6_M/Paper_model");
		$tid=$this->session->userdata("tid");
		$CID_str = $this->Paper_model->user_sel_cid($tid);
		//var_dump($CID_str);
		if($CID_str==null)
		{
			echo "题库中没有你添加的题！";
			$this->load->view('r6_V/paper/paper_head.php');
			$this->load->view('r6_V/welcome/Teacher');
		}
		else
		{
			for($i=0;$i<count($CID_str);$i++)
			{
				$CID_s[$i]=$CID_str[$i]->CID;
			}
			$CID_new_s=array_unique($CID_s);
			//var_dump($CID_new_s);
			$i=0;
			foreach ($CID_new_s as $x)
			{
				$CID_new_str[$i++]=$x;
			}	
			//var_dump($CID_new_str);
			$data=array("tid"=>$tid,"cid"=>$CID_new_str);
			$this->load->view('r6_V/paper/paper_head.php');
			$this->load->view("r6_V/paper/login.php",$data);
		}
		
	}
	
	function welcome()//一开始的欢迎界面
	{
		$this->load->library("session");
		$this->load->helper('url');
		//$session_data=array("tid"=>$_POST["tid"],"cid"=>$_POST["cid"]);
		$session_data=array("cid"=>$_POST["cid"]);
		$this->session->set_userdata($session_data);//将用户的tid和cid保存下来
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->view('r6_V/paper/paper_head.php');
		$this->load->view('r6_V/paper/paper_welcome.php');
		
	
		
	}
	
	
	function auto_generate()//自动生成试卷函数
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->model("r6_M/Paper_model");
		$this->load->library("session");
		$tid=$this->session->userdata("tid");
		$cid=$this->session->userdata("cid");//获取tid和cid
		//var_dump($_POST);//查看提交出来的东西
		//var_dump($_POST['exam_point']);
		$exam_point=$_POST;
		array_shift($exam_point);
		array_shift($exam_point);
		array_pop($exam_point);
		//var_dump($_POST);
		if(count($exam_point)==0)
		{
			echo "考查单元没有选择";
			$this->load->view('r6_V/paper/paper_head.php');
			$this->load->view('r6_V/paper/paper_welcome.php');
		}
		else
		{
			$QID_s=$this->Paper_model->user_select($tid,$cid,$_POST['level']);
		//从题库中选出符合条件的题出来
		//var_dump($QID_s);
		$c_number=$_POST['c_number'];
		$j_number=$_POST['j_number'];
		$level=$_POST['level'];
		
		$QID_j_sum=array();
		$QID_c_sum=array();
		for ($i=0,$k1=0,$k2=0;$i<count($QID_s);$i++)
			if($QID_s[$i]->TYPE=="JUDGE" && $this->Paper_model->exam_point_flag($QID_s[$i]->EXAM_POINT,$exam_point)==1)
			{
				$QID_j_sum[$k1]=$QID_s[$i]->QID;
				$k1++;
			}
			else if($QID_s[$i]->TYPE=="CHOICE" && $this->Paper_model->exam_point_flag($QID_s[$i]->EXAM_POINT,$exam_point)==1)
			{
				$QID_c_sum[$k2]=$QID_s[$i]->QID;
				$k2++;
			}
			
		/*for ($i=0,$k=0;$i<10;$i++)
		{
			$exam_point='exam_point'.$i;
			if($_POST[$exam_point]!=null)
			{
				$e_point_str[$k]=$_POST[$exam_point];
			}
				
		}*/
		//var_dump($e_point_str);
		//var_dump($QID_j_sum);
		//var_dump($QID_c_sum);
		$x_j=count($QID_j_sum)+1;
		$x_c=count($QID_c_sum)+1;
		$this->form_validation->set_rules('c_number', 'c_number', 'required|greater_than[-1]|less_than['.$x_c.']');
		$this->form_validation->set_rules('j_number', 'j_number', 'required|greater_than[-1]|less_than['.$x_j.']');
		$flag=$this->form_validation->run();
		
		//var_dump($_POST);
		
		/*$k=0;
		foreach ($x as $_POST)
		$exam_point[$k++]=$x;
		*/
		
		//判断提交的试题数是否大于0并且小于题库中的题数
		
		
		if ($flag == FALSE )
		{
			echo "题目数目不对！";
			$this->load->view('r6_V/paper/paper_head.php');
			$this->load->view('r6_V/paper/paper_welcome.php');
		}
		
		else
		{
			
			
			//$number=(int)($_POST["number"]);
		//echo $number;
			$QID_array_j_count=$this->Paper_model->unique_rand(0,count($QID_j_sum)-1,$j_number);//从选出来的题中随机题目生成试卷
			$QID_array_c_count=$this->Paper_model->unique_rand(0,count($QID_c_sum)-1,$c_number);
		
			for($i=0;$i<$j_number;$i++)
			{
				$QID_array[$i]=$QID_j_sum[$QID_array_j_count[$i]];
			}
			for($k=0;$k<$c_number;$k++)
			{
				$QID_array[$i++]=$QID_c_sum[$QID_array_c_count[$k]];
			}
			
			$str=implode(",",$QID_array);//将试卷题目id列表弄成字符串存起来
			//echo $str;
			
			$arr=array("TID"=>$tid,"CID"=>$cid,"QID_ARRAY"=>$str);
			$this->Paper_model->user_insert($arr);//将试卷的信息存到数据库中
			$i=0;
			foreach ($QID_array as $id)
			{
				$question_content=$this->Paper_model->user_select_question($id);//拿到每个题目id对应的题目内容
				if($question_content[0]->TYPE=="CHOICE")
				{
					$c=$question_content[0]->CHOICES;
					$xx=explode("\\%%",$c);
					
					$question_str[$i]="(".$question_content[0]->TYPE.")"." ".$question_content[0]->QUESTION." "."A.".$xx[0]." B.".$xx[1]." C.".$xx[2]." D.".$xx[3];
	
					
				}
				else
				{
					$question_str[$i]="(".$question_content[0]->TYPE.")"." ".$question_content[0]->QUESTION;
				}
				$i++;
				
			}
		
			$data=array("v_arr"=>$question_str);
			$this->load->view('r6_V/paper/paper_head.php');
			$this->load->view('r6_V/paper/paper_view.php',$data);//将刚刚的试卷的内容显示在页面中
			$this->load->view('r6_V/paper/return.php');
			
			}
		
		
		
		}
		
		
		
		
	}
	
	function manual_generate()//手动生成试卷函数
	{
		
		
		$this->load->model("r6_M/Paper_model");
		$this->load->helper('url');
		$this->load->library("session");
		$tid=$this->session->userdata("tid");
		$cid=$this->session->userdata("cid");//获取tid和cid
		
		$QID_s=$this->Paper_model->user_sel($tid,$cid);//从题库中选出符合条件的题出来
		
		for ($i=0;$i<count($QID_s);$i++)
			$QID_sum[$i]=$QID_s[$i]->QID;
		
		$i=0;
		foreach ($QID_sum as $id)
		{
			$question_content=$this->Paper_model->user_select_question($id);//拿到每个题目id对应的题目内容
			$question_id_str[$i]=$question_content[0]->QID;
			if($question_content[0]->TYPE=="CHOICE")
			{
				$c=$question_content[0]->CHOICES;
				$xx=explode("\\%%",$c);
					
				$question_content_str[$i]=$question_content[0]->QID." (".$question_content[0]->TYPE.")"." ".$question_content[0]->QUESTION." "."A.".$xx[0]." B.".$xx[1]." C.".$xx[2]." D.".$xx[3];
	
					
			}
			else
			{
				$question_content_str[$i]=$question_content[0]->QID." (".$question_content[0]->TYPE.")"." ".$question_content[0]->QUESTION;
			}
			/*$question_content_str[$i]=$question_content[0]->QID." (".$question_content[0]->TYPE.")"." ".$question_content[0]->QUESTION." ".$question_content[0]->CHOICES;*/
			
			$i++;
		}
		
		//将所有符合条件的题目显示在页面中
		$data=array("tid"=>$tid,"cid"=>$cid,"qid"=>$question_id_str,"content"=>$question_content_str);
		$this->load->view('r6_V/paper/paper_head.php');
		$this->load->view('r6_V/paper/good_question_view.php',$data);

		//由用户选择题目，将选择的信息送到生成试卷的函数中
		
	}
	
	function generate()//协助手动生成试卷
	{
		
		$this->load->model("r6_M/Paper_model");
		$this->load->helper('url');
		$this->load->library("session");
		$tid=$this->session->userdata("tid");
		$cid=$this->session->userdata("cid");//获取tid和cid
		
		if(count($_POST)==0)//判断是不是没有选题目
		{
			$this->load->view('r6_V/paper/paper_head.php');
			$this->load->view('r6_V/paper/no_question_select.php');
		}
		else
		{
			$str=implode(",",$_POST);
			$this->load->view('r6_V/paper/paper_head.php');
		$this->load->view('r6_V/paper/paper_generate.php');
		$arr=array("TID"=>$tid,"CID"=>$cid,"QID_ARRAY"=>$str);
		
		$this->Paper_model->user_insert($arr);//将刚刚提交的被选择的题目添加到数据库中
		
		$this->load->view('r6_V/paper/return.php');
		}
		
	}
	function check_paper()//查看历史试卷
	{
		$this->load->model("r6_M/Paper_model");
		$this->load->helper('url');
		$this->load->library("session");
		$tid=$this->session->userdata("tid");
		$cid=$this->session->userdata("cid");//获取tid和cid
		
		$PID_s=$this->Paper_model->user_sel_paper($tid,$cid);//拿出老师所出的试卷的id
		//var_dump($PID_s);
		for($i=0;$i<count($PID_s);$i++)
		{
			$PID_array[$i]=$PID_s[$i]->PID;
			
		}
		$data=array("pid"=>$PID_array);
		$this->load->view('r6_V/paper/paper_head.php');
		$this->load->view('r6_V/paper/history_paper.php',$data);
		
	}
	function change_paper()//选择了要查看的试卷后
	{
		$this->load->helper('url');
		$this->load->model("r6_M/Paper_model");
		$this->load->library("session");
		$tid=$this->session->userdata("tid");
		$cid=$this->session->userdata("cid");//获取tid和cid
		if(count($_POST)==0)
			$this->load->view('r6_V/paper/no_paper_select.php');
		else{
			$pid=$_POST['paper_id'];//获取选择的试卷id
		$paper_content=$this->Paper_model->get_paper($pid);
		//var_dump($paper_content);
		$question_strr=$paper_content[0]->QID_ARRAY;
		
		$QID_array=explode(',',$question_strr);
		//var_dump($QID_array);
		$i=0;
			foreach ($QID_array as $id)
			{
				$question_content=$this->Paper_model->user_select_question($id);//拿到每个题目id对应的题目内容
				if($question_content[0]->TYPE=="CHOICE")
				{
					$c=$question_content[0]->CHOICES;
					$xx=explode("\\%%",$c);
					
					$question_str[$i]="(".$question_content[0]->TYPE.")"." ".$question_content[0]->QUESTION." "."A.".$xx[0]." B.".$xx[1]." C.".$xx[2]." D.".$xx[3];
	
					
				}
				else
				{
					$question_str[$i]="(".$question_content[0]->TYPE.")"." ".$question_content[0]->QUESTION;
				}
				$i++;
				
			}
		
			$data=array("v_pid"=>$pid,"v_qid"=>$QID_array,"v_arr"=>$question_str);
			$this->load->view('r6_V/paper/paper_head.php');
			$this->load->view('r6_V/paper/paper_change.php',$data);//将刚刚的试卷的内容显示在页面中
			$this->load->view('r6_V/paper/return2.php');
			
		}
		
		
	}
	function del_paper_question()
	{
		//echo "hello"."...".$_GET['qid']."...".$_GET['pid'];
		//var_dump($qid);
		$this->load->helper('url');
		$this->load->model("r6_M/Paper_model");
		$this->load->library("session");
		$tid=$this->session->userdata("tid");
		$cid=$this->session->userdata("cid");//获取tid和cid
		
		$qid=$_GET['qid'];
		$pid=$_GET['pid'];
		
		$paper_content=$this->Paper_model->get_paper($pid);
		//var_dump($paper_content);
		$question=$paper_content[0]->QID_ARRAY;
		$question_arr=explode(',',$question);
		for($i=0,$j=0;$i<count($question_arr);$i++)
		{
			if($question_arr[$i] == $qid)
				;
			else{
				$new_question[$j++]=$question_arr[$i];
			}
		}
		$new_question_str=implode(",",$new_question);
		//echo $new_question_str;
		
		$this->Paper_model->update_paper($pid,$new_question_str);
		$this->load->view('r6_V/paper/paper_head.php');
		$this->load->view('r6_V/paper/paper_op.php');
		$this->load->view('r6_V/paper/return.php');
		
		
	}
	
	function add_paper_question()
	{
		$this->load->model("r6_M/Paper_model");
		$this->load->helper('url');
		$this->load->library("session");
		$tid=$this->session->userdata("tid");
		$cid=$this->session->userdata("cid");//获取tid和cid
		$pid=$_GET['pid'];
		$session_data=array("pid"=>$pid);
		$this->session->set_userdata($session_data);
		$QID_s=$this->Paper_model->user_sel($tid,$cid);//从题库中选出符合条件的题出来
		
		for ($i=0;$i<count($QID_s);$i++)
			$QID_sum[$i]=$QID_s[$i]->QID;
		
		$i=0;
		foreach ($QID_sum as $id)
		{
			$question_content=$this->Paper_model->user_select_question($id);//拿到每个题目id对应的题目内容
			$question_id_str[$i]=$question_content[0]->QID;
			if($question_content[0]->TYPE=="CHOICE")
			{
				$c=$question_content[0]->CHOICES;
				$xx=explode("\\%%",$c);
					
				$question_content_str[$i]=$question_content[0]->QID." (".$question_content[0]->TYPE.")"." ".$question_content[0]->QUESTION." "."A.".$xx[0]." B.".$xx[1]." C.".$xx[2]." D.".$xx[3];
	
					
			}
			else
			{
				$question_content_str[$i]=$question_content[0]->QID." (".$question_content[0]->TYPE.")"." ".$question_content[0]->QUESTION;
			}
			/*$question_content_str[$i]=$question_content[0]->QID." (".$question_content[0]->TYPE.")"." ".$question_content[0]->QUESTION." ".$question_content[0]->CHOICES;*/
			
			$i++;
		}
		
		//将所有符合条件的题目显示在页面中
		$data=array("tid"=>$tid,"cid"=>$cid,"qid"=>$question_id_str,"content"=>$question_content_str);
		$this->load->view('r6_V/paper/paper_head.php');
		$this->load->view('r6_V/paper/add_question_view.php',$data);
	}
	function add()
	{
		$this->load->model("r6_M/Paper_model");
		$this->load->helper('url');
		$this->load->library("session");
		$tid=$this->session->userdata("tid");
		$cid=$this->session->userdata("cid");//获取tid和cid
		$pid=$this->session->userdata("pid");
		if(count($_POST)==0)//判断是不是没有选题目
		{
			$this->load->view('r6_V/paper/paper_head.php');
			$this->load->view('r6_V/paper/no_question_add.php');
		}
		else
		{
			$str=implode(",",$_POST);
			$paper_content=$this->Paper_model->get_paper($pid);
			//var_dump($paper_content);
			$question_strr=$paper_content[0]->QID_ARRAY;
			$new_question_str=$question_strr.",".$str;
		$this->load->view('r6_V/paper/paper_head.php');
		$this->load->view('r6_V/paper/paper_op.php');
		
		
		$this->Paper_model->update_paper($pid,$new_question_str);
		$this->load->view('r6_V/paper/return.php');
		}
		
	}
	
}




















