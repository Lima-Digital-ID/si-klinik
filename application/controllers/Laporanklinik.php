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
        $this->load->model('Transaksi_model');
        $this->load->model('Tbl_sksehat_model');
        $this->load->model('Tbl_rapid_antigen_model');
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

    public function laporan_pemeriksaan(){
        $this->template->load('template','laporanklinik/pemeriksaan');
    }
    
    public function jsonPemeriksaan($dari,$sampai) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json2(1,1,[$dari,$sampai]);
    }

    public function jsonAnak($dari,$sampai) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json2(1,2,[$dari,$sampai]);
    }

    public function jsonHamil($dari,$sampai) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json2(1,3,[$dari,$sampai]);
    }

    public function jsonJasa($dari,$sampai) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json2(1,5,[$dari,$sampai]);
    }

    public function jsonLab($dari,$sampai) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json2(1,6,[$dari,$sampai]);
    }

    public function jsonSKS($dari,$sampai) {
        header('Content-Type: application/json');
        echo $this->Tbl_sksehat_model->jsonSk(1,1,[$dari,$sampai]);
    }

    public function jsonRapid($dari,$sampai) {
        header('Content-Type: application/json');
        echo $this->Tbl_rapid_antigen_model->jsonRapid(1,1,[$dari,$sampai]);
    }

    public function laporan_suket_sehat(){
        $this->template->load('template','laporanklinik/suket_sehat');
    }

    public function laporan_rapid(){
        $this->template->load('template','laporanklinik/rapid');
    }

    public function laporan_imunisasi(){
        $this->template->load('template','laporanklinik/imunisasi');
    }

    public function laporan_kehamilan(){
        $this->template->load('template','laporanklinik/kontrol');
    }

    public function laporan_jasa(){
        $this->template->load('template','laporanklinik/jasa');
    }

    public function laporan_lab(){
        $this->template->load('template','laporanklinik/lab');
    }
}