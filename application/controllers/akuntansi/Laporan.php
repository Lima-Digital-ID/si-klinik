<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('akuntansi/Tbl_akun_model');
        $this->load->model('akuntansi/Akuntansi_model');
        $this->load->model('akuntansi/Transaksi_akuntansi_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
    }

    public function index()
    {
        // $this->template->load('template','akuntansi/master_akun/tbl_akun_list');
    }

    public function laba_rugi(){
        $date=0;
        if ($this->input->post('bulan')) {
            $date=$this->input->post('tahun').'-'.$this->input->post('bulan');
        }elseif ($this->session->userdata('bulan')) {
            $date=$this->session->userdata('bulan');
        }else{
            $date=date('Y-m');
        }
        $data['bulan']=json_encode(explode('-', $date));
        $data['pendapatan']=$this->Akuntansi_model->get_laba_rugi(6, $date);
        $data['beban']=$this->Akuntansi_model->get_laba_rugi(7, $date);
        // header('Content-Type: application/json');
        // echo json_encode($data);
        // exit();
        $this->template->load('template','akuntansi/laporan/report_profit_loss', $data);
    }

    public function kas() 
    {
        $data['tahun'] = date('Y'); //Mengambil tahun saat ini
        $data['bulan'] = date('m'); //Mengambil bulan saat ini
        $data['jumlah_hari'] = cal_days_in_month(CAL_GREGORIAN, $data['bulan'], $data['tahun']);

        $akun_asset=array();
        $dataLevel0=$this->db->where('id_akun', 3)->get('tbl_akun')->result();
        foreach ($dataLevel0 as $key => $value) {

            $id_akun=$no_akun=$nama_akun=0;
            $dataLevel1=$this->db->where('level', 1)->where('id_main_akun', $value->id_akun)->get('tbl_akun')->result();

            foreach ($dataLevel1 as $k => $v) {
                $id_akun=$v->id_akun;
                $no_akun=$v->no_akun;
                $nama_akun=$v->nama_akun;
                $dataLevel2=$this->db->where('level', 2)->where('id_main_akun', $v->id_akun)->get('tbl_akun')->result();

                foreach ($dataLevel2 as $k2 => $v2) {
                    $id_akun=$v2->id_akun;
                    $no_akun=$v2->no_akun;
                    $nama_akun=$v2->nama_akun;
                    $dataLevel3=$this->db->where('level', 3)->where('id_main_akun', $v2->id_akun)->get('tbl_akun')->result();
                    foreach ($dataLevel3 as $k3 => $v3) {
                        $id_akun=$v3->id_akun;
                        $no_akun=$v3->no_akun;
                        $nama_akun=$v3->nama_akun;
                        $akun_asset[]=array(
                            'id_akun'     => $id_akun,
                            'no_akun'     => $no_akun,
                            'nama_akun'     => $nama_akun
                        );
                    }
                    if ($dataLevel3 == null) {
                        $akun_asset[]=array(
                            'id_akun'     => $id_akun,
                            'no_akun'     => $no_akun,
                            'nama_akun'     => $nama_akun
                        );
                    }
                }
                if ($dataLevel2 == null) {
                    $akun_asset[]=array(
                        'id_akun'     => $id_akun,
                        'no_akun'     => $no_akun,
                        'nama_akun'     => $nama_akun
                    );
                }
            }
        }
        $data['akun_asset']=$akun_asset;
        
        $this->db->select('*');
        $this->db->from('tbl_akun_detail');
        $this->db->join('tbl_akun', 'tbl_akun_detail.id_akun=tbl_akun.id_akun');
        $this->db->where('id_parent', 7);
        $data['akun_pengeluaran']=$this->db->get()->result();
        $this->template->load('template','akuntansi/laporan/buku_kas_pengeluaran_list', $data);  
    }
    public function rekap_mingguan(){
        $minggu=0;
        if ($this->input->post('bulan')) {
            $tahun = $this->input->post('tahun');
            $bulan = $this->input->post('bulan');
        }else{
            $tahun = date('Y'); //Mengambil tahun saat ini
            $bulan = date('m'); //Mengambil bulan saat ini
        }
        if ($this->input->post('minggu')) {
            $minggu = $this->input->post('minggu');
        }else{
            $minggu = 1;
        }
        $data['jumlah_hari'] = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $data['date']=$tahun.'-'.$bulan;
        $data['minggu']=$minggu;
        $data['bulan']=json_encode([$tahun, $bulan]);
        $this->template->load('template','akuntansi/laporan/rekap_mingguan', $data);  
    }
    public function rekap_klinik(){
        $date=date('Y-m').'-01';
        $data['rekap']=$this->Akuntansi_model->rekapPengeluaran($date);
        $this->template->load('template','akuntansi/laporan/rekap_list', $data);  
    }
    public function rekap_rt(){
        $data['date']=date('Y-m');
        $this->template->load('template','akuntansi/laporan/rekap_rumah_tangga', $data);  
    }
    public function rekap_pc(){
        $data['date']=date('Y-m');
        $this->template->load('template','akuntansi/laporan/rekap_petty_cash', $data);  
    }
    public function rekap_all(){
        $data['date']=date('Y-m');
        $data['bulan']=json_encode(explode('-', date('Y-m')));
        $this->template->load('template','akuntansi/laporan/rekap_all', $data);  
    }

}
