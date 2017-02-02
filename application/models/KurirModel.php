<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KurirModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function inputSuratJemput($token, $param)
    {
        $rb = new ResultBuilder();
        $idsuratjemput = $param[0];

        if ($this->checkToken($token)) {
            $tes = $this->db->query("select idsurat_penjemputan from surat_penjemputan where idsurat_penjemputan = ?", $idsuratjemput);
            if ($tes->num_rows() > 0){
                $rb->setSuccess(true);
            } else {
                $res = $this->db->query("insert into surat_penjemputan values (?,?,?,?,?,?,?,0,0,?,?,?,?)", $param);
                if ($this->db->affected_rows() > 0) {
                    $rb->setSuccess(true);
                    $rb->setMessage("Input surat penjemputan sukses");
                } else {
                    $rb->setSuccess(false);
                    $rb->setMessage("Input surat penjemputan gagal");
                }
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function getKurir($token, $param)
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select karyawan_idkurir as idkurir, karyawan.nama as namakurir from daftar_karyawan_kurir join owner on owner_idowner = idowner join karyawan on karyawan_idkurir = idkaryawan where idowner = ? and karyawan.nama like ?", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data kurir sukses");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();

    }

    public function getCompleteTransaction($token, $param)
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select idtransaksi, customer.nama nama_customer, tanggal_terima, tanggal_selesai, tahapan.nama tahapan, lunas FROM transaksi JOIN customer ON customer_idcustomer = idcustomer JOIN resume_daftar_pemrosesan on idtransaksi = transaksi_idtransaksi JOIN tahapan on idtahapan = tahapan_idtahapan WHERE idcustomer = ? and idtahapan = 8 and idtransaksi like ?", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data Transaksi Komplit berhasil");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function inputSuratAntar($token, $param)
    {
        $rb = new ResultBuilder();
        $idsuratantar = $param[0];

        if ($this->checkToken($token)) {
            $tes = $this->db->query("select idsurat_pengantaran from surat_pengantaran where idsurat_pengantaran = ?", $idsuratantar);
            if ($tes->num_rows() > 0){
                $rb->setSuccess(true);
            } else {
                $res = $this->db->query("insert into surat_pengantaran values (?,?,?,?,0,?,?,?,null,null,?)", $param);
                if ($this->db->affected_rows() > 0) {
                    $rb->setSuccess(true);
                    $rb->setMessage("Input surat pengantaran sukses");
                } else {
                    $rb->setSuccess(false);
                    $rb->setMessage("Input surat pengantaran gagal");
                }
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function inputDaftarNotaAntar($token, $param)
    {
        $rb = new ResultBuilder();
        $idsuratantar = $param[0];
        if ($this->checkToken($token)) {
            $tes = $this->db->query("select surat_pengantaran_idsurat_pengantaran from nota_transaksi_diantar where surat_pengantaran_idsurat_pengantaran = ?", $idsuratantar);
            if ($tes->num_rows() > 0){
                $rb->setSuccess(true);
            } else {
                $res = $this->db->query("insert into nota_transaksi_diantar values (?,?)", $param);
                if ($this->db->affected_rows() > 0) {
                    $rb->setSuccess(true);
                    $rb->setMessage("Input nota penjemputan sukses");
                } else {
                    $rb->setSuccess(false);
                    $rb->setMessage("Input nota penjemputan gagal");
                } 
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function inputDaftarNotaJemput($token, $param)
    {
        $rb = new ResultBuilder();
        $idsuratjemput= $param[0];
        if ($this->checkToken($token)) {
            $tes = $this->db->query("select surat_penjemputan_idsurat_penjemputan from nota_transaksi_dijemput where surat_penjemputan_idsurat_penjemputan = ?", $idsuratjemput);
            if ($tes->num_rows() > 0){
                $rb->setSuccess(true);
            } else {
                $res = $this->db->query("insert into nota_transaksi_dijemput values (?,?)", $param);
                if ($this->db->affected_rows() > 0) {
                    $rb->setSuccess(true);
                    $rb->setMessage("Input nota penjemputan sukses");
                } else {
                    $rb->setSuccess(false);
                    $rb->setMessage("Input nota penjemputan gagal");
                }
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function getSuratJemput($token, $param)
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select idsurat_penjemputan as idsurat, luas, kiloan, satuan, karyawan_idkurir as idkurir, kurir.nama as namakurir, karyawan_idkasir as idkaryawan, kasir.nama as namakaryawan, status, valid, customer_idcustomer as idcustomer, outlet_idoutlet as idoutlet, alamat_idalamat as idalamat, tanggal_jemput, keterangan from surat_penjemputan join karyawan kurir on karyawan_idkurir = kurir.idkaryawan join karyawan kasir on karyawan_idkasir = kasir.idkaryawan where outlet_idoutlet = ? and idsurat_penjemputan like ?", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data surat penjemputan sukses");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function getSuratAntar($token, $param)
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select idsurat_pengantaran as idsurat, karyawan_idkurir as idkurir, kurir.nama as namakurir, karyawan_idkasir as idkaryawan, kasir.nama as namakaryawan, status, customer_idcustomer as idcustomer, alamat_idalamat as idalamat, outlet_idoutlet as idoutlet, tanggal_antar, keterangan, foto_gagal, keterangan_gagal from surat_pengantaran join karyawan kurir on karyawan_idkurir = kurir.idkaryawan join karyawan kasir on karyawan_idkasir = kasir.idkaryawan where outlet_idoutlet = ? and idsurat_pengantaran like ?", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data surat pengantaran sukses");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function getNotaJemput($token, $param)
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select transaksi_idtransaksi as idtransaksi from nota_transaksi_dijemput where surat_penjemputan_idsurat_penjemputan = ?", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data nota penjemputan sukses");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function getNotaAntar($token, $param)
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select transaksi_idtransaksi as idtransaksi from nota_transaksi_diantar where surat_pengantaran_idsurat_pengantaran = ?", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data nota pengantaran sukses");
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
