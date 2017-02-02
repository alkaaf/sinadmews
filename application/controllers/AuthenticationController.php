<?php
// bla
defined('BASEPATH') or exit('No direct script access allowed');

class AuthenticationController extends CI_Controller
{

    public function __construct()
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

    public function cekEmail()
    {

        $email = $this->input->post('email');

        $res = $this->AuthenticationModel->retrieveEmail($email);
        echo json_encode($res);
    }

    /**
     * Function - Menambahkan URL foto pada tabel konsumen_bayar_beli_dompet
     *
     * @param string $kode_bld      Kode dari tabel konsumen_beli_dompet
     * @param string $foto          URL foto
     *
     * @return JSON
     */
    public function loginToken()
    {

        $email      = $this->input->post('email');
        $idkaryawan = $this->input->post('karyawan');
        $token      = $this->input->post('token');

        $data = array(
            'success'  => false,
            'messages' => null,
        );

        $result = $this->AuthenticationModel->addToken($email, $idkaryawan, $token);

        if ($result == false) {
            $data['messages'] = "Add Token failed";
        } else {
            $data['success']  = true;
            $data['messages'] = "Add Token Success";
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
    public function logoutToken()
    {

        $email      = $this->input->post('email');
        $idkaryawan = $this->input->post('karyawan');
        $token      = $this->input->post('token');

        $data = array(
            'success'  => false,
            'messages' => null,
        );

        $result = $this->AuthenticationModel->removeToken($email, $idkaryawan, $token);

        if ($result == false) {
            $data['messages'] = "Remove Token failed";
        } else {
            $data['success']  = true;
            $data['messages'] = "Remove Token Success";
        }
        echo json_encode($data);
    }

}
