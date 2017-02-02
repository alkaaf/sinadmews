<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DepositController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->model('AlkaafEmoney');
    }

    public function depositOutlet() {
        $token = $this->input->post('token');
        $param = array(
            $this->input->post('idoutlet'),
            "%" . $this->input->post('nama_deposit') . "%",
        );
        $res = $this->DepositModel->getDeposit($token, $param);
        echo json_encode($res);
    }

    public function setBeliDeposit() {
        $token = $this->input->post('token');

        $param_belideposit = array(
            $this->input->post('idpembelian'),
            $this->input->post('idoutlet'),
            $this->input->post('idcustomer'),
            $this->input->post('idkaryawan'),
            $this->input->post('tglbeli'),
            $this->input->post('keterangan'),
        );

        $res = $this->DepositModel->buyDeposit($token, $param_belideposit);

        echo json_encode($res);
    }

    public function setDetailBeliDeposit() {
        $token = $this->input->post('token');

        $param_deposit = array(
            $this->input->post('idpembelian'),
            $this->input->post('iddata_deposit'),
            $this->input->post('jumlah'),
        );

        $res = $this->DepositModel->detailDeposit($token, $param_deposit);

        echo json_encode($res);
    }

    public function setBayarBeliDeposit() {
        $token = $this->input->post('token');
        $param_bayardeposit = array(
            $this->input->post('idpembelian'),
            $this->input->post('tagihan'),
            $this->input->post('nominal'),
            $this->input->post('kembalian'),
        );
        $res = $this->DepositModel->setBayarBeliDeposit($token, $param_bayardeposit);
        echo json_encode($res);
    }

    public function daftarPembelianDeposit() {
        $token = $this->input->post('token');
        $param = array("%" . $this->input->post('idpembelian') . "%");
        $res = $this->DepositModel->getPembelianDeposit($token, $param);

        echo json_encode($res);
    }

    public function setPenggunaanDeposit() {
        $token = $this->input->post('token');
        $param = array(
            $this->input->post('idcustomer'),
            $this->input->post('keluar'),
            $this->input->post('idtransaksi'),
            $this->input->post('iddata_deposit')
        );
        $res = $this->DepositModel->penggunaanDeposit($token, $param);

        echo json_encode($res);
    }

    public function depositCustomer() {
        $token = $this->input->post('token');
        $param = array($this->input->post('idcustomer'));
        $res = $this->DepositModel->getDepositCustomer($token, $param);

        echo json_encode($res);
    }

    public function detailPembelianDeposit() {
        $token = $this->input->post('token');
        $param = array($this->input->post('idpembelian'));
        $res = $this->DepositModel->getDetailBeliDeposit($token, $param);

        echo json_encode($res);
    }

    public function depositTransaksi() {
        $token = $this->input->post('token');
        $transaksi = json_decode($this->input->post('data'));
        $layanan = $transaksi->detail_layanan;
        $pembayaran = $transaksi->pembayaran;

        $data = array(
            'success' => false,
            'messages' => null,
        );
        $result = $this->DatauploadModel->inputTransaksi(
            $token,
            $transaksi->idtransaksi,
            $transaksi->idoutlet,
            $transaksi->idworkshop,
            $transaksi->idkaryawan,
            $transaksi->idcustomer,
            $transaksi->waktu,
            $transaksi->tselesai,
            $transaksi->tterima,
            $transaksi->jenis_pembayaran,
            $transaksi->idparfum,
            $transaksi->lunas,
            $transaksi->tpengantaran,
            $transaksi->idalamat
        );
        $resultbayar = $this->DatauploadModel->inputPembayaran(
            $token,
            $pembayaran->idtransaksi,
            $pembayaran->idoutlet,
            $pembayaran->idkaryawan,
            $pembayaran->idcustomer,
            $pembayaran->grand_total,
            $pembayaran->nominal,
            $pembayaran->sisa,
            $pembayaran->kembalian,
            $pembayaran->waktu,
            $pembayaran->diskon,
            $pembayaran->pajak
        );

        foreach ($layanan as $key => $detaillayanan) {
            $this->DatauploadModel->inputDetlayanan(
                $token,
                $detaillayanan->idtransaksi,
                $detaillayanan->idlayanan,
                $detaillayanan->jumlah_pakai
            );
            $param = array(
                $transaksi->idcustomer,
                $detaillayanan->jumlah_pakai,
                $detaillayanan->iddeposit,
            );
            $this->DepositModel->penggunaanDeposit($token, $param);
            foreach ($detaillayanan->detail_item as $key2 => $detailitem) {
                $this->DatauploadModel->inputDetitem(
                    $token,
                    $detailitem->iditem,
                    $detailitem->idlayanan,
                    $detailitem->jumlah,
                    $detailitem->idtransaksi
                );
            }
        }
        if ($result == false) {
            $data['messages'] = "Error when input Transaksi";
            $data['ada'] = false;
        } else {
            $data['success'] = true;
            $data['messages'] = "Input Transaksi success";
        }

        echo json_encode($data);
    }
    public function gettime() {
        echo time();
    }
}
