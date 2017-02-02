<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KurirController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('AlkaafEmoney');
    }

    public function setSuratJemput()
    {
        $token = $this->input->post('token');

        $param_surat = array(
            $this->input->post('idsuratjemput'),
            $this->input->post('luas'),
            $this->input->post('kiloan'),
            $this->input->post('satuan'),
            $this->input->post('idkurir'),
            $this->input->post('idkaryawan'),
            $this->input->post('idoutlet'),
            $this->input->post('idcustomer'),
            $this->input->post('idalamat'),
            $this->input->post('tanggaljemput'),
            $this->input->post('keterangan'),
        );

        $res = $this->KurirModel->inputSuratJemput($token, $param_surat);

        echo json_encode($res);
    }

    public function daftarKurir()
    {
        $token = $this->input->post('token');
        $param = array(
            $this->input->post('idowner'),
            "%" . $this->input->post('nama_kurir') . "%",
        );
        $res = $this->KurirModel->getKurir($token, $param);

        echo json_encode($res);
    }

    public function daftarTransaksiKomplit()
    {
        $token = $this->input->post('token');
        $param = array(
            $this->input->post('idcustomer'),
            "%" . $this->input->post('idtransaksi') . "%",
        );
        $res = $this->KurirModel->getCompleteTransaction($token, $param);

        echo json_encode($res);
    }

    public function setSuratAntar()
    {
        $token = $this->input->post('token');

        $param_surat = array(
            $this->input->post('idsuratantar'),
            $this->input->post('idkaryawan'),
            $this->input->post('idkurir'),
            $this->input->post('idoutlet'),
            $this->input->post('keterangan'),
            $this->input->post('idalamat'),
            $this->input->post('idcustomer'),
            $this->input->post('tanggal_antar'),
        );

        $res = $this->KurirModel->inputSuratAntar($token, $param_surat);

        echo json_encode($res);
    }

    public function setDaftarNotaAntar()
    {
        $token = $this->input->post('token');

        $param_nota = array(
            $this->input->post('idsuratantar'),
            $this->input->post('idtransaksi'),
        );

        $res = $this->KurirModel->inputDaftarNotaAntar($token, $param_nota);

        echo json_encode($res);

    }

    public function setDaftarNotaJemput()
    {
        $token = $this->input->post('token');

        $param_nota = array(
            $this->input->post('idsuratjemput'),
            $this->input->post('idtransaksi'),
        );

        $res = $this->KurirModel->inputDaftarNotaJemput($token, $param_nota);

        echo json_encode($res);
    }

    public function daftarSuratJemput()
    {
        $token = $this->input->post('token');

        $param_surat = array(
            $this->input->post('idoutlet'),
            "%" . $this->input->post('idsurat') . "%",
        );

        $res = $this->KurirModel->getSuratJemput($token, $param_surat);

        echo json_encode($res);
    }

    public function daftarSuratAntar()
    {
        $token = $this->input->post('token');

        $param_surat = array(
            $this->input->post('idoutlet'),
            "%" . $this->input->post('idsurat') . "%",
        );

        $res = $this->KurirModel->getSuratAntar($token, $param_surat);

        echo json_encode($res);
    }

    public function daftarNotaJemput()
    {
        $token = $this->input->post('token');

        $param_surat = array($this->input->post('idsurat'));

        $res = $this->KurirModel->getNotaJemput($token, $param_surat);

        echo json_encode($res);
    }

    public function daftarNotaAntar()
    {
        $token = $this->input->post('token');

        $param_surat = array($this->input->post('idsurat'));

        $res = $this->KurirModel->getNotaAntar($token, $param_surat);

        echo json_encode($res);
    }

    public function gettime()
    {
        echo time();
    }
}
