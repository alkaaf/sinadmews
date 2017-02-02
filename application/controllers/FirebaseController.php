<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FirebaseController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('AlkaafEmoney');
    }

    public function updateToken()
    {
        $token = $this->input->post('token');

        $param = array(
            $this->input->post('idkaryawan'),
            $this->input->post('firebasetoken')
        );

        $res = $this->FirebaseModel->setUpdateToken($token, $param);
        echo json_encode($res);
    }

    public function gettime()
    {
        echo time();
    }
}
