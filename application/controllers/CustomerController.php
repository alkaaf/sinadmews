<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('AlkaafEmoney');
    }

    public function customerAdd()
    {
        $token        = $this->input->post('token');
        $param        = array(
            $this->input->post('idowner'),
            $this->input->post('telp'),
            $this->input->post('namacustomer')
        );
        $res = $this->CustomerModel->inputCustomer($token, $param);
        echo json_encode($res);
    }

    public function alamatAdd()
    {
        $token      = $this->input->post('token');
        $param = array(
            $this->input->post('idcustomer'),
            $this->input->post('alamat')
        );
        $res = $this->CustomerModel->updateAlamat($token, $param);
        echo json_encode($res);
    }

    public function customerEdit()
    {
        $token        = $this->input->post('token');
        $param        = array(
            $this->input->post('telp'),
            $this->input->post('namacustomer'),
            $this->input->post('idcustomer'),
        );
        $res = $this->CustomerModel->editCustomer($token, $param);
        echo json_encode($res);
    }


    public function alamatEdit()
    {
        $token        = $this->input->post('token');
        $param        = array(
            $this->input->post('idcustomer'),
            $this->input->post('alamat'),
            $this->input->post('idalamat'),
        );
        $res = $this->CustomerModel->editAlamat($token, $param);
        echo json_encode($res);
    }

    public function gettime()
    {
        echo time();
    }
}
