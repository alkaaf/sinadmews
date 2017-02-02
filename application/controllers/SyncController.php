<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SyncController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        header('Content-Type: application/json');

    }

    public function getCustomer() {
        $param = array($this->input->post('idowner'));
        $token = $this->input->post('token');
        $waktu = $this->input->post('waktu');

        $res = $this->SyncModel->getCustomer($token, $param, $waktu);
        echo json_encode($res);
    }
    public function getAlamat() {
        $param = array($this->input->post('idowner'));
        $token = $this->input->post('token');
        $waktu = $this->input->post('waktu');

        $res = $this->SyncModel->getAlamat($token, $param, $waktu);
        echo json_encode($res);
    }
    public function getParfum() {
        $param = array($this->input->post('idowner'));
        $token = $this->input->post('token');
        $waktu = $this->input->post('waktu');

        $res = $this->SyncModel->getParfum($token, $param, $waktu);
        echo json_encode($res);
    }
    public function getLayanan() {
        $param = array($this->input->post('idoutlet'));
        $token = $this->input->post('token');
        $waktu = $this->input->post('waktu');

        $res = $this->SyncModel->getLayanan($token, $param, $waktu);
        echo json_encode($res);
    }
    public function getItem() {
        $param = array($this->input->post('idoutlet'));
        $token = $this->input->post('token');
        $waktu = $this->input->post('waktu');

        $res = $this->SyncModel->getItem($token, $param, $waktu);
        echo json_encode($res);
    }
}
