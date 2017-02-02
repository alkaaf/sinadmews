<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FirebaseModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function setUpdateToken($token, $param)
    {
        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $res = $this->db->query("replace into firebase_token values (?,get_mills(),?)", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Update firebase token sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Update firebase token gagal");
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
