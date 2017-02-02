<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmoneyModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Get data Emoney
     */

    public function getEMoney($token, $param)
    {
        $result = array(
            'success' => false,
            'message' => null,
            'data'    => null,
            'row'     => null,
        );
        if ($this->checkToken($token)) {
            $emoney_res = $this->db->query("select iddata_emoney, nama, saldo, masa_aktif, harga_emoney, outlet_idoutlet " .
                "from data_emoney " .
                "join data_emoney_outlet " .
                "on iddata_emoney = data_emoney_iddata_emoney " .
                "where outlet_idoutlet=? and nama like ?",
                $param);
            $res               = $emoney_res->result_array();
            $result['success'] = true;
            $result['message'] = "Fetching success";
            $result['data']    = $res;
        } else {
            $result['success'] = false;
            $result['message'] = "Token not registered";
            $result['data']    = null;

        }
        return $result;
    }

    /**
     * set pembelian emoney
     */
    public function setPembelian($token, $param)
    {
        $result = array(
            'success' => false,
            'message' => null,
            'data'    => null,
            'row'     => null,
        );
        if ($this->checkToken($token)) {
            $res = $this->db->query("insert into pembelian_emoney values (?,?,?,?,?,?)", $param);
            if ($this->db->affected_rows() > 0) {
                $result['success'] = true;
                $result['message'] = "Input data pembelian sukses";
            } else {
                $result['message'] = "Input data gagal";
            }
            // token not valid
        } else {
            $result['success'] = false;
            $result['message'] = "Token not registered";
            $result['data']    = null;
        }
        return $result;
    }
    /**
     * set pembayaran pembelian emoney
     */
    public function setPembayaran($token, $param)
    {
        $result = array(
            'success' => false,
            'message' => null,
            'data'    => null,
            'row'     => null,
        );
        if ($this->checkToken($token)) {
            $res = $this->db->query("insert into pembayaran_pembelian_emoney values (?,?,?,?)", $param);
            if ($this->db->affected_rows() > 0) {
                $result['success'] = true;
                $result['message'] = "Input data pembayaran sukses";
            } else {
                $result['message'] = "Input data gagal";
            }
        } else {
            $result['success'] = false;
            $result['message'] = "Token not registered";
            $result['data']    = null;
        }
        return $result;
    }

    /**
     * set detail pembelian sekalian set sirkulasi dan resume nya
     */
    public function setDetailPembelian($token, $param)
    {
        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $res = $this->db->query("insert into detail_pembelian_emoney values (?,?,?)", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Input data detail emoney sukses");
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Input data detail emoney gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    // penggunaan emoney

    // public function setPenggunaan($token, $param)
    // {
    //     $result = array(
    //         'success' => false,
    //         'message' => null,
    //         'data'    => null,
    //         'row'     => null,
    //     );
    //     $idcustomer = $param[1];
    //     $keluar     = $param[3];
    //     if ($this->checkToken($token)) {
    //         $this->revokeHangus($idcustomer);

    //         // echo $this->getSaldo($idcustomer).".".$keluar;
    //         if ($this->getSaldo($idcustomer) > $keluar) {
    //             // $param[5] = $this->getTanggalExpired($idcustomer);
    //             if ($this->setSirkulasiKeluar($param)) {
    //                 $result['success'] = true;
    //             } else {
    //                 $result['success'] = false;
    //                 $result['message'] = "Kesalahan dalam memasukkan data";
    //             }

    //         } else {
    //             $result['success'] = false;
    //             $result['message'] = "Saldo tidak mencukupi";
    //         }
    //     } else {
    //         $result['success'] = false;
    //         $result['message'] = "Token not registered";
    //         $result['data']    = null;
    //     }
    //     return $result;

    // }

    public function getPembelianEmoney($token, $param)
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select pe.idpembelian_emoney as idpembelian, pe.customer_idcustomer as idcustomer, customer.nama as nama_customer, tgl_beli as tanggal_beli, keterangan, tagihan, nominal, kembalian from pembelian_emoney pe join customer on customer_idcustomer = idcustomer join pembayaran_pembelian_emoney ppe on pe.idpembelian_emoney = ppe.idpembelian_emoney where pe.idpembelian_emoney like ? order by pe.tgl_beli desc", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data daftar pembelian emoney berhasil");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function penggunaanEmoney($token, $param)
    {
        $rb = new ResultBuilder();
        $idcustomer = $param[0];
        $keluar = $param[1];

        if ($this->checkToken($token)) {
            $this->revokeHangus($idcustomer);

            if ($this->getSaldo($idcustomer) > $keluar) {
                $res = $this->db->query("insert into sirkulasi_emoney values (null,?,0,?,null,null,null,?,null)", $param);
                if ($this->db->affected_rows() > 0) {
                    $rb->setSuccess(true);
                    $rb->setMessage("Input data penggunaan emoney sukses");

                } else {
                    $rb->setSuccess(false);
                    $rb->setMessage("Input data penggunaan emoney gagal");
                }
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function getEmoneyCustomer($token, $param)
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select customer_idcustomer as idcustomer, customer.nama as nama_customer, saldo, tanggal_expired as masa_aktif from resume_emoney join customer on customer_idcustomer = idcustomer where idcustomer = ?", $param)->result_array();
            $rb->setRow($res[0]);
            $rb->setMessage("Pengambilan data customer emoney berhasil");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function getDetailBeliEmoney($token, $param)
    {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select dpe.data_emoney_iddata_emoney as idemoney, de.nama as nama_emoney, de.saldo, dpe.jumlah as jumlah_beli, deo.harga_emoney as harga from detail_pembelian_emoney dpe join data_emoney de on dpe.data_emoney_iddata_emoney = de.iddata_emoney join data_emoney_outlet deo on dpe.data_emoney_iddata_emoney = deo.data_emoney_iddata_emoney where pembelian_emoney_idpembelian_emoney = ?", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data detail pembelian emoney berhasil");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    /**
     * Private function
     *
     * fungsi yang dipake di model ini sendiri
     *
     */
    // ngisi tabel sirkulasi
    private function setSirkulasiMasuk($param)
    {
        $hangus = $param[6];
        // insert data baru
        $res = $this->db->query("insert into sirkulasi_emoney values (?,?,?,?,?,?,?,?,?)", $param);

        // update tanggal expired emoney yang belum hangus
        $res2 = $this->db->query("update sirkulasi_emoney set tanggal_expired = ? where customer_idcustomer = ? and hangus = 0 and hangus <> 2", array($param[5], $param[1]));
        $this->setResumeSirkulasi($param[1]);

        // set ke jurnal keuangan
        // ......
        return ($this->db->affected_rows() > 0);
    }

    private function setSirkulasiKeluar($param)
    {
        // insert data baru
        $res = $this->db->query("insert into sirkulasi_emoney values (?,?,?,?,?,?,?,?,?)", $param);
        $this->setResumeSirkulasi($param[1]);
        return ($this->db->affected_rows() > 0);
    }

    // bikin resume
    private function setResumeSirkulasi($id)
    {
        $res = $this->db->query("select customer_idcustomer, sum(masuk) - sum(keluar) as saldo, tanggal_expired from sirkulasi_emoney where hangus <> 1 and customer_idcustomer = ? group by customer_idcustomer order by tanggal_expired desc", array($id))->result_array()[0];
        $this->db->query("replace into resume_emoney values (?,?,?)", array($res['customer_idcustomer'], $res['saldo'], intval($res['tanggal_expired'])));
    }

    // dipake buat ngecek emoney yang hangus
    private function revokeHangus($id)
    {
        $now    = time() * 1000;
        $filter = $this->db->query("select idsirkulasi_emoney from sirkulasi_emoney where hangus = 0 and customer_idcustomer = ? and tanggal_expired < ?", array($id, $now))->result_array();
        for ($i = 0; $i < sizeof($filter); $i++) {
            $this->db->query("update sirkulasi_emoney set hangus = 1 where idsirkulasi_emoney = ? ", array($filter[$i]['idsirkulasi_emoney']));

            // set ke jurnal keuangan
            // ......
        }
    }

    // cek saldo
    private function getSaldo($id)
    {
        $now = time() * 1000;
        $res = $this->db->query("select saldo from resume_emoney where customer_idcustomer = ? and tanggal_expired > ?", array($id, $now));
        if ($res->num_rows > 0) {
            return $res->result_array()[0]['saldo'];
        }
        return 0;
    }

    private function getTanggalExpired($id)
    {
        $res = $this->db->query("select tanggal_expired from resume_emoney where customer_idcustomer = ? ", array($id));
        if ($res->num_rows > 0) {
            return $res->result_array()[0]['tanggal_expired'];
        }
        return 0;
    }

    private function checkToken($token)
    {
        return $this->db->query("select * from log_token where token = ? and valid = 1", array($token))->num_rows() > 0;
    }

}
