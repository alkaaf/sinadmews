<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EMoney extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getEMoney($token,$idoutlet){
    	echo "something from model";
    }
}