<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KeuanganModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getBiayaOpOutlet($token, $param)
    {
        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $res = $this->db->query("select idbiaya, idakun_kredit, nama_akun_kredit, idakun_debet, nama_akun_debet, waktu, tanggal_biaya, nominal, keterangan, idkarwayan, nama_karyawan, idoutlet", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data biaya operasional outlet berhasil");
            $rb->setSuccess(true);
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
