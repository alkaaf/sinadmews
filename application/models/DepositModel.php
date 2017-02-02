<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DepositModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getDeposit($token, $param) {
        $result = array(
            'success' => false,
            'message' => null,
            'data' => null,
            'row' => null,
        );

        if ($this->checkToken($token)) {
            $deposit_res = $this->db->query("select iddata_deposit, data_deposit2.nama as nama_deposit, data_deposit2.jumlah as jumlah_layanan, masa_aktif, harga, idoutlet " . "from data_deposit2 join data_deposit_outlet " .
                "on iddata_deposit = data_deposit_iddata_deposit " . "join outlet on idoutlet = outlet_idoutlet " . "where idoutlet = ? and data_deposit2.nama like ?", $param);
            $res = $deposit_res->result_array();
            $result['success'] = true;
            $result['message'] = "Fetching success";
            $result['data'] = $res;
        } else {
            $result['success'] = false;
            $result['message'] = "Token not registered";
            $result['data'] = null;
        }
        return $result;
    }

    public function buyDeposit($token, $param) {
        $rb = new ResultBuilder();
        $idpembelian = $param[0];

        if ($this->checkToken($token)) {
            $tes = $this->db->query("select idpembelian_deposit from pembelian_deposit where idpembelian_deposit = ?", $idpembelian);
            if ($tes->num_rows() > 0) {
                $rb->setSuccess(true);
            } else {
                $res = $this->db->query("insert into pembelian_deposit values (?,?,?,?,?,?)", $param);
                if ($this->db->affected_rows() > 0) {
                    $rb->setSuccess(true);
                    $rb->setMessage("Input data pembelian deposit sukses");
                } else {
                    $rb->setSuccess(false);
                    $rb->setMessage("Input data gagal");
                }
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function detailDeposit($token, $param) {
        $rb = new ResultBuilder();
        $idpembelian = $param[0];
        if ($this->checkToken($token)) {
            $tes = $this->db->query("select pembelian_deposit_idpembelian_deposit from detail_pembelian_deposit where pembelian_deposit_idpembelian_deposit = ?", $idpembelian);
            if ($tes->num_rows() > 0) {
                $rb->setSuccess(true);
            } else {
                $res = $this->db->query("insert into detail_pembelian_deposit values (?,?,?)", $param);
                if ($this->db->affected_rows() > 0) {
                    $rb->setSuccess(true);
                    $rb->setMessage("Input data detail deposit sukses");
                } else {
                    $rb->setSuccess(false);
                    $rb->setMessage("Input data detail deposit gagal");
                }
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function setBayarBeliDeposit($token, $param) {
        $rb = new ResultBuilder();
        if ($this->checkToken($token)) {
            $res = $this->db->query("insert into pembayaran_pembelian_deposit values (?,?,?,?)", $param);
            if ($this->db->affected_rows() > 0) {
                $rb->setSuccess(true);
                $rb->setMessage("Input data pembayaran deposit sukses");

            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Input data pembayaran deposit gagal");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function getPembelianDeposit($token, $param) {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select pd.idpembelian_deposit as idpembelian, pd.customer_idcustomer as idcustomer, customer.nama as nama_customer, tanggal_beli, keterangan, tagihan, nominal, kembalian from pembelian_deposit pd join customer on customer_idcustomer = idcustomer join pembayaran_pembelian_deposit ppd on pd.idpembelian_deposit = ppd.idpembelian_deposit where pd.idpembelian_deposit like ? order by pd.tanggal_beli desc", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data daftar pembelian deposit berhasil");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function penggunaanDeposit($token, $param) {
        $rb = new ResultBuilder();
        $idcustomer = $param[0];
        $keluar = $param[1];
        $iddeposit = $param[3];

        if ($this->checkToken($token)) {
            $this->revokeHangus($idcustomer, $iddeposit);
            if ($this->getJumlahDeposit($idcustomer, $iddeposit) > $keluar) {
                $res = $this->db->query("insert into sirkulasi_deposit values (null,?,0,?,null,null,null,?,null,?)", $param);
                if ($this->db->affected_rows() > 0) {
                    $rb->setSuccess(true);
                    $rb->setMessage("Input data penggunaan deposit sukses");

                } else {
                    $rb->setSuccess(false);
                    $rb->setMessage("Input data penggunaan deposit gagal");
                }
            } else {
                $rb->setSuccess(false);
                $rb->setMessage("Saldo tidak mencukupi");
            }
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function getDepositCustomer($token, $param) {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select customer_idcustomer as idcustomer, customer.nama as nama_customer, data_deposit_iddata_deposit as iddeposit, data_deposit2.nama as nama_deposit, resume_deposit.jumlah, tanggal_expired, layanan_idlayanan idlayanan from resume_deposit join customer on customer_idcustomer = idcustomer join data_deposit2 on data_deposit_iddata_deposit = iddata_deposit where idcustomer = ?", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data deposit customer berhasil");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    public function getDetailBeliDeposit($token, $param) {
        $rb = new ResultBuilder();

        if ($this->checkToken($token)) {
            $res = $this->db->query("select dpd.data_deposit_iddata_deposit as iddeposit, dd.nama as nama_deposit, dd.jumlah, dpd.jumlah as jumlah_beli, ddo.harga from detail_pembelian_deposit dpd join data_deposit2 dd on dpd.data_deposit_iddata_deposit = dd.iddata_deposit join data_deposit_outlet ddo on dpd.data_deposit_iddata_deposit = ddo.data_deposit_iddata_deposit where pembelian_deposit_idpembelian_deposit = ?", $param)->result_array();
            $rb->setData($res);
            $rb->setMessage("Pengambilan data detail pembelian deposit berhasil");
            $rb->setSuccess(true);
        } else {
            $rb->setSuccess(false);
            $rb->setMessage("Token not registered");
        }
        return $rb->getResult();
    }

    private function getJumlahDeposit($id, $deposit) {
        $now = time() * 1000;
        // $res = $this->db->query("select jumlah from resume_deposit where customer_idcustomer = ? and data_deposit_iddata_deposit = ? and tanggal_expired > ?", array($id, $deposit, $now));
        $res = $this->db->query("select jumlah from resume_deposit where customer_idcustomer = ? and data_deposit_iddata_deposit = ? and tanggal_expired > GET_MILLS()", array($id, $deposit)); // <--- yang ini. jangan pake time(). nanti yang emoney juga kamu ubah.

        if ($res->num_rows > 0) {
            // tambahan

            return $res->result_array()[0]['jumlah'];
        }
        return 0;
    }

    private function revokeHangus($id, $deposit) {
        $now = time() * 1000;
        $filter = $this->db->query("select idsirkulasi_deposit from sirkulasi_deposit where hangus = 0 and customer_idcustomer = ? and data_deposit_iddata_deposit = ? and tanggal_expired < ?", array($id, $deposit, $now))->result_array();
        for ($i = 0; $i < sizeof($filter); $i++) {
            $this->db->query("update sirkulasi_deposit set hangus = 1 where idsirkulasi_deposit = ? ", array($filter[$i]['idsirkulasi_deposit']));

            // set ke jurnal keuangan
            // ......
        }
    }

    private function checkToken($token) {
        return $this->db->query("select * from log_token where token = ? and valid = 1", array($token))->num_rows() > 0;
    }
}
