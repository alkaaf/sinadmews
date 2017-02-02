<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DatauploadController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        header('Content-Type: application/json');

    }

    public function index() {
        $this->load->view('welcome_message');
    }

    /**
     * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
     *
     * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
     * @param string $foto          URL foto
     *
     * @return JSON
     */
    public function transaksiBaru() 
    {
        $token = $this->input->post('token');
        $param = array(
            $this->input->post('idtransaksi'),
            $this->input->post('idoutlet'),
            $this->input->post('idworkshop'),
            $this->input->post('idkaryawan'),
            $this->input->post('customer'),
            $this->input->post('waktu'),
            $this->input->post('t_selesai'),
            $this->input->post('t_terima'),
            $this->input->post('idjenis_bayar'),
            $this->input->post('idparfum'),
            $this->input->post('lunas'),
            $this->input->post('t_pengantaran'),
            $this->input->post('idalamatantar')
        );
        $res = $this->DatauploadModel->inputTransaksi($token, $param);
        echo json_encode($res);

    }

    public function detlayananBaru() 
    {
        $token = $this->input->post('token');
        $param = array(
            $this->input->post('idtransaksi'),
            $this->input->post('idlayanan'),
            $this->input->post('jumlah_beli')
        );
        $res = $this->DatauploadModel->inputDetlayanan($token, $param);
        echo json_encode($res);

    }

    public function detitemBaru() 
    {
        $token = $this->input->post('token');
        $param = array(
            $this->input->post('iditem'),
            $this->input->post('idlayanan'),
            $this->input->post('jumlah_item'),
            $this->input->post('idtransaksi')
        );
        $res = $this->DatauploadModel->inputDetitem($token, $param);
        echo json_encode($res);

    }

    public function pembayaranBaru() 
    {
        $token = $this->input->post('token');
        $param = array(
            $this->input->post('idoutlet'),
            $this->input->post('idkaryawan'),
            $this->input->post('customer'),
            $this->input->post('idtransaksi'),
            $this->input->post('tagihan'),
            $this->input->post('nominal'),
            $this->input->post('sisa'),
            $this->input->post('kembalian'),
            $this->input->post('waktu'),
            $this->input->post('diskon'),
            $this->input->post('pajak')
        );
        $res = $this->DatauploadModel->inputPembayaran($token, $param);
        echo json_encode($res);

    }

}
