<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KeuanganController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('AlkaafEmoney');
    }

    public function daftarBiayaOpOutlet()
    {
        $token = $this->input->post('token');

        $param = array(
            $this->input->post('idoutlet'),
            $this->input->post('firebasetoken')
        );

        $res = $this->KeuanganModel->getBiayaOpOutlet($token, $param);
        echo json_encode($res);
    }

    public function gettime()
    {
        echo time();
    }
}