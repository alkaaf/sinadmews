<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WorkshopModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getWorkshop($token, $param)
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select idworkshop, nama as namaworkshop from workshop where owner_idowner = ?", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data daftar workshop sukses");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();

    }

    public function suratKirim($token, $param)
    {

        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $res = $this->db->query("replace into surat_kirim_workshop values (?,?,?,null,?,?,?,null,?,0,0)", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Input data surat kirim workshop sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Input data surat kirim workshop gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function penerimaSurat($token, $param)
    {
        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $res = $this->db->query("update surat_kirim_workshop set idkaryawan_workshop = ? , tanggal_terima = ? where idsurat_kirim_workshop = ?", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Update data surat kirim workshop sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Update data surat kirim workshop gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function daftarNotaKirim($token, $param)
    {
        $idtransaksi = $param[2];
        $idworkshop = $param[1];
        $idsurat = $param[0];
        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $res = $this->db->query("replace into nota_kirim_workshop values (?,?)", array($idsurat, $idtransaksi));
            $res2 = $this->db->query("update transaksi set workshop_idworkshop = ? where idtransaksi = ?", array($idworkshop, $idtransaksi));
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Input data nota kirim workshop sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Input data nota kirim workshop gagal");
            }

        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function transaksiKirim($token, $param)
    {
        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $res = $this->db->query("select idtransaksi, outlet_idoutlet, workshop_idworkshop, tahapan_idtahapan, customer_idcustomer from transaksi join resume_daftar_pemrosesan on idtransaksi = transaksi_idtransaksi where idtransaksi = ? and outlet_idoutlet = ? order by tahapan_idtahapan desc", $param)->result_array()[0];
            if ($this->db->affected_rows() == 0) {
                $rb->setSuccess(false);
                $rb->setMessage("Transaksi tidak ada");
            } elseif ($res['tahapan_idtahapan'] != 1) {
                $rb->setSuccess(false);
                $rb->setMessage("Transaksi telah diproses");
            } elseif ($res['workshop_idworkshop'] != null) {
                $rb->setSuccess(false);
                $rb->setMessage("Transaksi tidak dapat dipilih karena workshop telah ditentukan");
            } else {
                $rb->setSuccess(true);
                $rb->setMessage("Transaksi Valid");

            }

        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    //private function

    // private function checkTransactiom($id)
    // {
    //     $res = $this->db->query("select idtransaksi, outlet_idoutlet, workshop_idworkshop from transaksi where idtransaksi = ?", $id)->result_array()[0];
    //     if ($res['outlet_idoutlet'] = null){
    //         return 0;
    //     } elseif ($res)
    // }

    private function checkToken($token)
    {
        return $this->db->query("select * from log_token where token = ? and valid = 1", array($token))->num_rows() > 0;
    }
}
