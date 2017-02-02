<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DatadownloadController extends CI_Controller {

	public function __construct ()
	{
		parent::__construct();
		header('Content-Type: application/json');

	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	  /**
   * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
   *
   * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
   * @param string $foto          URL foto
   * 
   * @return JSON
   */
	public function customerOutlet(){

		$token = $this->input->post('token');
		$idoutlet = $this->input->post('outlet');

		$data = array (
			'success' => FALSE,
			'messages' => NULL 
			);

		$result = $this->DatadownloadModel->retrieveCustomer ($token, $idoutlet);

				if ($result == FALSE) {
				$data['messages'] = "Error when retriving Customer";
				
				} else {
					$data['success'] = TRUE;
					$data['messages'] = "Customer exist";
					$data['data'] = $result;
				}
				
		echo json_encode($data);

	}
	
	  /**
   * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
   *
   * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
   * @param string $foto          URL foto
   * 
   * @return JSON
   */
	public function customerAlamat(){

		$token = $this->input->post('token');
		$idoutlet = $this->input->post('outlet');

		$data = array (
			'success' => FALSE,
			'messages' => NULL 
			);

		$result = $this->DatadownloadModel->retrieveAlamat($token, $idoutlet);

				if ($result == FALSE) {
				$data['messages'] = "Error when retriving Customer";
				
				} else {
					$data['success'] = TRUE;
					$data['messages'] = "Customer exist";
					$data['data'] = $result;
				}
				
		echo json_encode($data);

	}
	
	  /**
   * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
   *
   * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
   * @param string $foto          URL foto
   * 
   * @return JSON
   */
	public function layananOutlet(){

		$token = $this->input->post('token');
		$idoutlet = $this->input->post('outlet');

		$data = array (
			'success' => FALSE,
			'messages' => NULL 
			);

		$result = $this->DatadownloadModel->retrieveLayanan($token, $idoutlet);

				if ($result == FALSE) {
				$data['messages'] = "Error when retriving Layanan";
				
				} else {
					$data['success'] = TRUE;
					$data['messages'] = "Layanan exist";
					$data['data'] = $result;
				}
				
		echo json_encode($data);

	}

	  /**
   * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
   *
   * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
   * @param string $foto          URL foto
   * 
   * @return JSON
   */
	public function itemOutlet(){

		$token = $this->input->post('token');
		$idoutlet = $this->input->post('outlet');

		$data = array (
			'success' => FALSE,
			'messages' => NULL 
			);

		$result = $this->DatadownloadModel->retrieveItem($token, $idoutlet);

				if ($result == FALSE) {
				$data['messages'] = "Error when retriving Item";
				
				} else {
					$data['success'] = TRUE;
					$data['messages'] = "Item exist";
					$data['data'] = $result;
				}
				
		echo json_encode($data);

	}

	  /**
   * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
   *
   * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
   * @param string $foto          URL foto
   * 
   * @return JSON
   */
	public function dataSatuan(){

		$token = $this->input->post('token');

		$data = array (
			'success' => FALSE,
			'messages' => NULL 
			);

		$result = $this->DatadownloadModel->retrieveSatuan($token);

				if ($result == FALSE) {
				$data['messages'] = "Error when retriving Data Satuan";
				
				} else {
					$data['success'] = TRUE;
					$data['messages'] = "Data Satuan exist";
					$data['data'] = $result;
				}
				
		echo json_encode($data);

	}

	public function listParfum(){

		$token = $this->input->post('token');
		$idowner = $this->input->post('idowner');

		$data = array (
			'success' => FALSE,
			'messages' => NULL 
			);

		$result = $this->DatadownloadModel->retrieveParfum($token, $idowner);

				if ($result == FALSE) {
				$data['messages'] = "Error when retriving Parfum";
				
				} else {
					$data['success'] = TRUE;
					$data['messages'] = "Parfum exist";
					$data['data'] = $result;
				}
				
		echo json_encode($data);
	}
	
}

