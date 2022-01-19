<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporanklinik extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('Tbl_obat_alkes_bhp_model');
        $this->load->model('Tbl_diagnosa_icd10_model');
        is_login();
    }

    public function obat_keluar_terbanyak()
    {
        $this->template->load('template','laporanklinik/obat_keluar_terbanyak');
    }
    public function json_obat_keluar_terbanyak()
    {
        header('Content-Type: application/json');
        echo $this->Tbl_obat_alkes_bhp_model->obat_terbanyak();
    }
    public function icd10_terbanyak()
    {
        $this->template->load('template','laporanklinik/icd10_terbanyak');
    }
    public function json_icd10_terbanyak()
    {
        header('Content-Type: application/json');
        echo $this->Tbl_diagnosa_icd10_model->icd10_terbanyak();
    }
}