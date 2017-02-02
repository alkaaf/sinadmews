<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthenticationModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
     *
     * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
     * @param string $foto          URL foto
     *
     * @return JSON
     */
    public function checkRequestMethod(array $RequestMethod) {
        $errorFlag = false;
        foreach ($RequestMethod as $value) {
            if (empty($value)) {
                $errorFlag = false;
                break;
            } else {
                $errorFlag = true;
            }
        }

        return $errorFlag;
    }

    /**
     * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
     *
     * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
     * @param string $foto          URL foto
     *
     * @return JSON
     */
    public function checkUserExistent($email) {
        $predicate = array(
            'email' => $email,
        );

        $this->db->join('daftar_karyawan_outlet', 'idkaryawan = karyawan_idkaryawan');
        $this->db->where($predicate);
        $query = $this->db->get('karyawan');

        if ($query->num_rows() < 1) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
     *
     * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
     * @param string $foto          URL foto
     *
     * @return JSON
     */
    public function retrieveEmail($param) {
        $rb = new ResultBuilder();

        if ($this->checkEmail($param)) {
            $res = $this->db->query("select idkaryawan, idoutlet, o.owner_idowner as idowner, o.workshop_idworkshop as idworkshop, email, k.nama as nama_karyawan, o.nama as nama_outlet, o.alamat as alamat_outlet, o.telp from karyawan k join outlet o on k.owner_idowner = o.owner_idowner where email = ?", $param)->result_array();
            $rb->setRow($res[0]);
            $rb->setMessage("Pengambilan data berhasil");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    /**
     * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
     *
     * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
     * @param string $foto          URL foto
     *
     * @return JSON
     */
    public function addToken($email, $idkaryawan, $token) {

        //prepare value
        // $value = array(
        //   'email' = $email,
        //   'karyawan_idkaryawan' = $idkaryawan,
        //   'token' = $token
        //   );
        $waktu1 = date('Y-m-d H:i:s');
        $waktu2 = substr(microtime(), 2, 6);

        $timestamp = strtotime($waktu1);
        $waktulogin = $timestamp . $waktu2;

        $sql = "INSERT INTO log_token (karyawan_idkaryawan, email, token, waktu_login, valid, hapus) VALUES (?, ?, ?, ?, ?, ?)";
        $bindparam = array($idkaryawan, $email, $token, $waktulogin, 1, 0);
        $query = $this->db->query($sql, $bindparam);

        if ($this->db->affected_rows() != 1) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
     *
     * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
     * @param string $foto          URL foto
     *
     * @return JSON
     */
    public function removeToken($email, $idkaryawan, $token) {

        $sql = $this->db->query("SELECT * FROM log_token
      where hapus = 0 and email=? and karyawan_idkaryawan =? and token =?", array($email, $idkaryawan, $token));

        if ($sql->num_rows() < 1) {
            return false;
        } else {
            $query = $this->db->query("UPDATE log_token SET valid = 0 WHERE token =? and karyawan_idkaryawan =?", array($token, $idkaryawan));

            if ($this->db->affected_rows() != 1) {
                return false;
            } else {
                return true;
            }

        }
    }

    private function checkEmail($param) {
        return $this->db->query("select * from karyawan where email = ? and hapus = 0", array($param))->num_rows() > 0;
    }

    private function checkToken($token) {
        return $this->db->query("select * from log_token where token = ? and valid = 1", array($token))->num_rows() > 0;
    }
}
