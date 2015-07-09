<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Richard
 * 
 * 成绩管理子系统的公用model
 * 提供按照预定义的API格式输出数据的功能
 * 主要分为数据正确输出和错误输出两种
 * defined in : https://github.com/richard1122/Score_Management_Subsystem/blob/master/Backend.md
 */
class Scorecommon_model extends CI_Model {
    private $err = 'common error';

    function __construct() {
        date_default_timezone_set('Asia/Shanghai');
    }

    /**
     * output correct data (code = 0)
     * @param any[$data] data to be output. this param will be json encoded.
     */
    public function success($data = NULL) {
        $this->output->set_content_type('application/json');
        echo json_encode(array(
            'code' => 0,
            'data' => $data
            ));
    }

    /**
     * output error to frontend (code = 1)
     * @param string[$msg] error string, should be human-readable.
     */
    public function error($msg = NULL) {
        if ($msg === NULL) $msg = $this->err;
        $this->output->set_content_type('application/json');
        echo json_encode(array(
            'code' => 1,
            'msg'  => $msg
            ));
    }

    /**
     * set error content, maybe used in other models
     * @param string[$msg] error tobe printed to end users
     */
    public function set_error($msg) {
        $this->err = $msg;
    }

    /**
     * calculate grade based on score.
     * @param integer[$score] score in [0, 100]
     * @param boolean[$isAbsent] whether this student is absent
     * @return grade in float [0.0, 5.0] or false if failed
     */
    public function calculateGrade($score, $isAbsent) {
        $score = (int) $score;
        if ($isAbsent === true || $isAbsent === 'true') {
            $score = 0;
            return 0;
        }
        if ($score > 100 || $score < 0) return FALSE;

        if ($score < 60) return 0.0;
        if ($score >= 95) return 5.0;
        return ($score - 60) / 10.0 + 1.5;
    }
}

/* End of file scoreCommonModel.php */
/* Location: ./application/models/scoreCommonModel.php */