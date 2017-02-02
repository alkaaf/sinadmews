<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SyncModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getLayanan($token, $param, $waktu) {
        // result builder, buat ngebuat JSON result lebih cepet. kalo mau liat kelasnya liat aja ResultBuilder.php
        $rb = new ResultBuilder();
        $where = "";
        if ($this->checkToken($token)) {
            $where .= " and outlet_idoutlet = ?";
            $res = $this->getTableData("sync_layanan", $where, $param, $waktu);

            // set DATA. tinggal set aja dari $res.
            $rb->setData($res);

            // set Message. tinggal set aja sesuka hati
            $rb->setMessage("Pengambilan data layanan sukses");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }

        // method ini buat dapetin hasilnya. nanti langsung di echo di controller.
        return $rb->getResult();
    }
    public function getItem($token, $param, $waktu) {
        $rb = new ResultBuilder();
        $where = "";
        if ($this->checkToken($token)) {
            $where .= " and outlet_idoutlet = ?";
            $res = $this->getTableData("sync_item", $where, $param, $waktu);
            $rb->setData($res);
            $rb->setMessage("Pengambilan data item sukses");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }
    public function getCustomer($token, $param, $waktu) {
        $rb = new ResultBuilder();
        $where = "";
        if ($this->checkToken($token)) {
            $where .= " and owner_idowner = ?";
            $res = $this->getTableData("sync_customer", $where, $param, $waktu);
            $rb->setData($res);
            $rb->setMessage("Pengambilan data kustomer sukses");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }
    public function getAlamat($token, $param, $waktu) {
        $rb = new ResultBuilder();
        $where = "";
        if ($this->checkToken($token)) {
            $where .= " and owner_idowner = ?";
            $res = $this->getTableData("sync_alamat", $where, $param, $waktu);
            $rb->setData($res);
            $rb->setMessage("Pengambilan data alamat sukses");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }
    public function getParfum($token, $param, $waktu) {
        $rb = new ResultBuilder();
        $where = "";
        if ($this->checkToken($token)) {
            $where .= " and owner_idowner = ?";
            $res = $this->getTableData("sync_parfum", $where, $param, $waktu);
            $rb->setData($res);
            $rb->setMessage("Pengambilan data parfum sukses");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    private function getTableData($table, $where, $param, $waktu) {
        return $this->db->query("select * from " . $table . " where 1=1 " . $where . " and waktu > " . $waktu . " order by waktu asc", $param)->result_array();
    }
    private function checkToken($token) {
        return $this->db->query("select * from log_token where token = ? and valid=1", array($token))->num_rows() > 0;
    }
}
