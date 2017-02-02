<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WorkshopController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('AlkaafEmoney');
    }

    public function daftarWorkshop()
    {
        $token = $this->input->post('token');

        $param = array($this->input->post('idowner'));

        $res = $this->WorkshopModel->getWorkshop($token, $param);

        echo json_encode($res);
    }

    public function setSuratKirim()
    {
        $token        = $this->input->post('token');
        $param_surat = array(
            $this->input->post('idsurat'),
            $this->input->post('idkasir'),
            $this->input->post('idkurir'),
            $this->input->post('idoutlet'),
            $this->input->post('idworkshop'),
            $this->input->post('tanggal_kirim'),
            $this->input->post('keterangan'),
        );
        $res = $this->WorkshopModel->suratKirim($token, $param_surat);
        echo json_encode($res);
    }

    public function setPenerimaSurat()
    {
        $token        = $this->input->post('token');
        $param_surat = array(
            $this->input->post('idkaryawanworkshop'),
            $this->input->post('tanggal_terima'),
            $this->input->post('idsurat')
        );
        $res = $this->WorkshopModel->penerimaSurat($token, $param_surat);
        echo json_encode($res);
    }

    public function setDaftarNotaKirim()
    {
        $token      = $this->input->post('token');
        $param_nota = array(
            $this->input->post('idsurat'),
            $this->input->post('idworkshop'),
            $this->input->post('idtransaksi')
        );
        $res = $this->WorkshopModel->daftarNotaKirim($token, $param_nota);
        echo json_encode($res);
    }

    public function cekTransaksiKirim()
    {
        $token      = $this->input->post('token');
        $param_cek = array(
            $this->input->post('idtransaksi'),
            $this->input->post('idoutlet'),
        );
        $res = $this->WorkshopModel->transaksiKirim($token, $param_cek);
        echo json_encode($res);
    }

    public function gettime()
    {
        echo time();
    }
}
