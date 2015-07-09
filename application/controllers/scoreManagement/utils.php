<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utils extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('r7/ScoreCommon_model', 'scoreCommon');
    }
}

/* End of file utils.php */
/* Location: ./application/controllers/utils.php */