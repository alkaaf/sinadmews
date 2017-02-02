<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DatatransaksiModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Get data dari tabel transaksi
     * input        = token, id transaksi
     * output       = JSON -> success, message, data tabel transaksi
     */
    public function cariTransaksi($token, $q, $tglstart, $tglend, $lunas, $idpembayaran, $idtahapan) {
        // Prepare JSON
        $result = array(
            'success' => false,
            'message' => null,
            'data' => null,
            'row' => null,
        );
        if ($this->checkToken($token)) {
            $param = array();
            $cond0 = " and idtransaksi like ?";
            $cond1 = " and tanggal_terima > ? and tanggal_terima < ?";
            $cond2 = " and lunas = ?";
            $cond3 = " and idjenis_pembayaran = ?";
            $cond4 = " and idtahapan = ?";
            $cond5 = " and idoutlet = ?";

            $query = "SELECT idtransaksi, customer.nama nama_customer, tanggal_terima, tanggal_selesai, tahapan.nama tahapan, idtahapan, lunas FROM transaksi JOIN customer ON customer_idcustomer = idcustomer JOIN resume_daftar_pemrosesan on idtransaksi = transaksi_idtransaksi JOIN tahapan on idtahapan = tahapan_idtahapan WHERE 1 = 1";
            // $query = "SELECT * FROM transaksi JOIN customer ON customer_idcustomer = idcustomer JOIN resume_daftar_pemrosesan on idtransaksi = transaksi_idtransaksi WHERE 1 = 1";

            if (!empty($q)) {
                $query .= $cond0;
                array_push($param, "%" . $q . "%");
            }
            if (!empty($tglstart) && !empty($tglend)) {
                $query .= $cond1;
                array_push($param, $tglstart);
                array_push($param, $tglend);
            }
            if (!empty($lunas)) {
                $query .= $cond2;
                array_push($param, $lunas);
            }
            if (!empty($idpembayaran)) {
                $query .= $cond3;
                array_push($param, $idpembayaran);
            }
            if (!empty($idtahapan)) {
                $query .= $cond4;
                array_push($param, $idtahapan);
            }
            if (!empty($idoutlet)) {
                $query .= $cond5;
                array_push($param, $idoutlet);
            }
            $query .= " order by tanggal_terima desc";
            $cari_res = $this->db->query($query, $param);

            // SET JSON TRUE
            $res = $cari_res->result_array();
            $result['success'] = true;
            $result['message'] = "Fetching success";
            $result['data'] = $res;

            // SET JSON FALSE
        } else {
            $result['success'] = false;
            $result['message'] = "Token not registered";
            $result['data'] = null;

        }
        return $result;

    }

    /**
     * Get data dari tabel transaksi
     * input        = token, id outlet, id transaksi, nama customer
     * output       = JSON -> success, message, data tabel transaksi
     */
    public function retrieveTransaksi($token, $idtransaksi) {
        // Prepare JSON
        $result = array(
            'success' => false,
            'message' => null,
            'data' => null,
            'row' => null,
        );
        if ($this->checkToken($token)) {

            $transaksi_res = $this->db->query("SELECT lunas, tahapan.nama nama_tahapan, transaksi.customer_idcustomer idcustomer, customer.nama nama_customer, telp, tanggal_pengantaran, lokasi FROM transaksi JOIN customer ON customer_idcustomer = idcustomer JOIN resume_daftar_pemrosesan on idtransaksi = transaksi_idtransaksi JOIN tahapan on idtahapan = tahapan_idtahapan LEFT JOIN alamat on idalamat = idalamat_antar WHERE 1 = 1 AND idtransaksi like ?", $idtransaksi);

            // select * from transaksi join daftar_pemrosesan on idtransaksi = transaksi_idtransaksi join tahapan on idtahapan = tahapan_idtahapan order by daftar_pemrosesan.waktu desc limit 1

            // SET JSON TRUE
            $res = $transaksi_res->result_array();
            $result['success'] = true;
            $result['message'] = "Fetching success";
            $result['row'] = $res[0];

            // SET JSON FALSE
        } else {
            $result['success'] = false;
            $result['message'] = "Token not registered";
            $result['row'] = null;

        }
        return $result;

    }

    /**
     * Get data dari tabel detlayanan
     * input        = token, id transaksi
     * output       = JSON -> success, message, data tabel detlayanan
     */
    public function retrieveDetailLayanan($token, $idtransaksi) {
        // Prepare JSON
        $result = array(
            'success' => false,
            'message' => null,
            'data' => null,
            'row' => null,
        );
        if ($this->checkToken($token)) {
            $layanan_res = $this->db->query("select transaksi_idtransaksi idtransaksi, idlayanan, nama_layanan, jumlah_beli, harga " .
                "from detlayanan join layanan on idlayanan=detlayanan.layanan_idlayanan join harga_layanan on idlayanan=harga_layanan.layanan_idlayanan " .
                "where transaksi_idtransaksi=? ",
                $idtransaksi);

            // SET JSON TRUE
            $res = $layanan_res->result_array();
            $result['success'] = true;
            $result['message'] = "Fetching success";
            $result['data'] = $res;

            // SET JSON FALSE
        } else {
            $result['success'] = false;
            $result['message'] = "Token not registered";
            $result['data'] = null;

        }
        return $result;
    }

    /**
     * Get data dari tabel detitem
     * input        = token, id transaksi, id layanan
     * output       = JSON -> success, message, data tabel detitem
     */
    public function retrieveDetailItem($token, $param) {
        $result = array(
            'success' => false,
            'message' => null,
            'data' => null,
            'row' => null,
        );
        if ($this->checkToken($token)) {
            $item_res = $this->db->query("select iditem, layanan_idlayanan idlayanan, transaksi_idtransaksi idtransaksi, jumlah_item, nama " .
                "from detitem join item on iditem=item_iditem " .
                "where transaksi_idtransaksi=? and layanan_idlayanan = ? ",
                $param);

            // SET JSON TRUE
            $res = $item_res->result_array();
            $result['success'] = true;
            $result['message'] = "Fetching success";
            $result['data'] = $res;

            // SET JSON FALSE
        } else {
            $result['success'] = false;
            $result['message'] = "Token not registered";
            $result['data'] = null;

        }
        return $result;
    }

    /**
     * Get data dari tabel pembayaran_umum
     * input        = token, id transaksi
     * output       = JSON -> success, message, data tabel pembayaran_umum
     */
    public function retrieveDetailPembayaran($token, $idtransaksi) {
        $result = array(
            'success' => false,
            'message' => null,
            'data' => null,
            'row' => null,
        );
        if ($this->checkToken($token)) {
            $pembayaran_res = $this->db->query("select * " .
                "from pembayaran_umum " .
                "where transaksi_idtransaksi=? ",
                $idtransaksi);

            // SET JSON TRUE
            $res = $pembayaran_res->result_array();
            $result['success'] = true;
            $result['message'] = "Fetching success";
            $result['row'] = $res[0];

            // SET JSON FALSE
        } else {
            $result['success'] = false;
            $result['message'] = "Token not registered";
            $result['data'] = null;

        }
        return $result;
    }

    public function retrieveJadwalAntar($token, $idoutlet) {
        $result = array(
            'success' => false,
            'message' => null,
            'data' => null,
            'row' => null,
        );

        if ($this->checkToken($token)) {
            $jadwal_res = $this->db->query("SELECT customer.nama nama_customer, tanggal_pengantaran, alamat.lokasi alamat_antar, surat_antar FROM transaksi JOIN customer on customer_idcustomer = idcustomer JOIN alamat on idalamat_antar = idalamat WHERE outlet_idoutlet = ?", $idoutlet);

            //SET JSON TRUE
            $res = $jadwal_res->result_array();
            $result['success'] = true;
            $result['message'] = "Fetching success";
            $result['data'] = $res;

            // SET JSON FALSE
        } else {
            $result['success'] = false;
            $result['message'] = "Token not registered";
            $result['data'] = null;
        }
        return $result;
    }

    private function checkToken($token) {
        return $this->db->query("select * from log_token where token = ? and valid = 1", array($token))->num_rows() > 0;
    }
}
