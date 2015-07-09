<?php
class Ta_model extends CI_Model
{
	public function __construct()
  {
    $this->load->database();
  }
  public function get_data($id)//根据teacher ID返回教师出过的exam中有成绩的EID数据
 {
	 //$sql='select * from R6_EXAM';
	 $sql="select distinct EID,INFO from R6_EXAM inner join 
		R6_SCORE using (EID) where TID=$id";
	$query = $this->db->query($sql);
	return $query->result_array();
 }
 public function get_sdata($id)//返回查询数据库请求，学生的考试过的成绩
 {
	$sql="select distinct EID,INFO,SCORE from R6_EXAM inner join 
		R6_SCORE using (EID) where SID=$id";
	$query = $this->db->query($sql);
	return $query->result_array();	
 }
 public function get_ans($id)//返回数据库请求，生成错题分析表格，显示该错题的有几人答错
	{
		$sql="select WA_ARRAY from `R6_SCORE` where EID=$id";
		$query = $this->db->query($sql);
		$a=array();
		foreach($query->result_array() as $question)
		{
			if(!empty($question)){
				$a=$this->Ta_model->calculate($question['WA_ARRAY'],$a);
			}
		}
		return $a;
	}
	public function get_sc($id)//返回数据库请求
	{
		$sql="select Score from `R6_SCORE` where EID=$id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function setarray($q,$a)//统计各个题型出错的次数
	{	
		//////////////////////
		$sql="select TYPE, LEVEL, EXAM_POINT from `R6_QUESTION` where QID=$q";
		$query = $this->db->query($sql);
		if($query!=null){
		foreach($query->result_array() as $question)
		{
			if(!empty($question)){
				for($i=0;$i<count($a);$i++){//已存在该题
					//echo "$a[$i][0] and $q <br>";
					if($a[$i][0]==$q){
						//$a[$i][1]=question['TYPE'];
						//$a[$i][2]=question['LEVEL'];
						//$a[$i][3]=question['EXAM_POINT'];
						$a[$i][4]++;
						return $a;
					}
				}
			}
			
			array_push($a,array($q,$question['TYPE'],$question['LEVEL'],$question['EXAM_POINT'],1));
		}
		
		
		}
		return $a;
		
		/////////////////////
		/*if(empty($a[$q]))//若数组中从未出现该题目，则扩展数组
		{
			return $a+array($q=>1);
		}
		else $a[$q]++;//否则该题目数量+1
		return $a;*/
	}
	public function calculate($question,$a)//显示各个题型出错概率表格
	{
		$start=0;
		while(true)
		{
			$end = stripos($question,',',$start);//根据特殊字符查找题目
			if($end==false)//最后一个题目特殊处理
			{
				$q = substr($question,$start,strlen($question)-$start);
				//题号
				$a= $this->Ta_model->setarray($q, $a);
				break;
			}
			$q = substr($question,$start,$end-$start);//找到题号
			$a= $this->Ta_model->setarray($q, $a);//统计错题出现次数
			$start=$end+1;
		}
		return $a;
	}
}
?>