<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct() {
        parent::__construct();
        header('Content-Type: application/json');
    }
    public function index() {
        $rb = new ResultBuilder();
        $rb->setMessage("Alive");
        $rb->setSuccess(true);
        echo json_encode($rb->getResult());
    }
    public function cekemail() {

        // Declare GET variables
        $email = $this->input->post('email');

        // Preparing JSON data
        $data = array(
            'success' => false,
            'messages' => null,
        );

        $checkIfEmpty = $this->ModelSystem->checkRequestMethod($this->input->post());

        if ($checkIfEmpty == false) {
            $data['messages'] = "Request variables is empty, fill it properly.";
        } else {
            $result = $this->ModelSystem->checkUserExistent($email);

            if ($result == false) {
                $data['messages'] = "User does not exist";
            } else {
                $data['success'] = true;
                $data['messages'] = "User (Karyawan) exist";
                $data['success'] = $this->ModelSystem->retriveEmail($email);

            }

        }

    }
}
