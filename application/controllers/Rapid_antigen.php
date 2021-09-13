<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rapid_antigen extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Tbl_dokter_model');
        is_login();
    }
    public function index()
    {
        $data['data_dokter'] = $this->Tbl_dokter_model->get_all();

        $this->template->load('template','rapid_antigen/formulir_rapid_antigen',$data);
    }
}
