<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmoneyController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('AlkaafEmoney');
    }

    public function emoneyOutlet()
    {
        $token = $this->input->post('token');
        $param = array(
            $this->input->post('idoutlet'),
            "%" . $this->input->post('nama_emoney') . "%",
        );
        $res = $this->EmoneyModel->getEMoney($token, $param);
        echo json_encode($res);
    }

    public function uploadPembelianEmoney()
    {

        $token = $this->input->post('token');
        // pembelian
        $param_pembelian = array(
            $this->input->post('idpembelian'),
            $this->input->post('idoutlet'),
            $this->input->post('idcustomer'),
            $this->input->post('idkaryawan'),
            $this->input->post('tglbeli'),
            $this->input->post('keterangan'),
        );
        $res = $this->EmoneyModel->setPembelian($token, $param_pembelian);
        echo json_encode($res);
    }

    public function uploadPembayaranEmoney()
    {
        $token = $this->input->post('token');
        // pembayaran
        $param_pembayaran = array(
            $this->input->post('idpembelian'),
            $this->input->post('tagihan'),
            $this->input->post('nominal'),
            $this->input->post('kembalian'),
        );
        $res = $this->EmoneyModel->setPembayaran($token, $param_pembayaran);
        echo json_encode($res);
    }

    public function uploadDetailPembelianEmoney()
    {
        $token        = $this->input->post('token');
        $param_detail = array(
            $this->input->post('idpembelian'),
            $this->input->post('idemoney'),
            $this->input->post('jumlah'),
        );
        $res = $this->EmoneyModel->setDetailPembelian($token, $param_detail);
        echo json_encode($res);
    }

    // public function uploadPenggunaanEmoney()
    // {
    //     $token            = $this->input->post('token');
    //     $param_penggunaan = array(
    //         null,
    //         $this->input->post('idcustomer'),
    //         0,
    //         $this->input->post('keluar'),
    //         0,
    //         0,
    //         2,
    //         null,
    //         null,
    //     );
    //     $res = $this->EmoneyModel->setPenggunaan($token, $param_penggunaan);
    //     echo json_encode($res);
    // }

    public function daftarPembelianEmoney()
    {
        $token = $this->input->post('token');
        $param = array("%" . $this->input->post('idpembelian') . "%");
        $res = $this->EmoneyModel->getPembelianEmoney($token, $param);

        echo json_encode($res);
    }

    public function setPenggunaanEmoney()
    {
        $token = $this->input->post('token');
        $param = array(
            $this->input->post('idcustomer'),
            $this->input->post('keluar'),
            $this->input->post('idtransaksi')
        );
        $res = $this->EmoneyModel->penggunaanEmoney($token, $param);

        echo json_encode($res);
    }

    public function emoneyCustomer()
    {
        $token = $this->input->post('token');
        $param = array($this->input->post('idcustomer'));
        $res = $this->EmoneyModel->getEmoneyCustomer($token, $param);

        echo json_encode($res);
    }

    public function detailPembelianEmoney()
    {
        $token = $this->input->post('token');
        $param = array($this->input->post('idpembelian'));
        $res   = $this->EmoneyModel->getDetailBeliEmoney($token, $param);

        echo json_encode($res);
    }

    public function gettime()
    {
        echo time();
    }
}
