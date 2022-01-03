<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporankeuangan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Transaksi_model');
        $this->load->model('Periksa_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $this->_rules();
        // $this->data['rekap_laporan'] = $this->input->post('rekap_laporan') != null ? $this->input->post('rekap_laporan') : '';
        $this->data['option_tahun'] = array();
		for($i = 2015;$i <= (int)date('Y');$i++){
			$this->data['option_tahun'][$i] = $i;
		}
        
        if ($this->form_validation->run() == TRUE) {
            $this->data['rekap_laporan'] = $this->input->post('rekap_laporan');
            $this->data['filter_tanggal'] =  $this->input->post('tanggal');
            $this->data['filter_bulan'] =  $this->input->post('bulan');
            $this->data['filter_tahun'] =  $this->input->post('tahun');
            $this->data['id_klinik'] = $this->input->post('id_klinik');
            $this->data['filters'] = '';
        } else {
            $this->data['rekap_laporan'] = set_value('rekap_laporan');
            $this->data['filter_tanggal'] =  set_value('tanggal');
            $this->data['filter_bulan'] =  set_value('bulan');$this->input->post('bulan');
            $this->data['filter_tahun'] =  set_value('tahun');;
            $this->data['id_klinik'] = set_value('id_klinik');;
            $this->data['filters'] = '';
        }
        $this->template->load('template','laporankeuangan/laporan_keuangan_list', $this->data);
    } 
    public function biaya_obat(){
        $this->_rules();
        $this->data['option_tahun'] = array();
        for($i = 2015;$i <= (int)date('Y');$i++){
            $this->data['option_tahun'][$i] = $i;
        }
        
        if ($this->form_validation->run() == TRUE) {
            $this->data['rekap_laporan'] = $this->input->post('rekap_laporan');
            $this->data['filter_tanggal'] =  $this->input->post('tanggal');
            $this->data['filter_bulan'] =  $this->input->post('bulan');
            $this->data['filter_tahun'] =  $this->input->post('tahun');
            $this->data['id_klinik'] = $this->input->post('id_klinik');
            $this->data['filters'] = '';
        } else {
            $this->data['rekap_laporan'] = set_value('rekap_laporan');
            $this->data['filter_tanggal'] =  set_value('tanggal');
            $this->data['filter_bulan'] =  set_value('bulan');$this->input->post('bulan');
            $this->data['filter_tahun'] =  set_value('tahun');;
            $this->data['id_klinik'] = set_value('id_klinik');;
            $this->data['filters'] = '';
        }
        $this->template->load('template','laporankeuangan/laporan_biaya_obat', $this->data);
    }
    public function biaya_tindakan(){
        // $this->_rules();
        // $this->data['option_tahun'] = array();
        // for($i = 2015;$i <= (int)date('Y');$i++){
        //     $this->data['option_tahun'][$i] = $i;
        // }
        
        // if ($this->form_validation->run() == TRUE) {
        //     $this->data['rekap_laporan'] = $this->input->post('rekap_laporan');
        //     $this->data['filter_tanggal'] =  $this->input->post('tanggal');
        //     $this->data['filter_bulan'] =  $this->input->post('bulan');
        //     $this->data['filter_tahun'] =  $this->input->post('tahun');
        //     $this->data['id_klinik'] = $this->input->post('id_klinik');
        //     $this->data['filters'] = '';
        // } else {
        //     $this->data['rekap_laporan'] = set_value('rekap_laporan');
        //     $this->data['filter_tanggal'] =  set_value('tanggal');
        //     $this->data['filter_bulan'] =  set_value('bulan');$this->input->post('bulan');
        //     $this->data['filter_tahun'] =  set_value('tahun');;
        //     $this->data['filters'] = '';
        //     $this->data['id_klinik'] = set_value('id_klinik');;
        // }

        $this->template->load('template','laporankeuangan/laporan_biaya_tindakan');
    }

    public function biaya_pemeriksaan(){
        // $this->_rules();
        // $this->data['option_tahun'] = array();
        // for($i = 2015;$i <= (int)date('Y');$i++){
        //     $this->data['option_tahun'][$i] = $i;
        // }
        
        // if ($this->form_validation->run() == TRUE) {
        //     $this->data['rekap_laporan'] = $this->input->post('rekap_laporan');
        //     $this->data['filter_tanggal'] =  $this->input->post('tanggal');
        //     $this->data['filter_bulan'] =  $this->input->post('bulan');
        //     $this->data['filter_tahun'] =  $this->input->post('tahun');
        //     $this->data['id_klinik'] = $this->input->post('id_klinik');
        //     $this->data['filters'] = '';
        // } else {
        //     $this->data['rekap_laporan'] = set_value('rekap_laporan');
        //     $this->data['filter_tanggal'] =  set_value('tanggal');
        //     $this->data['filter_bulan'] =  set_value('bulan');$this->input->post('bulan');
        //     $this->data['filter_tahun'] =  set_value('tahun');;
        //     $this->data['id_klinik'] = set_value('id_klinik');;
        //     $this->data['filters'] = '';
        // }
        $this->template->load('template','laporankeuangan/laporan_biaya_pemeriksaan');
    }
    
    public function json($filter = null) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json_keuangan($filter);
    }

    public function json_biaya_obat($filter = null) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json_biaya_obat($filter);
    }
    public function json_biaya_tindakan($filter = null) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json_biaya_tindakan($filter);
    }
    public function excelTindakan($filter)
    {
        $data['tindakan'] = $this->Transaksi_model->json_biaya_tindakan($filter,false);
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=laporan_biaya_tindakan_$filter.xls");        
        $this->load->view('laporankeuangan/export_laporan_biaya_tindakan',$data);
    }
    public function excelBiaya($filter)
    {
        $data['biaya'] = $this->Transaksi_model->json_biaya_pemeriksaan($filter,false);
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=laporan_biaya_pemeriksaan_$filter.xls");        
        $this->load->view('laporankeuangan/export_laporan_biaya_pemeriksaan',$data);
    }

    public function json_biaya_pemeriksaan($filter = null) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json_biaya_pemeriksaan($filter);
    }
    
    public function _rules() 
    {
        $this->form_validation->set_rules('id_klinik', 'Klinik', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    
    public function excel($filter = null)
    {
        $data['data'] = $this->Transaksi_model->json_keuangan($filter,$json=false);
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=laporan_keuangan_$filter.xls");        
        $this->load->view('laporankeuangan/export_laporan_keuangan',$data);
    }
}