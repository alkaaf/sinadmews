<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ResultBuilder extends CI_Model {
    private $data;
    public function __construct() {
        parent::__construct();
        $this->data['success'] = false;
        $this->data['message'] = "";
        $this->data['data'] = null;
        $this->data['row'] = null;
    }
    public function setSuccess($var) {
        $this->data['success'] = $var;
    }
    public function setMessage($var) {
        $this->data['message'] = $var;
    }
    public function setData($var) {
        $this->data['data'] = $var;
    }
    public function setRow($var) {
        $this->data['row'] = $var;
    }

    public function getResult() {
        return $this->data;
    }
}
