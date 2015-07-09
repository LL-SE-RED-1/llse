<?php
class Questions extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library('javascript');
    $this->load->library('session');
    $this->load->model('r6_M/question_model');
    $this->load->helper('url');

  }
  public function delete(){							//删除问题
  	  $this->load->library('form_validation');
	  $this->form_validation->set_rules('QID', 'question ID', 'required');
	  $data['library_src'] = $this->jquery->script();
	  $data['title'] = '删除测试题';

	  if ($this->form_validation->run() === FALSE)	//获取信息失败，返回
	  {
	  	$this->load->view('r6_V/questions/notdone_reload', $data);	//加载页面
	  	$this->load->view('r6_V/questions/failure');
	  	 
	  }
	  else             								//删除问题
	  {
	    $this->question_model->delete_questions();	//删除
		
		$this->load->view('r6_V/questions/com_header');
		$this->load->view('r6_V/questions/done_delete_header', $data);
		$this->load->view('r6_V/questions/nav', $data);
		$this->load->view('r6_V/questions/done_delete', $data);
	     
	  }

  }

  public function index()
  {
  	$this->load->helper('form');
  	$this->load->library('pagination');

  	$config['base_url'] = base_url().'index.php/r6_C/questions/index';
  	//$config['total_rows'] = $this->db->count_all('QUESTION');	//自动从数据库中取得total_row信息
	$config['per_page'] = 5; 								//每页显示的数据数量
    $data['title'] = '测试题列表';
    
    $this->load->library('table');							//加载表格类
	//$query=$this->db->get('QUESTION',$config['per_page'],$this->uri->segment(4));
	if ($this->uri->segment(4)=='') {					//如果分页为空，默认设为第一页
		$page_num = 0;
	}
	else
		$page_num = $this->uri->segment(4);					//否则按照url解析读取页码

	$sql = "SELECT * FROM `R6_QUESTION` WHERE TID =".$this->session->userdata('tid')." LIMIT ".$page_num.", ".$config['per_page'];
	$count_sql = "SELECT COUNT(*) AS NUM FROM `R6_QUESTION` WHERE TID = ".$this->session->userdata('tid');
	//per_page告诉此次sql查询限制数量,uri_segment告诉此次查询的偏移量(从哪一行数据开始查询).
	$query = $this->db->query($sql);						//获取查询结果
	$count_query = $this->db->query($count_sql)->row();		//获取count结果
	$config['total_rows'] = $count_query->NUM;				//count数字

	$data['questions'] = $query->result_array();			//问题列表
    $data['library_src'] = $this->jquery->script();			//js库地址
    
	$config['num_links'] = 3;								//分页器设置
    $config['num_tag_open'] = '&nbsp;';						//数字页码打开标签
	$config['num_tag_close'] = '';							//数字页码关闭标签
	$config['cur_tag_open'] = '&nbsp;<b>';					//当前页打开标签
	$config['cur_tag_close'] = '</b>';						//当前页关闭标签
	$config['next_link'] = '下一页';							//分页中显示“下一页”链接的名字
	$config['next_tag_open'] = '&nbsp;';					//“下一页”链接的打开标签
	$config['next_tag_close'] = '';							//“下一页”链接的关闭标签
	$config['prev_link'] = '上一页';							//上一页链接
	$config['prev_tag_open'] = '&nbsp;';					//上一页链接的打开标签
	$config['prev_tag_close'] = '';							//上一页标签的关闭标签
	$config['first_link'] = '首页';							//首页标签
	$config['last_link'] = '&nbsp;末页';						//末页标签
	$this->pagination->initialize($config); 				//设置完成分页器

    $data['links'] = $this->pagination->create_links().'<hr>';//显示分页器
	
	$this->load->view('r6_V/questions/com_header', $data);
    $this->load->view('r6_V/questions/index_header', $data);	//显示页面
    $this->load->view('r6_V/questions/nav', $data);
	$this->load->view('r6_V/questions/index_extra', $data);
	$this->load->view('r6_V/questions/index', $data);
     
	
  }

  public function view()
  {
	  $config['enable_query_strings'] = TRUE;				//允许query_url
	  $this->load->helper('form');							//表单帮助类
	  //$this->load->library('form_validation');
	  $data['title'] = '搜索测试题';							//页面标题
	  $data['library_src'] = $this->jquery->script();		//js库地址
	  $data['tid'] = $this->session->userdata('tid');		//获取session
	  //$this->form_validation->set_rules('KEYWORD', 'KEYWORD', 'required');

	  //if ($this->form_validation->run() === FALSE)
	  if ($this->input->get('KEYWORD') == null)				//搜索关键字为空
	  {
	  	$data['links'] = NULL;
	  	$data['res'] = NULL;
	  	$data['search_res'] = NULL;
		$this->load->view('r6_V/questions/com_header', $data);
	    $this->load->view('r6_V/questions/view_header', $data);  	//加载页面
		$this->load->view('r6_V/questions/nav', $data);
		$this->load->view('r6_V/questions/view');  
	     
	    
	  }
	  else
	  {
	  	$token = $this->input->get('submit');
	  	$page_num = $this->input->get('offset');				//获取分页页码，如果为空，设为0
	  	if (empty ( $page_num )) {
			$page_num = 0;
		}
		$offset = $this->input->get ( 'offset' );				//获取分页页码

		$config['page_query_string'] = TRUE;					//允许query url
		$this->load->helper('form');
	  	$this->load->library('pagination');

	  	$config['base_url'] = base_url().'index.php/r6_C/questions/view?KEYWORD='.$this->input->get('KEYWORD').'&SEARCH='.$this->input->get('SEARCH').'&submit=SEARCH';
	  	

		$config['per_page'] = 5; 						//每页显示的数据数量
		$config['query_string_segment'] = 'offset';		//设置分页字段

		if($this->input->get('SEARCH') == 'ID'){		//搜索数据库
			if (is_numeric( $this->input->get('KEYWORD') )) {
				$sql = "SELECT * FROM `R6_QUESTION` WHERE QID = ".$this->input->get('KEYWORD')." AND TID =".$this->session->userdata('tid')." LIMIT ".$page_num.", ".$config['per_page'];
				//$sql = "SELECT * FROM `R6_QUESTION` WHERE QID = ".$this->input->get('KEYWORD');
				$count_sql = "SELECT COUNT(*) AS NUM FROM `R6_QUESTION` WHERE QID = ".$this->input->get('KEYWORD')." AND TID =".$this->session->userdata('tid');
			}
		}
		else{
			$sql = "SELECT * FROM `R6_QUESTION` WHERE TID =".$this->session->userdata('tid')." AND (QUESTION like '%".$this->input->get('KEYWORD')."%' OR CHOICES like '%".$this->input->get('KEYWORD')."%') LIMIT ".$page_num.", ".$config['per_page'];
			$count_sql = "SELECT COUNT(*) AS NUM FROM `R6_QUESTION` WHERE TID =".$this->session->userdata('tid')." AND (QUESTION like '%".$this->input->get('KEYWORD')."%' or CHOICES like '%".$this->input->get('KEYWORD')."%')";
		}

		$query = $this->db->query($sql);				//SQL结果
		$count_query = $this->db->query($count_sql)->row();	//计数结果
		//echo $sql;
		$config['total_rows'] = $count_query->NUM;			//总条目数
		if ($config['total_rows'] == 0) {					//如果没有相应条目
			$data['search_res'] = "没有对应的条目";
		}
		else
			$data['search_res'] = null;

		$data['questions'] = $query->result_array();		//设置分页器样式
	    $data['library_src'] = $this->jquery->script();		//js库文件

		$config['num_links'] = 3;							//以下为设置分页，详见index函数
	    $config['num_tag_open'] = '&nbsp;';
		$config['num_tag_close'] = '';
		$config['cur_tag_open'] = '&nbsp;<b>';
		$config['cur_tag_close'] = '</b>';
		$config['next_link'] = '下一页';
		$config['next_tag_open'] = '&nbsp;';
		$config['next_tag_close'] = '';
		$config['prev_link'] = '上一页';
		$config['prev_tag_open'] = '&nbsp;';
		$config['prev_tag_close'] = '';
		$config['first_link'] = '首页';
		$config['last_link'] = '&nbsp;末页';

		$this->pagination->initialize($config); 			//设置完成分页器

	    $data['links'] = $this->pagination->create_links().'<hr>';//显示分页器
		$data['res'] = "搜索结果";
		
		$this->load->view('r6_V/questions/com_header', $data);
	    $this->load->view('r6_V/questions/view_header', $data);  	//加载页面
		$this->load->view('r6_V/questions/nav', $data);
		$this->load->view('r6_V/questions/view');  
		$this->load->view('r6_V/questions/index', $data);
	     
	  }

}

  public function create()
{
  $this->load->helper('form');										//创建测试题
  $this->load->library('form_validation');
  $data['title'] = '创建测试题';
  $data['tid'] = $this->session->userdata('tid');					//获取session数据

  $this->form_validation->set_rules('CID', '选择一门课程', 'required');	//设置文本域必须填写，表单验证规则
  $this->form_validation->set_rules('TID', '教师ID', 'required');
  $this->form_validation->set_rules('QUESTION', '问题内容', 'required');
  $this->form_validation->set_rules('TYPE', '问题类型', 'required');
  $this->form_validation->set_rules('KEY[]', '问题答案', 'required');
  $this->form_validation->set_rules('EXAM_POINT', '考察单元', 'required|numeric');
  $this->form_validation->set_rules('LEVEL', '难度', 'required|numeric');

  if ($this->input->post('TYPE') == 'CHOICE' || $this->input->post('TYPE') == 'MULTICHOICE') {
  	$this->form_validation->set_rules('SELECT_A', '选项A', 'required');
  	$this->form_validation->set_rules('SELECT_B', '选项B', 'required');
  	$this->form_validation->set_rules('SELECT_C', '选项C', 'required');
  	$this->form_validation->set_rules('SELECT_D', '选项D', 'required');
  }
  
  $data['library_src'] = $this->jquery->script();
  $this->load->model('r2/search_model');
  $info = array('teacher_id'=>$this->session->userdata['tid']);
  $data['cous']=$this->search_model->classinfo($info);
  if ($this->form_validation->run() == FALSE)			//有项目未填写
  {
    $this->load->view('r6_V/questions/com_header');
    $this->load->view('r6_V/questions/create_header', $data);  //加载页面
	$this->load->view('r6_V/questions/nav', $data);
    $this->load->view('r6_V/questions/create', $data);
    
  }
  else//填写完整
  {
    $this->question_model->set_questions();					//加载页面
	
	$this->load->view('r6_V/questions/com_header');
	$this->load->view('r6_V/questions/done_create_header', $data);
	$this->load->view('r6_V/questions/nav', $data);
    $this->load->view('r6_V/questions/done_create', $data);
     
  }
}

  public function edit_show()
{
	$this->load->helper('form');
	$this->load->library('form_validation');
	$data['title'] = '编辑测试题';
	$data['library_src'] = $this->jquery->script();


	$query=$this->db->get_where('R6_QUESTION', array('QID' => $this->input->post('QID')));
	$one = $query->result_array();

	if ($one['0']['TYPE'] == 'CHOICE' || $one['0']['TYPE'] == 'MULTICHOICE') {		
		$token = strtok($one['0']['CHOICES'], "\\%%");
		$one['0']['SELECT_A'] = $token;
		$token = strtok("\\%%");		
		$one['0']['SELECT_B'] = $token;
		$token = strtok("\\%%");
		$one['0']['SELECT_C'] = $token;
		$token = strtok("\\%%");
		$one['0']['SELECT_D'] = $token;

	}
	else{
		$one['0']['SELECT_A'] = "";
		$one['0']['SELECT_B'] = "";
		$one['0']['SELECT_C'] = "";
		$one['0']['SELECT_D'] = "";
	}
	$data['questions_item'] = $one['0'];
	//$this->load->library('table');//加载表格类
	//echo $this->table->generate($query);//显示查询到的数据
	
	  $data['library_src'] = $this->jquery->script();
	  $this->load->model('r2/search_model');
	  $info = array('teacher_id'=>$this->session->userdata['tid']);
	  $data['cous']=$this->search_model->classinfo($info);
	
	$this->load->view('r6_V/questions/com_header');
	$this->load->view('r6_V/questions/edit_header', $data);  
	$this->load->view('r6_V/questions/nav', $data);
	$this->load->view('r6_V/questions/edit', $data);
	 

}

  public function edit()
{
  $this->load->helper('form');
  $this->load->library('form_validation');
  $data['title'] = '编辑测试题';
  $data['library_src'] = $this->jquery->script();
  $this->form_validation->set_rules('CID', '选择一门课程', 'required');	//设置文本域必须填写
  $this->form_validation->set_rules('TID', '教师ID', 'required');
  $this->form_validation->set_rules('QUESTION', '问题内容', 'required');
  $this->form_validation->set_rules('KEY[]', '问题答案', 'required');
  $this->form_validation->set_rules('TYPE', '问题类型', 'required');
  if ($this->input->post('TYPE') == 'CHOICE' || $this->input->post('TYPE') == 'MULTICHOICE') {
  	$this->form_validation->set_rules('SELECT_A', '选项A', 'required');
  	$this->form_validation->set_rules('SELECT_B', '选项B', 'required');
  	$this->form_validation->set_rules('SELECT_C', '选项C', 'required');
  	$this->form_validation->set_rules('SELECT_D', '选项D', 'required');
  }
  
  if ($this->form_validation->run() === FALSE)				//表单验证不通过
  {
  	$query=$this->db->get_where('R6_QUESTION', array('QID' => $this->input->post('QID')));
	$one = $query->result_array();							//获取数据库信息以重新填充

	if ($one['0']['TYPE'] == 'CHOICE' || $one['0']['TYPE'] == 'MULTICHOICE' ) {					
		$token = strtok($one['0']['CHOICES'], "\\%%");		//解析条目
		$one['0']['SELECT_A'] = $token;
		$token = strtok("\\%%");		
		$one['0']['SELECT_B'] = $token;
		$token = strtok("\\%%");
		$one['0']['SELECT_C'] = $token;
		$token = strtok("\\%%");
		$one['0']['SELECT_D'] = $token;

	}
	else{
		$one['0']['SELECT_A'] = "";
		$one['0']['SELECT_B'] = "";
		$one['0']['SELECT_C'] = "";
		$one['0']['SELECT_D'] = "";
	}
	$data['questions_item'] = $one['0'];					//重新填充
	
	$this->load->view('r6_V/questions/com_header');
	$this->load->view('r6_V/questions/edit_header', $data);  
	$this->load->view('r6_V/questions/nav', $data);
	$this->load->view('r6_V/questions/edit', $data);
    
  }
  else
  {
    $this->question_model->edit_questions();				//加载页面
    $this->load->view('r6_V/questions/com_header');
	$this->load->view('r6_V/questions/done_edit_header', $data);
	$this->load->view('r6_V/questions/nav', $data);
    $this->load->view('r6_V/questions/done_edit', $data);
     
  }
}
}
