<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Komisi_dokter extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_dokter_model');
        $this->load->model('Tbl_komisi_dokter_model');
    }
    public function index()
    {
        $data['dokter'] = $this->Tbl_dokter_model->get_all();

        if(isset($_GET['id_dokter'])){
            $data['komisi'] = $this->Tbl_komisi_dokter_model->getKomisi($_GET['id_dokter'],$_GET['dari'],$_GET['sampai']);
        }

        $this->template->load('template','dokter/komisi_dokter',$data);
    }

}