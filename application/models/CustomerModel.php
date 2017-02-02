<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function inputCustomer($token, $param) {

        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $id = $this->getIdCustomer();
            array_unshift($param, $id);
            $res = $this->db->query("insert into customer values (?,?,?,?,0)", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setRow(array("idcustomer" => $id));
                $rb->setSuccess(true);
                $rb->setMessage("Input data customer sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Input data customer gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function updateAlamat($token, $param) {
        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $res = $this->db->query("replace into alamat values (null,?,?,0,0)", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Input data alamat customer sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Input data alamat customer gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function editCustomer($token, $param) {
        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $res = $this->db->query("update customer set telp = ?, nama = ? where idcustomer = ?", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Update data customer sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Update data customer gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function editAlamat($token, $param) {
        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $res = $this->db->query("update alamat set customer_idcustomer = ? , lokasi = ? where idalamat = ?", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Edit data alamat customer sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Edit data alamat customer gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    //private function

    private function getIdCustomer() {
        $id = $this->db->query("select idcustomer from customer order by idcustomer desc limit 1")->result_array()[0];
        $newid = implode("", $id);
        $intnewid = intval(substr($newid, 3, 10)) + 1;
        $strnewid = sprintf('CST%010d', $intnewid);
        return $strnewid;
    }

    private function checkToken($token) {
        return $this->db->query("select * from log_token where token = ? and valid = 1", array($token))->num_rows() > 0;
    }
}
