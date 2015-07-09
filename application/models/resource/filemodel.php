<?php
class FIleModel extends CI_Model{
	//指定文件夹位置
	static $desfolder = "saves";
	//指定输入的域
	static $field = "file";
	/**
	 *构造函数
	 *确保存储文件的文件夹已建好
	 *统一加载data模块
	 */
	function __construct()
  {
		if (!file_exists(self::$desfolder))
			mkdir(self::$desfolder, 0766);
		
		$this->load->model('datamodel');
    parent::__construct();
  }
	
	/**
	 *上传课件和共享资料文件
	 *@params 课程id 上传者用户id
	 *@return 上传的文件id
	 */
	function upload_course_file($courseid, $uploader){
		//将实际文件放在存储的文件夹下，并确保数据库有该文件信息
		$fileid = $this->upload_file(self::$field);
		//如果该课程下已经有该文件，则直接@return
		if (count($this->datamodel->get_course_file($courseid, $fileid)) > 0)
			return $fileid;
		//在数据库中添加该文件信息
		$this->datamodel->add_course_file($courseid, $fileid, $uploader, date("Y-m-d H:i:s"), $_FILES[self::$field]["name"]);
		return $fileid;
	}
	
	/**
	 *上传作业相关文件
	 *@params 作业id
	 *@return 上传的文件id
	 */
	function upload_homework_file($homeworkid){
		//将实际文件放在存储的文件夹下，并确保数据库有该文件信息
		$fileid = $this->upload_file(self::$field);
		//如果该作业下已经有该相关文件，则直接@return
		if (count($result = $this->datamodel->get_homework_file($homeworkid)) > 0){
			for ($i = 0; $i != count($result); ++$i){
				if ($result[$i]["fileid"] === $fileid)
					return $fileid;
			}	
		}
		//在该作业中添加该文件信息
		$this->datamodel->add_homework_file($homeworkid, $fileid, $_FILES[self::$field]["name"]);
		return $fileid;
	}
	
	/**
	 *上传学生作业
	 *@params 学生id 作业id
	 *@return 上传的文件id
	 */
	function upload_homework_student($studentid, $homeworkid){
		//将实际文件放在存储的文件夹下，并确保数据库有该文件信息
		$fileid = $this->upload_file(self::$field);
		$hw = $this->datamodel->get_homework_student($studentid, $homeworkid);
		//如果该学生不是第一次上传作业，则更新数据库覆盖之前的作业
		//否则添加一条数据库信息
		if (count($hw) > 0)
		$this->datamodel->update_homework_student($studentid, $homeworkid, $fileid, $_FILES[self::$field]["name"], date("Y-m-d H:i:s"), null, null, true);
		else 
		$this->datamodel->add_homework_student($studentid, $homeworkid, $fileid, $_FILES[self::$field]["name"], date("Y-m-d H:i:s"), null, null, false);
			
		return $fileid;
	}
	
	/**
	 *上传文件
	 *@params get请求的变量域
	 *@return 上船后的文件id
	 *备注 所有上传文件的函数都需要调用该函数来实现上传文件的过程
	 */
	function upload_file($field){
		//得到已经上传到服务器的文件实际位置和文件大小
		$filename = $_FILES[$field]['tmp_name'];
		$filesize = $_FILES[$field]["size"];
		
		//将文件内容通过md5 hash之后加上文件大小，作为存储时的文件名
		$actualsuffix = md5_file($filename).$filesize;
		$actualname = self::$desfolder."/".$actualsuffix;
		//如果已经上传过该文件
		if (file_exists($actualname)){
		//从数据库中得到该文件id 并@return
		//如果数据库中不存在该文件则抛出异常
			$detail = $this->datamodel->get_file_by_name_and_size($actualsuffix, $filesize);
			if (count($detail) == 0){
				show_error("数据库与本地文件数据不一致");
				return $this->datamodel->add_file_detail($actualname, $filesize);	
			}
			//删除已上传的临时文件
			unlink($filename);
			return $detail[0]["id"];
		}
		else{
			//否则将临时文件移动到存储文件夹下
			rename($filename, $actualname);
			return $this->datamodel->add_file_detail($actualsuffix, $filesize);
		}
	}
	
	/**
	 *下载文件文件
	 *@params fileid filename 
	 *@return null
	 */
	function download_file($fileid, $filename){
		//查看文件具体信息
		$this->load->helper("download");
		$detail = $this->datamodel->get_file_detail($fileid)[0];
		//如果数据库中不存在该文件
		if (count($detail) == 0)
			return null;
		$actualname = $detail["actualname"];
		
		$data = file_get_contents(self::$desfolder.'/'.$actualname);
		force_download($filename, $data);
	}
}

?>