<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class r3_Excel {
	public $filename 		= 'excel-doc';
	public $custom_titles;
	public function make_from_db($db_results) {
		$data 		= NULL;
		$fields 	= $db_results->field_data();
		if ($db_results->num_rows() == 0) {
			show_error('The table appears to have no data');
		}
		else {
			$headers = $this->titles($fields);
			foreach ($db_results->result() AS $row) {
				$line = '';
				foreach ($row AS $value) {
					if (!isset($value) OR $value == '') {
						$value = "\t";
					}
					else {
						$value = str_replace('"', '""', $value);
						$value = '"' . $value . '"' . "\t";
					}
					$line .= $value;
				}
				$data .= trim($line) . "\n";
			}
			$data = str_replace("\r", "", $data);
			$this->generate($headers, $data);
		}
	}
	public function make_from_array($titles, $array) {
		$data = NULL;
		if (!is_array($array)) {
			show_error('The data supplied is not a valid array');
		}
		else {
			$headers = $this->titles($titles);
			if (is_array($array)) {
				foreach ($array AS $row) {
					$line = '<tr>';
					foreach ($row AS $value) {
						if (!isset($value) OR $value == '') {
							$value = "<td></td>";
						}
						else {
							$value = str_replace('"', '""', $value);
							$value = '<td>' . $value . '</td>';
						}
						$line .= $value;
					}
					$data .= trim($line) . '</tr>';
				}
				$this->generate($headers, $data);
			}
		}
	}

	public function make_from_string($string) {
		$this->generatestr($string);
	}
	private function generate($headers, $data) {
		$this->set_headers();
		echo '
			 <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"> 
			 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
			 <html> 
			     <head> 
			        <meta http-equiv="Content-type" content="text/html;charset=UTF-8" /> 
			         <style id="Classeur1_16681_Styles"></style> 
			     </head> 
			     <body> 
			         <div id="Classeur1_16681" align=center x:publishsource="Excel"> 
				<table x:str border=0 cellpadding=0 cellspacing=0 style="border-collapse: collapse"><thead><tr>';
		echo '<th>'.$headers.'</th></tr></thead>';
		echo '<tbody>'.$data.'</tbody></table></div></body></html>';  
	}
	private function generatestr($string) {
		$this->set_headers();
		echo '
			 <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"> 
			 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
			 <html> 
			     <head> 
			        <meta http-equiv="Content-type" content="text/html;charset=UTF-8" /> 
			         <style id="Classeur1_16681_Styles"></style> 
			     </head> 
			     <body> 
			         <div id="Classeur1_16681" align=center x:publishsource="Excel"> 
				<table x:str border=0 cellpadding=0 cellspacing=0 style="border-collapse: collapse">';
		echo $string;
		echo '</table></div></body></html>';  
	}
	public function titles($titles) {
		if (is_array($titles)) {
			$headers = array();
			if (is_null($this->custom_titles)) {
				if (is_array($titles)) {
					foreach ($titles AS $title) {
						$headers[] = $title;
					}
				}
				else {
					foreach ($titles AS $title) {
						$headers[] = $title->name;
					}
				}
			}
			else {
				$keys = array();
				foreach ($titles AS $title) {
					$keys[] = $title->name;
				}
				foreach ($keys AS $key) {
					$headers[] = $this->custom_titles[array_search($key, $keys)];
				}
			}
			return implode("</th><th>", $headers);
		}
	}
	private function set_headers() {
		header("Pragma: public");
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");;
	    header("Content-Disposition: attachment;filename=$this->filename.xls");
	    header("Content-Transfer-Encoding: binary ");
	}
}