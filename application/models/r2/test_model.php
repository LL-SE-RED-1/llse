<?php
class Test_model extends CI_Model {
/*构造函数*/
  function Test_model()
  {
    parent::__construct();
  }
  function value(){
  	$sche = array('M' => 63,'T'=>5, 'W'=>4 );
  	return $sche;
  }
}