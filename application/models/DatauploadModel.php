<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DatauploadModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function inputTransaksi($token, $param) 
    {

        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            // cek isi variabel idworkshop
            if ($param[2] == ""){
                $param[2] = null;
            }

            $res = $this->db->query("insert into transaksi values (?,?,?,?,?,?,?,?,0,?,?,?,?,?,0)", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Input data transaksi sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Input data transaksi gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function inputDetlayanan($token, $param)
    {

        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("insert into detlayanan values (?,?,?)", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Input data detail layanan sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Input data detail layanan gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function inputDetitem($token, $param) 
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("insert into detitem values (?,?,?,?)", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Input data detail item sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Input data detail item gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function inputPembayaran($token, $param) 
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("insert into pembayaran_umum values (null,?,?,?,?,?,?,?,?,?,?,?)", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Input data pembayaran sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Input data pembayaran gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    private function checkToken($token)
    {
        return $this->db->query("select * from log_token where token = ? and valid = 1", array($token))->num_rows() > 0;
    }

}
