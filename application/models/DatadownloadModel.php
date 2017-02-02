<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DatadownloadModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Function - Mengambil daftar harga layanan yang ada di outlet
     *
     * @param string $token         menunjukan user masih login
     * @param string $idkaryawan    kode id dari karyawan yang berinteraksi dengan sistem
     * @param string $idoutlet      kode id dari outlet
     *
     * @return JSON
     */
    public function retrieveHargaLayanan($token, $idkaryawan, $idoutlet)
    {

        $query = $this->db->query("SELECT * FROM harga_layanan JOIN daftar_karyawan_outlet ON idkaryawan = karyawan_idkaryawan where hapus = 0 and email=?", array($email));

        if ($query->num_rows() < 1) {
            return false;
        } else {
            return $query->result_array();
        }

    }

    /**
     * Function - Mengambil data customer dari tabel customer yang dimiliki outlet dan owner
     *
     * @param string $token         menunjukan user masih login
     * @param string $idoutlet      kode id dari outlet
     *
     * @return JSON
     */
    public function retrieveCustomer($token, $idoutlet)
    {

        $sql = $this->db->query("SELECT * FROM log_token WHERE hapus = 0 and valid = 1 and token =?", array($token));

        if ($sql->num_rows() < 1) {
            return false;
        } else {
            $query = $this->db->query("SELECT c.idcustomer, c.telp, c.nama FROM customer c JOIN owner o JOIN outlet otl
      ON c.owner_idowner = o.idowner and o.idowner = otl.owner_idowner WHERE c.hapus = 0 and idoutlet =?", array($idoutlet));

            if ($query->num_rows() < 1) {
                return false;
            } else {
                return $query->result_array();
            }
        }

    }

    /**
     * Function - Mengambil data alamat dari tabel alamat, customer, dan outlet
     *
     * @param string $token         menunjukan user masih login
     * @param string $idoutlet      kode id dari outlet
     *
     * @return JSON
     */
    public function retrieveAlamat($token, $idoutlet)
    {

        $sql = $this->db->query("SELECT * FROM log_token WHERE hapus = 0 and valid = 1 and token =?", array($token));

        if ($sql->num_rows() < 1) {
            return false;
        } else {
            $query = $this->db->query("SELECT a.idalamat, c.idcustomer, a.lokasi, a.tetap FROM customer c JOIN outlet otl JOIN alamat a
        ON c.idcustomer = a.customer_idcustomer WHERE idoutlet =?", array($idoutlet));

            if ($query->num_rows() < 1) {
                return false;
            } else {
                return $query->result_array();
            }
        }

    }

    /**
     * Function - Mengambil data layanan dari table layanan, harga layanan, dan data satuan
     *
     * @param string $token         menunjukan user masih login
     * @param string $idoutlet      kode id dari outlet
     *
     * @return JSON
     */
    public function retrieveLayanan($token, $idoutlet)
    {
        $sql = $this->db->query("SELECT * FROM log_token WHERE hapus = 0 and valid = 1 and token =?", array($token));

        if ($sql->num_rows() < 1) {
            return false;
        } else {
            $query = $this->db->query("SELECT l.idlayanan, l.nama_layanan, hl.harga, l.jumlah, ds.nama as nama_satuan, l.durasi_penyelesaian
        FROM layanan l JOIN harga_layanan hl JOIN data_satuan ds
        ON l.idlayanan = hl.layanan_idlayanan and ds.iddata_satuan = l.data_satuan_iddata_satuan
        WHERE l.hapus = 0 and hl.outlet_idoutlet =?", array($idoutlet));

            if ($query->num_rows() < 1) {
                return false;
            } else {
                return $query->result_array();
            }
        }

    }

    /**
     * Function - Mengambil data item dari tabel item yang dimiliki oleh outlet
     *
     * @param string $token         menunjukan user masih login
     * @param string $idoutlet      kode id dari outlet
     *
     * @return JSON
     */
    public function retrieveItem($token, $idoutlet)
    {

        $sql = $this->db->query("SELECT * FROM log_token WHERE hapus = 0 and valid = 1 and token =?", array($token));

        if ($sql->num_rows() < 1) {
            return false;
        } else {
            $query = $this->db->query("SELECT i.iditem, i.nama as nama_item FROM item i JOIN daftar_item_outlet dio JOIN outlet o
        ON i.iditem = dio.item_iditem and dio.outlet_idoutlet = o.idoutlet
        WHERE dio.outlet_idoutlet=?", array($idoutlet));

            if ($query->num_rows() < 1) {
                return false;
            } else {
                return $query->result_array();
            }
        }

    }

    /**
     * Function - Mengambil data satuan yang ada pada tabel data_satuan
     *
     * @param string $token         menunjukan user masih login
     *
     * @return JSON
     */
    public function retrieveSatuan($token)
    {
        $sql = $this->db->query("SELECT * FROM log_token WHERE hapus = 0 and valid = 1 and token =?", array($token));

        if ($sql->num_rows() < 1) {
            return false;
        } else {
            $query = $this->db->query("SELECT * FROM data_satuan");

            if ($query->num_rows() < 1) {
                return false;
            } else {
                return $query->result_array();
            }
        }

    }

    public function retrieveParfum($token, $idowner)
    {
        $sql = $this->db->query("SELECT * FROM log_token WHERE hapus = 0 and valid = 1 and token =?", array($token));

        if ($sql->num_rows() < 1) {
            return false;
        } else {
            $query = $this->db->query("SELECT idparfum, nama_parfum, owner_idowner FROM parfum WHERE owner_idowner = ?", array ($idowner));

            if ($query->num_rows() < 1) {
                return false;
            } else {
                return $query->result_array();
            }
        }
    }

}
