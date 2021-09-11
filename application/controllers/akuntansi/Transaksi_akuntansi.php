<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi_akuntansi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('akuntansi/Transaksi_akuntansi_model');
        $this->load->model('akuntansi/Tbl_akun_model');
        $this->load->model('akuntansi/Akuntansi_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
    }

    public function index()
    {
        $bulan=date('m');
        $tahun=date('Y');
        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        $date=0;
        if ($this->input->post('date')) {
            $date=$this->input->post('date');
        }else{
            $date=date('Y-m-d');
        }
        $data['bulan']=json_encode(explode('-', $date));
        $data['tgl_tutup_buku']=date('Y-m').'-'.$jumlah_hari;
        $data['data']=$this->Transaksi_akuntansi_model->getJurnalByDate($date);
        $this->template->load('template','akuntansi/transaksi_akuntansi/transaksi_akuntansi_list', $data);
    } 

    public function petty()
    {
        $date=0;
        if ($this->input->post('date')) {
            $date=$this->input->post('date');
        }else{
            $date=date('Y-m-d');
        }
        $row=$this->db->where('nama_akun', 'petty cash')->get('tbl_akun')->row();
        $data['bulan']=json_encode(explode('-', $date));
        $data['data']=$this->Transaksi_akuntansi_model->getJurnalPettyByDate($date, $row->id_akun);
        $this->template->load('template','akuntansi/transaksi_akuntansi/petty_cash_list', $data);
    } 
    public function rt()
    {
        $date=0;
        if ($this->input->post('date')) {
            $date=$this->input->post('date');
        }else{
            $date=date('Y-m-d');
        }
        $data['bulan']=json_encode(explode('-', $date));
        $data['data']=$this->Transaksi_akuntansi_model->getJurnalRTByDate($date);
        $this->template->load('template','akuntansi/transaksi_akuntansi/rumah_tangga_list', $data);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Transaksi_akuntansi_model->json();
    }

    public function getJurnalByDate() {
        $date=0;
        if ($_POST['date']) {
            
        }else{
            $date=date('Y-m');
        }
        $data=$this->Transaksi_akuntansi_model->getJurnalByDate($date);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function getDetailKas($id) {
        $data=array();
        foreach ($this->Transaksi_akuntansi_model->getDetailKas($id) as $key => $value) {
            $row=array();
            $tanggal=date_create($value->tanggal);
            // $row['tanggal']= date_format($tanggal, 'd-m-Y');
            $row['tanggal']= $value->tanggal;
            $row['no_akun']= $value->no_akun;
            $row['nama_akun']= $value->nama_akun;
            $row['deskripsi']= $value->deskripsi;
            $row['harga']= $value->jumlah;
            $row['jumlah']= "Rp. ".number_format($value->jumlah, 0, '.', '.');
            $row['tipe']= $value->tipe;
            $row['keterangan']= $value->keterangan;
            $data[]=$row;
        }
        
        echo json_encode($data);
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('akuntansi/transaksi_akuntansi/create_action'),
            'id_akun' => set_value('id_akun'),
            'nama_akun' => set_value('nama_akun'),
    );
        $data['akun_option']=array();
        $data['akun_option'][''] = 'Pilih Akun / No Akun';
        $akun_option_js=array();
        $dataLevel0=$this->db->where('level', 0)->get('tbl_akun')->result();
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
                        $data['akun_option'][$id_akun]=$no_akun. ' | '.$nama_akun;
                        $akun_option_js[]=array(
                            'label'     => $id_akun,
                            'value'     => $no_akun. ' | '.$nama_akun
                        );
                    }
                    $data['akun_option'][$id_akun]=$no_akun. ' | '.$nama_akun;
                    if ($dataLevel3 == null) {
                        $akun_option_js[]=array(
                            'label'     => $id_akun,
                            'value'     => $no_akun. ' | '.$nama_akun
                        );
                    }
                }
                $data['akun_option'][$id_akun]=$no_akun. ' | '.$nama_akun;
                if ($dataLevel2 == null) {
                    $akun_option_js[]=array(
                        'label'     => $id_akun,
                        'value'     => $no_akun. ' | '.$nama_akun
                    );
                }
            }
        }
        $data['akun_option_js']=$akun_option_js;
        $data['akun_option_js']=json_encode($akun_option_js);
        
        $this->template->load('template','akuntansi/transaksi_akuntansi/transaksi_akuntansi_create', $data);
    }

    public function create_pc() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('akuntansi/transaksi_akuntansi/save_trx_pc'),
            'id_akun' => set_value('id_akun'),
            'nama_akun' => set_value('nama_akun'),
    );
        $data['akun_option']=array();
        $data['akun_option'][''] = 'Pilih Akun / No Akun';
        $akun_option_js=array();
        foreach ($this->Tbl_akun_model->get_all_beban() as $key => $value) {
            if ($value->level != 0) {    
                $data['akun_option'][$value->id_akun]=$value->no_akun. ' | '.$value->nama_akun;
                $akun_option_js[]=array(
                    'label'     => $value->id_akun,
                    'value'     => $value->no_akun. ' | '.$value->nama_akun
                );
            }
        }
        $data['akun_option_js']=json_encode($akun_option_js);
        
        $this->template->load('template','akuntansi/transaksi_akuntansi/trx_petty_cash', $data);
    }

    public function create_rt() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('akuntansi/transaksi_akuntansi/save_trx_rt'),
            'id_akun' => set_value('id_akun'),
            'nama_akun' => set_value('nama_akun'),
        );
        $data['akun_option']=array();
        $data['akun_option'][''] = 'Pilih Akun / No Akun';
        $akun_option_js=array();
        foreach ($this->Tbl_akun_model->get_all_beban() as $key => $value) {
            if ($value->level != 0) {    
                $data['akun_option'][$value->id_akun]=$value->no_akun. ' | '.$value->nama_akun;
                $akun_option_js[]=array(
                    'label'     => $value->id_akun,
                    'value'     => $value->no_akun. ' | '.$value->nama_akun
                );
            }
        }
        $data['akun_option_js']=json_encode($akun_option_js);
        
        $this->template->load('template','akuntansi/transaksi_akuntansi/trx_rumah_tangga', $data);
    }
    
    public function create_action() 
    {
        $deskripsi=$this->input->post('deskripsi');
        $tgl=$this->input->post('tgl');
        $id_akun=$this->input->post('akun');
        $jumlah=$this->input->post('jumlah_akun');
        $tipe_akun=$this->input->post('tipe_akun');
        $id_lawan=$this->input->post('lawan_akun');
        $jumlah_lawan=$this->input->post('jumlah_lawan');
        $tipe_akun_lawan=$this->input->post('tipe_akun_lawan');
        $data_trx=array(
                        'deskripsi'     => $deskripsi,
                        'tanggal'       => $tgl,
                    );
        $insert=$this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi', $data_trx);
        $insert=1;
        if ($insert == 1) {
            $id_last=$this->db->select_max('id_trx_akun')->from('tbl_trx_akuntansi')->get()->row();
            
            $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => $id_akun,
                        'jumlah'        => $jumlah,
                        'tipe'          => ($this->input->post('tipe_akun') == 0 ? 'KREDIT' : 'DEBIT'),
                        'keterangan'    => 'akun',
                    );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            // $this->updateSaldo($id_akun, $jumlah, $tipe_akun);
            for ($i=0; $i < count($id_lawan); $i++) { 
                if ($id_lawan[$i] != null) {
                    $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => $id_lawan[$i],
                        'jumlah'        => $jumlah_lawan[$i],
                        'tipe'          => ($tipe_akun_lawan[$i] == 0 ? 'KREDIT' : 'DEBIT'),
                        'keterangan'    => 'lawan',
                    );
                    // $this->updateSaldo($id_lawan[$i], $jumlah_lawan[$i], $tipe_akun_lawan[$i]);
                    $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                }
            }
        }
        $this->session->set_flashdata('message', 'Create Record Success 2');
        redirect(site_url('akuntansi/transaksi_akuntansi'));
    }
    private function updateSaldo($id_akun, $jumlah, $tipe){
        $row=$this->db->where('id_akun', $id_akun)->get('tbl_akun')->row();
        $row_saldo=$this->db->where('id_akun', $id_akun)->where('is_updated', 1)->where('tanggal', date('Y-m'))->get('tbl_saldo_akun')->row();
        if ($tipe == 1) {
            if ($row->sifat_debit == 1) {
                if (count($row_saldo) == 1) {
                    $total=$row_saldo->jumlah_saldo+$jumlah;
                    $data_saldo=array(
                        'jumlah_saldo'  => $total
                    );
                    $this->db->where('id_saldo', $row_saldo->id_saldo);
                    $this->db->update('tbl_saldo_akun', $data_saldo);
                }else{
                    $data_saldo=array(
                        'id_akun'   => $id_akun,
                        'jumlah_saldo'  => $jumlah,
                        'tanggal'   => date('Y-m'),
                        'is_updated'   => 0,
                    );
                    $this->db->insert('tbl_saldo_akun', $data_saldo);
                    $data_saldo=array(
                        'id_akun'   => $id_akun,
                        'jumlah_saldo'  => $jumlah,
                        'tanggal'   => date('Y-m'),
                        'is_updated'   => 1,
                    );
                    $this->db->insert('tbl_saldo_akun', $data_saldo);
                }
            }else{
                if (count($row_saldo) == 1) {
                    $total=$row_saldo->jumlah_saldo-$jumlah;
                    $data_saldo=array(
                        'jumlah_saldo'  => $total
                    );
                    $this->db->where('id_saldo', $row_saldo->id_saldo);
                    $this->db->update('tbl_saldo_akun', $data_saldo);
                }else{
                    $total=0;
                    $total-=$jumlah;
                    $data_saldo=array(
                        'id_akun'   => $id_akun,
                        'jumlah_saldo'  => $total,
                        'tanggal'   => date('Y-m'),
                        'is_updated'   => 0,
                    );
                    $this->db->insert('tbl_saldo_akun', $data_saldo);
                    $data_saldo=array(
                        'id_akun'   => $id_akun,
                        'jumlah_saldo'  => $total,
                        'tanggal'   => date('Y-m'),
                        'is_updated'   => 1,
                    );
                    $this->db->insert('tbl_saldo_akun', $data_saldo);
                }
            }
        }else{
            if ($row->sifat_kredit == 1) {
                if (count($row_saldo) == 1) {
                    $total=$row_saldo->jumlah_saldo+$jumlah;
                    $data_saldo=array(
                        'jumlah_saldo'  => $total
                    );
                    $this->db->where('id_saldo', $row_saldo->id_saldo);
                    $this->db->update('tbl_saldo_akun', $data_saldo);
                }else{
                    $data_saldo=array(
                        'id_akun'   => $id_akun,
                        'jumlah_saldo'  => $jumlah,
                        'tanggal'   => date('Y-m'),
                        'is_updated'   => 1,
                    );
                    $this->db->insert('tbl_saldo_akun', $data_saldo);
                    $data_saldo=array(
                        'id_akun'   => $id_akun,
                        'jumlah_saldo'  => $jumlah,
                        'tanggal'   => date('Y-m'),
                        'is_updated'   => 0,
                    );
                    $this->db->insert('tbl_saldo_akun', $data_saldo);
                }
            }else{
                if (count($row_saldo) == 1) {
                    $total=$row_saldo->jumlah_saldo-$jumlah;
                    $data_saldo=array(
                        'jumlah_saldo'  => $total
                    );
                    $this->db->where('id_saldo', $row_saldo->id_saldo);
                    $this->db->update('tbl_saldo_akun', $data_saldo);
                }else{
                    $total=0;
                    $total-=$jumlah;
                    $data_saldo=array(
                        'id_akun'   => $id_akun,
                        'jumlah_saldo'  => $total,
                        'tanggal'   => date('Y-m'),
                        'is_updated'   => 1,
                    );
                    $this->db->insert('tbl_saldo_akun', $data_saldo);
                    $data_saldo=array(
                        'id_akun'   => $id_akun,
                        'jumlah_saldo'  => $total,
                        'tanggal'   => date('Y-m'),
                        'is_updated'   => 0,
                    );
                    $this->db->insert('tbl_saldo_akun', $data_saldo);
                }
            }
        }
    }
    public function save_trx_pc() 
    {
        $deskripsi=$this->input->post('deskripsi');
        $tgl=$this->input->post('tgl');
        $id_lawan=$this->input->post('lawan_akun');
        $jumlah_lawan=$this->input->post('jumlah_lawan');
        $data_trx=array(
                        'deskripsi'     => $deskripsi,
                        'tanggal'       => $tgl,
                    );
        $insert=$this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi', $data_trx);
        $total=0;
        if ($insert) {
            $id_last=$this->db->select_max('id_trx_akun')->from('tbl_trx_akuntansi')->get()->row();
            for ($i=0; $i < count($id_lawan); $i++) { 
                if ($id_lawan[$i] != null) {
                    $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => $id_lawan[$i],
                        'jumlah'        => $jumlah_lawan[$i],
                        'tipe'          => 'DEBIT',
                        'keterangan'    => 'akun',
                    );
                    $total+=$jumlah_lawan[$i];
                    $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                    // $this->updateSaldo($id_lawan[$i], $jumlah_lawan[$i], 1);
                }
            }
            $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 35,
                        'jumlah'        => $total,
                        'tipe'          => 'KREDIT',
                        'keterangan'    => 'lawan',
                    );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            // $this->updateSaldo(35, $total, 0);
        }
        $this->session->set_flashdata('message', 'Create Record Success 2');
        redirect(site_url('akuntansi/transaksi_akuntansi/petty'));
    }

    public function save_trx_rt() 
    {
        $deskripsi=$this->input->post('deskripsi');
        $tgl=$this->input->post('tgl');
        $id_lawan=$this->input->post('lawan_akun');
        $jumlah_lawan=$this->input->post('jumlah_lawan');
        $data_trx=array(
                        'deskripsi'     => $deskripsi,
                        'tanggal'       => $tgl,
                    );
        $insert=$this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi', $data_trx);
        $total=0;
        if ($insert) {
            $id_last=$this->db->select_max('id_trx_akun')->from('tbl_trx_akuntansi')->get()->row();
            for ($i=0; $i < count($id_lawan); $i++) { 
                if ($id_lawan[$i] != null) {
                    $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => $id_lawan[$i],
                        'jumlah'        => $jumlah_lawan[$i],
                        'tipe'          => 'DEBIT',
                        'keterangan'    => 'akun',
                    );
                    $total+=$jumlah_lawan[$i];
                    $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                    // $this->updateSaldo($id_lawan[$i], $jumlah_lawan[$i], 1);
                }
            }
            $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 36,
                        'jumlah'        => $total,
                        'tipe'          => 'KREDIT',
                        'keterangan'    => 'lawan',
                    );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            // $this->updateSaldo(36, $total, 0);
        }
        $this->session->set_flashdata('message', 'Create Record Success 2');
        redirect(site_url('akuntansi/transaksi_akuntansi/rt'));
    }
    
    public function neraca(){
        $date=0;
        if ($this->input->post('bulan')) {
            $date=$this->input->post('tahun').'-'.$this->input->post('bulan');
        }elseif ($this->session->userdata('bulan')) {
            $date=$this->session->userdata('bulan');
        }else{
            $date=date('Y-m');
        }
        $data['date']=$date;
        $data['bulan']=json_encode(explode('-', $date));
        $data['data_saldo']=$this->Akuntansi_model->cekAllJurnal($date);
        $data['saldo']=$this->Akuntansi_model->cekSaldoKas($date);
        $this->template->load('template','akuntansi/transaksi_akuntansi/neraca_coba', $data);
    }
    public function close_book(){
        $data['bulan']=date('m');
        $data['tahun']=date('Y');
        $this->template->load('template','akuntansi/transaksi_akuntansi/create_tutup_buku', $data);
    }
    public function tutup_buku(){
        $date=0;
        if ($this->input->post('bulan')) {
            $date=$this->input->post('tahun').'-'.$this->input->post('bulan');
        }elseif ($this->session->userdata('bulan')) {
            $date=$this->session->userdata('bulan');
        }else{
            $date=date('Y-m');
        }

        $bulan=explode('-', $date);
        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan[1], $bulan[0]);

        $cekJurnal=$this->db->where('tanggal', $date)->get('tbl_saldo_akun')->num_rows();
        if ($cekJurnal < 1) {
            $time = strtotime($date);
            $final = date('Y-m', strtotime("+1 month", $time));
            $jurnal=$this->Akuntansi_model->cekAllJurnal($final);
            $total_pendapatan=$total_beban=$total_kas=0;
            foreach ($jurnal as $key => $value) {
                $saldo=$this->db->where('id_akun', $value->id_akun)->where('tanggal', $date)->get('tbl_saldo_akun')->row();
                if ($value->id_parent == 3 || $value->id_parent == 7) {
                    $jumlah_saldo=(($saldo != null ? $saldo->jumlah_saldo : 0) + $value->jumlah_debit) - $value->jumlah_kredit;
                    if ($value->id_parent == 7) {
                        $total_beban+=($value->jumlah_debit - $value->jumlah_kredit);
                    }
                    if ($value->id_akun == 20) {
                        $total_kas=$jumlah_saldo;
                    }
                    $data_saldo=array(
                        'id_akun'   => $value->id_akun,
                        'jumlah_saldo'  => $jumlah_saldo,
                        'tanggal'   => $date,
                        'is_updated'   => 0,
                    );
                    $this->db->insert('tbl_saldo_akun', $data_saldo);
                }else{
                    if ($value->id_akun != 56) {
                        $jumlah_saldo=(($saldo != null ? $saldo->jumlah_saldo : 0) + $value->jumlah_kredit) - $value->jumlah_debit;
                        if ($value->id_parent == 6) {
                            $total_pendapatan+=($value->jumlah_kredit - $value->jumlah_debit);
                        }
                        $data_saldo=array(
                            'id_akun'   => $value->id_akun,
                            'jumlah_saldo'  => $jumlah_saldo,
                            'tanggal'   => $date,
                            'is_updated'   => 0,
                        );
                        $this->db->insert('tbl_saldo_akun', $data_saldo);
                    }
                }
            }
            //saldo prive yang didapat dari pendapatan bersih laporan laba rugi
            // $data_saldo=array(
            //     'id_akun'   => 56,
            //     'jumlah_saldo'  => ($total_pendapatan-$total_beban),
            //     'tanggal'   => $final,
            //     'is_updated'   => 0,
            // );
            // $this->db->insert('tbl_saldo_akun', $data_saldo);
            //update saldo kas
            // $data_saldo=array(
            //     'jumlah_saldo'  => $total_kas - ($total_pendapatan-$total_beban),
            // );
            // $this->db->where('id_akun', 20)->where('tanggal', $date)->update('tbl_saldo_akun', $data_saldo);

            // $data_trx=array(
            //     'deskripsi'     => 'Keuntungan dari Laba Rugi',
            //     'tanggal'       => $final.'-'.$jumlah_hari,
            // );
            
            // $insert=$this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi', $data_trx);
            // if ($insert) {
            //     $id_last=$this->db->select_max('id_trx_akun')->from('tbl_trx_akuntansi')->get()->row();
            //     //pendapatan masuk
            //     $data=array(
            //                 'id_trx_akun'   => $id_last->id_trx_akun,
            //                 'id_akun'       => 56,
            //                 'jumlah'        => ($total_pendapatan-$total_beban),
            //                 'tipe'          => 'KREDIT',
            //                 'keterangan'    => 'akun',
            //             );
            //     $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            //     $data=array(
            //         'id_trx_akun'   => $id_last->id_trx_akun,
            //         'id_akun'       => 20,
            //         'jumlah'        => ($total_pendapatan-$total_beban),
            //         'tipe'          => 'DEBIT',
            //         'keterangan'    => 'lawan',
            //     );
            //     $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            // }
            // print_r($total_pendapatan-$total_beban);
            // exit();
            $this->session->set_flashdata('message_type', 'success');
            $this->session->set_flashdata('message', 'Success Close Book');
            redirect('akuntansi/transaksi_akuntansi/close_book');
        }else{
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', 'Error Close Book');
            redirect('akuntansi/transaksi_akuntansi/close_book');
        }
    }

    // public function update($id) 
    // {
    //     $row = $this->transaksi_akuntansi_model->get_by_id($id);
    //     if ($row) {
    //         $data = array(
    //             'button' => 'Update',
    //             'action' => site_url('akuntansi/akun/update_action'),
    //             'id_akun' => set_value('id_akun', $row->id_akun),
    //             'nama_akun' => set_value('nama_akun', $row->nama_akun),
    //     );
    //         $this->template->load('template','akuntansi/transaksi_akuntansi/transaksi_akuntansi_create', $data);
    //     } else {
    //         $this->session->set_flashdata('message', 'Record Not Found');
    //         redirect(site_url('akuntansi/akun'));
    //     }
    // }
    
    // public function update_action() 
    // {
    //     $this->_rules();
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->update($this->input->post('id_akun', TRUE));
    //     } else {
    //         $data = array(
    //             'nama_akun' => $this->input->post('nama_akun',TRUE),
    //             'dtm_upd' => date("Y-m-d H:i:s",  time())
    //     );

    //         $this->transaksi_akuntansi_model->update($this->input->post('id_akun', TRUE), $data);
    //         $this->session->set_flashdata('message', 'Update Record Success');
    //         redirect(site_url('akuntansi/akun'));
    //     }
    // }
    public function rollback($id) 
    {
        $row = $this->Transaksi_akuntansi_model->get_trx_detail($id);
        foreach ($row as $key => $value) {
            if ($value->tipe == 'DEBIT') {
                $data=array(
                    'tipe'  => 'KREDIT'
                );
                $this->db->where('id_trx_akun_detail', $value->id_trx_akun_detail);
                $this->db->update('tbl_trx_akuntansi_detail', $data);
            }else{
                $data=array(
                    'tipe'  => 'DEBIT'
                );
                $this->db->where('id_trx_akun_detail', $value->id_trx_akun_detail);
                $this->db->update('tbl_trx_akuntansi_detail', $data);
            }
        }
        $this->session->set_flashdata('message', 'Rollback Record Success');
        redirect(site_url('akuntansi/transaksi_akuntansi'));
    }

    public function delete($id) 
    {
        $row = $this->Transaksi_akuntansi_model->get_by_id($id);
        if ($row) {
            $this->Transaksi_akuntansi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('akuntansi/transaksi_akuntansi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('akuntansi/transaksi_akuntansi'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('id_akun', 'id akun', 'trim');
        $this->form_validation->set_rules('nama_akun', 'nama akun', 'trim|required');
    }
    
    

    

}

/* End of file Dokter.php */
/* Location: ./application/controllers/Dokter.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-11-27 18:45:56 */
/* http://harviacode.com */