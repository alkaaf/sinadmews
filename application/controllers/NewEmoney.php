<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NewEmoney extends CI_Controller
{

	public function __construct(){
		parent::__construct();
		$this->load->model('AlkaafEmoney');
	}

	public function getDaftarEmoneyOutlet(){
		$token = $this->input->post('token');
		$idoutlet = $this->input->post('idoutlet');
		$namapaket = $this->input->post("nama_emoney");
		$res = $this->AlkaafEmoney->getEMoney($token,$idoutlet,$namapaket);
		echo json_encode($res);
	}
}
?>