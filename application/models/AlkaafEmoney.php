<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlkaafEmoney extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getEMoney($token, $idoutlet, $namapaket)
    {
        $result = array(
            'success' => false,
            'message' => null,
            'data'    => null,
            'row'	=> null
        );
        // $q = $this->db->query("select * from log_token where token = ?", array($token));
        if ($this->checkToken($token)) {
        	$emoney_res = $this->db->query("select iddata_emoney, nama, saldo, masa_aktif, harga_emoney, outlet_idoutlet from data_emoney join data_emoney_outlet on iddata_emoney = data_emoney_iddata_emoney where outlet_idoutlet=? and nama like ?",array($idoutlet,"%".$namapaket."%"));
        	$res = $emoney_res->result_array();
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

    private function checkToken($token){
    	return $this->db->query("select * from log_token where token = ?",array($token))->num_rows() > 0;
    }
}
