<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class t_menu_model extends CI_Model{
	function t_menu_model(){
		parent::__construct();
	}
	public function get_apply1(){//��ѯ���ſε����н�ѧ����Ϣ
		$DB_default=$this->load->database('default', TRUE);//load���ݿ�
		//ִ��sql��䣬��ѯ���ſε����н�ѧ����Ϣ��������ظ�$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN imsCourse USING (course_id) WHERE state=1');
		return $query->result_array();//���ؼ�¼����
		
	}
	public function get_apply2(){//��ѯ�ſγɹ������н�ѧ����Ϣ
		$DB_default=$this->load->database('default', TRUE);//load���ݿ�
		//ִ��sql��䣬��ѯ�ſγɹ������н�ѧ����Ϣ��������ظ�$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN classes USING (class_id) WHERE state=2');
		return $query->result_array();//���ؼ�¼����
		
	}
	public function get_apply5(){//��ѯ�ſγɹ������н�ѧ����Ϣ
		$DB_default=$this->load->database('default', TRUE);//load���ݿ�
		//ִ��sql��䣬��ѯ�ſγɹ������н�ѧ����Ϣ��������ظ�$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN classes USING (class_id) WHERE state=5');
		return $query->result_array();//���ؼ�¼����
		
	}
	public function get_apply3(){//��ѯ�����������н�ѧ����Ϣ
		$DB_default=$this->load->database('default', TRUE);//load���ݿ�
		//ִ��sql��䣬��ѯ�����������н�ѧ����Ϣ��������ظ�$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN classes USING (class_id) WHERE state=3');
		return $query->result_array();//���ؼ�¼����
	}
	public function get_apply4(){//��ѯ�ѱ�ɾ�������н�ѧ����Ϣ
		$DB_default=$this->load->database('default', TRUE);//load���ݿ�
		//ִ��sql��䣬��ѯ�ѱ�ɾ�������н�ѧ����Ϣ��������ظ�$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN imsCourse USING (course_id) WHERE state=4');
		return $query->result_array();//���ؼ�¼����
	}
	public function get_classroom()
	{
		$DB_default=$this->load->database('default', TRUE);
		$query=$DB_default->query('SELECT * FROM classroom');
		return $query->result_array();
	}
	public function check(){//����ܷ����course_id=$courseid�Ľ�ѧ��
	
		$result = 0;
		$DB_default=$this->load->database('default', TRUE);//load���ݿ�
		//�����Ƿ������ſγ�
		$query=$DB_default->query("SELECT * FROM imsCourse WHERE course_id=$_POST[courseid]");
		if ($query->num_rows() > 0);//�����result=0
		else return $result=1;//û��result=1
		/*$query=$DB_default->query("SELECT * FROM apply WHERE course_id=$_POST[courseid] and teacher_id=12345");
		if ($query->num_rows() > 0)
		return	$result=2;*/
		return $result;//����result
	}
	function addapply(){//��ӽ�ѧ��
		$DB_default=$this->load->database('default', TRUE);//load���ݿ�
		$result = $DB_default->query("insert into apply (course_id,teacher_id,date,state) 
			values('$_POST[courseid]',12345,now(),1)");//��apply�����һ�������¼��������ظ�result
		return $result;//���ز������ִ�н��
	}
}
//SELECT * FROM items INNER JOIN sales USING ( item_id );
