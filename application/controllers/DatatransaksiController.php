<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DatatransaksiController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');

    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function cariTransaksi()
    {
        $token           = $this->input->post('token');
        $q               = $this->input->post('query');
        $tglstart        = $this->input->post('tglstart');
        $tglend          = $this->input->post('tglend');
        $jenispembayaran = $this->input->post('jenispembayaran');
        $idtahapan       = $this->input->post('tahapan');
        $lunas           = $this->input->post('statuslunas');
        $idoutlet        = $this->input->post('idoutlet');
        $result          = $this->DatatransaksiModel->cariTransaksi($token, $q, $tglstart, $tglend, $lunas, $jenispembayaran, $idtahapan, $idoutlet);

        echo json_encode($result);

    }
    public function detailTransaksi()
    {

        $token       = $this->input->post('token');
        $idtransaksi = $this->input->post('idtransaksi');

        $result = $this->DatatransaksiModel->retrieveTransaksi($token, $idtransaksi);

        echo json_encode($result);

    }

    public function detailLayanan()
    {

        $token       = $this->input->post('token');
        $idtransaksi = $this->input->post('idtransaksi');

        $result = $this->DatatransaksiModel->retrieveDetailLayanan($token, $idtransaksi);

        echo json_encode($result);

    }

    public function detailItem()
    {

        $token       = $this->input->post('token');
        $idtransaksi = $this->input->post('idtransaksi');
        $idlayanan   = $this->input->post('idlayanan');

        $param = array($idtransaksi, $idlayanan);

        $result = $this->DatatransaksiModel->retrieveDetailItem($token, $param);

        echo json_encode($result);

    }

    public function detailPembayaran()
    {

        $token       = $this->input->post('token');
        $idtransaksi = $this->input->post('idtransaksi');

        $result = $this->DatatransaksiModel->retrieveDetailPembayaran($token, $idtransaksi);

        echo json_encode($result);

    }

    public function jadwalAntar(){

        $token       = $this->input->post('token');
        $idoutlet = $this->input->post('idoutlet');

        $result = $this->DatatransaksiModel->retrievejadwalAntar($token, $idoutlet);

        echo json_encode($result);

    }
}
