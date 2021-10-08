<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public $id_klinik;
    public $nama_user;
    
    function __construct()
    {
        parent::__construct();
        is_login();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Transaksi_model');
        $this->load->model('Periksa_model');
        $this->load->model('Tbl_pasien_model');
        $this->load->model('Tbl_obat_alkes_bhp_model');
        $this->load->model('Tbl_dokter_model');
        $this->load->model('Tbl_komisi_dokter_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        $this->load->model('akuntansi/Transaksi_akuntansi_model');     
        $this->load->model('Tbl_sksehat_model');
        $this->load->model('Tbl_rapid_antigen_model');
        $this->id_klinik = $this->session->userdata('id_klinik');
        $this->nama_user = $this->session->userdata('full_name');
    }

    public function index()
    {
        $this->template->load('template','pembayaran/pembayaran_list');
    } 
    
    public function jsonSksehat() {
        header('Content-Type: application/json');
        echo $this->Tbl_sksehat_model->jsonSk($this->id_klinik,'0');
    }
    public function jsonSksehatLunas() {
        header('Content-Type: application/json');
        echo $this->Tbl_sksehat_model->jsonSk($this->id_klinik,'1');
    }
    public function jsonRapid() {
        header('Content-Type: application/json');
        echo $this->Tbl_rapid_antigen_model->jsonRapid($this->id_klinik,'0');
    }
    public function jsonRapidLunas() {
        header('Content-Type: application/json');
        echo $this->Tbl_rapid_antigen_model->jsonRapid($this->id_klinik,'1');
    }
    public function json($tipe=1) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json($this->id_klinik,$tipe);
    }
    
    public function json2($tipe=1) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json2($this->id_klinik,$tipe);
    }
    
    public function json_obat() {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json_obat($this->id_klinik);
    }
    
    public function json_obat2() {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json_obat2($this->id_klinik);
    }
    
    public function bayar($id_transaksi){
        $this->_rules();
        
        $data_transaksi = $this->Transaksi_model->get_by_id($id_transaksi); //Ini Row
        
        $tab = array('pemeriksaan','sks','rapid');
        // if(is_null($data_transaksi) || (empty($_GET['tab']) && !in_array($_GET['tab'],$tab))){
        if(is_null($data_transaksi) || is_null($_GET['tab']) || (isset($_GET['tab']) && !in_array($_GET['tab'],$tab))){
            //Set session error
            $this->session->set_flashdata('message', 'Data pembayaran tidak ditemukan');
            $this->session->set_flashdata('message_type', 'danger');
            
            redirect(site_url('pembayaran'));
        } 
        if($data_transaksi->status_transaksi == 1){
            //Set session error
            $this->session->set_flashdata('message', 'Data pembayaran sudah dilakukan pembayaran, No Periksa ' . $data_transaksi->no_transaksi);
            $this->session->set_flashdata('message_type', 'danger');
            
            redirect(site_url('pembayaran'));
        } 
        
        if ($this->form_validation->run() == TRUE) {
            $data_trans = array(
                'atas_nama' => $this->input->post('atas_nama'),
                'status_transaksi' => 1,
                'dtm_upd' => date("Y-m-d H:i:s",  time())
            );
            $biaya_tindakan=$biaya_pemeriksaan=$biaya_obat=0;
            foreach ($this->Transaksi_model->get_detail_by_h_id($data_transaksi->no_transaksi) as $key => $value) {
                if ($value->deskripsi == 'Biaya Pemeriksaan') {
                    $biaya_pemeriksaan=$value->amount_transaksi;
                }
                if ($value->deskripsi == 'Biaya Tindakan') {
                    $biaya_tindakan=$value->amount_transaksi;
                }
                if ($value->deskripsi == 'Total Obat-obatan') {
                    $biaya_obat=$value->amount_transaksi;
                }
            }
            $data_trans_d = array();
            if($this->input->post('subsidi_transaksi') != ''){
                $data_trans_d[] = array(
                    // 'id_transaksi' => $id_transaksi,
                    'no_transaksi' => $data_transaksi->no_transaksi,
                    'deskripsi' => 'Subsidi dari Kasir' ,
                    'amount_transaksi' => $this->input->post('subsidi_transaksi') != '' ? $this->input->post('subsidi_transaksi') : 0,
                    'dc' => 'c'
                );
            }
            $data_trans_d[] = array(
                // 'id_transaksi' => $id_transaksi,
                'no_transaksi' => $data_transaksi->no_transaksi,
                'deskripsi' => 'Pembayaran Biaya Medis' . ($this->input->post('atas_nama') != '' ? ' a/n ' . $this->input->post('atas_nama') : '' ),
                'amount_transaksi' => $this->input->post('total_pembayaran'),
                'dc' => 'c'
            );
            
            //Biaya administrasi
            $data_trans_d[] = array(
                // 'id_transaksi' => $id_transaksi,
                'no_transaksi' => $data_transaksi->no_transaksi,
                'deskripsi' => 'Biaya Administrasi',
                'amount_transaksi' => $this->input->post('biaya_administrasi') != '' ? $this->input->post('biaya_administrasi') : 0,
                'dc' => 'd'
            );
            $subsidi_transaksi=$this->input->post('subsidi_transaksi');
            $biaya_administrasi=$this->input->post('biaya_administrasi');

            $biaya=array(
                'biaya_tindakan'    => $biaya_tindakan,
                'biaya_pemeriksaan' => $biaya_pemeriksaan,
                'biaya_administrasi'=> $biaya_administrasi,
                'subsidi_transaksi' => $subsidi_transaksi,
                'no_periksa' => $data_transaksi->no_transaksi,
            );

            switch ($_GET['tab']) {
                case 'pemeriksaan':
                    $this->db->select('id_dokter');
                    $getDokter = $this->db->get_where('tbl_periksa',['no_periksa' => $data_transaksi->no_transaksi])->row();

                    $id_dokter = $getDokter->id_dokter;

                    $komisi = $this->Tbl_komisi_dokter_model->getMasterKomisi($id_dokter);
                    //komisi pemeriksaan
                    $biayaKomisi['Pemeriksaan'] = $komisi->komisi_biaya_pemeriksaan * $biaya_pemeriksaan / 100;
                    //komisi tindakan
                    $biayaKomisi['Tindakan'] = $komisi->komisi_biaya_tindakan * $biaya_tindakan / 100;
                    //komisi obat
                    $biayaKomisi['Obat'] = $komisi->komisi_biaya_obat * $biaya_obat / 100;

                    foreach ($biayaKomisi as $key => $value) {
                        $arrKomisi = array(
                            'tanggal' => date('Y-m-d'),
                            'id_dokter' => $id_dokter,
                            'no_transaksi' => $data_transaksi->no_transaksi,
                            'komisi' => $value,
                            'type' => $key
                        );

                        $this->Tbl_komisi_dokter_model->insert($arrKomisi);
                    }
                    //akuntansi masuk kemana?
                break;
                case 'sks':
                    $getDokter = $this->Tbl_sksehat_model->getDetail($data_transaksi->no_transaksi,'sk.id_dokter');
                    
                    $id_dokter = $getDokter['id_dokter'];
                    $komisi = $this->Tbl_komisi_dokter_model->getMasterKomisi($id_dokter);
                    //komisi pemeriksaan
                    $komisiPemeriksaan = $komisi->komisi_biaya_pemeriksaan * $biaya_pemeriksaan / 100;
                    $arrKomisi = array(
                        'tanggal' => date('Y-m-d'),
                        'id_dokter' => $id_dokter,
                        'no_transaksi' => $data_transaksi->no_transaksi,
                        'komisi' => $komisiPemeriksaan,
                        'type' => 'Pemeriksaan'
                    );
                    $this->Tbl_komisi_dokter_model->insert($arrKomisi);
                    //akuntansi masuk kemana?

                break;
                case 'rapid':
                    $this->db->select('id_dokter');
                    $getDokter = $this->db->get_where('tbl_rapid_antigen',['no_sampel' => $data_transaksi->no_transaksi])->row();

                    $id_dokter = $getDokter->id_dokter;
                    $komisi = $this->Tbl_komisi_dokter_model->getMasterKomisi($id_dokter);
                    //komisi pemeriksaan
                    $komisiPemeriksaan = $komisi->komisi_biaya_pemeriksaan * $biaya_pemeriksaan / 100;

                    $arrKomisi = array(
                        'tanggal' => date('Y-m-d'),
                        'id_dokter' => $id_dokter,
                        'no_transaksi' => $data_transaksi->no_transaksi,
                        'komisi' => $komisiPemeriksaan,
                        'type' => 'Pemeriksaan'
                    );
                    $this->Tbl_komisi_dokter_model->insert($arrKomisi);
                    //akuntansi masuk kemana?

                break;
                default:
                    redirect(site_url('pembayaran'));
                break;
            }


            // $this->jurnal_otomatis_pemeriksaan($biaya);

            $this->Transaksi_model->update($id_transaksi, $data_trans);
            
            for($i = 0; $i < count($data_trans_d); $i++){
                $this->Transaksi_model->insert_d($data_trans_d[$i]);
            }
            
            //Jika menggunakan metode asuransi
            if($this->input->post('metode_pembayaran') == 1){
                $data_asuransi = array(
                    'no_transaksi' => $data_transaksi->no_transaksi,
                    'amount' => $this->input->post('total_pembayaran'),
                );
                $this->db->insert('tbl_rekap_asuransi', $data_asuransi);
            }

            //Set session sukses
            $this->session->set_flashdata('message', 'Data pembayaran berhasil disimpan, No Periksa ' . $data_transaksi->no_transaksi);
            $this->session->set_flashdata('message_type', 'success');
            
            redirect(site_url('pembayaran'));
        } else {
            $this->data['id_transaksi'] = $data_transaksi->id_transaksi;
            $this->data['kode_transaksi'] = $data_transaksi->kode_transaksi;
            $this->data['klinik'] = $data_transaksi->id_klinik;
            $this->data['no_transaksi'] = $data_transaksi->no_transaksi;
            $this->data['tgl_transaksi'] = $data_transaksi->tgl_transaksi;
            $this->data['status_transaksi'] = $data_transaksi->status_transaksi;
            $this->data['total_transaksi'] = 0;
            
            $this->data['transaksi_d'] = $this->Transaksi_model->get_detail_by_h_id($data_transaksi->no_transaksi); //Ini array
            
            if($this->input->post('total_transaksi')){
                //Set session error
                $this->session->set_flashdata('message', 'Terdapat error input, silahkan cek lagi');
                $this->session->set_flashdata('message_type', 'danger');
            }
            
            // $data_periksa = $this->Periksa_model->get_by_id($data_transaksi->no_transaksi);
            // $data_pasien = $this->Tbl_pasien_model->get_by_id($data_periksa->no_rekam_medis);
            
            // $this->data['nama_pasien'] = $data_pasien->nama_lengkap;
                
        }
        $this->template->load('template','pembayaran/bayar', $this->data);
    }
    private function jurnal_otomatis_pemeriksaan($biaya){
        if ($biaya['biaya_pemeriksaan'] != 0 || $biaya['biaya_administrasi'] != 0 || $biaya['biaya_tindakan'] != 0) {
            $total=($biaya['biaya_pemeriksaan'] + $biaya['biaya_tindakan'] + $biaya['biaya_administrasi']) - $biaya['subsidi_transaksi'];
            $data_trx=array(
                'deskripsi'     => 'Pendapatan dari Nomor Pemeriksaan '.$biaya['no_periksa'],
                'tanggal'       => date('Y-m-d'),
            );
            $insert=$this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi', $data_trx);
            if ($insert) {
                $id_last=$this->db->select_max('id_trx_akun')->from('tbl_trx_akuntansi')->get()->row();
                if ($biaya['biaya_tindakan'] != 0) {
                    $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 63,
                        'jumlah'        => $biaya['biaya_tindakan'],
                        'tipe'          => 'KREDIT',
                        'keterangan'    => 'akun',
                    );
                    $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                }
                if ($biaya['biaya_pemeriksaan'] != 0) {
                    $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 62,
                        'jumlah'        => $biaya['biaya_pemeriksaan'],
                        'tipe'          => 'KREDIT',
                        'keterangan'    => 'akun',
                    );
                    $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                }
                if ($biaya['biaya_administrasi'] != 0) {
                    $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 68,
                        'jumlah'        => $biaya['biaya_administrasi'],
                        'tipe'          => 'KREDIT',
                        'keterangan'    => 'akun',
                    );
                    $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                }
                if ($biaya['subsidi_transaksi'] != 0) {
                    $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 69,
                        'jumlah'        => $biaya['subsidi_transaksi'],
                        'tipe'          => 'DEBIT',
                        'keterangan'    => 'akun',
                    );
                    $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                }
                $data=array(
                    'id_trx_akun'   => $id_last->id_trx_akun,
                    'id_akun'       => 20,
                    'jumlah'        => $total,
                    'tipe'          => 'DEBIT',
                    'keterangan'    => 'lawan',
                );
                $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            }
        }else{
            if ($biaya['subsidi_transaksi'] != 0) {
                $data_trx=array(
                    'deskripsi'     => 'Pendapatan dari Nomor Pemeriksaan '.$biaya['no_periksa'],
                    'tanggal'       => date('Y-m-d'),
                );
                $insert=$this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi', $data_trx);
                if ($insert) {
                    $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 69,
                        'jumlah'        => $biaya['subsidi_transaksi'],
                        'tipe'          => 'DEBIT',
                        'keterangan'    => 'akun',
                    );
                    $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                    $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 20,
                        'jumlah'        => $biaya['subsidi_transaksi'],
                        'tipe'          => 'KREDIT',
                        'keterangan'    => 'lawan',
                    );
                    $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                }
            }
        } 
    }
    public function rekap_asuransi(){
        $this->form_validation->set_rules('id_klinik', 'Klinik', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        
        $this->data['option_tahun'] = array();
        for($i = 2015;$i <= (int)date('Y');$i++){
            $this->data['option_tahun'][$i] = $i;
        }
        
        if ($this->form_validation->run() == TRUE) {
            $this->data['rekap_laporan'] = $this->input->post('rekap_laporan');
            $this->data['filter_tanggal'] =  $this->input->post('tanggal');
            $this->data['filter_bulan'] =  $this->input->post('bulan');
            $this->data['filter_tahun'] =  $this->input->post('tahun');
            $this->data['id_klinik'] = $this->id_klinik;
            $this->data['filters'] = '';
        } else {
            $this->data['rekap_laporan'] = set_value('rekap_laporan');
            $this->data['filter_tanggal'] =  set_value('tanggal');
            $this->data['filter_bulan'] =  set_value('bulan');
            $this->data['filter_tahun'] =  set_value('tahun');
            $this->data['id_klinik'] = $this->id_klinik;
            $this->data['filters'] = '';
        }
        
        $this->template->load('template','pembayaran/rekap_asuransi_list', $this->data);
    }
    
    public function obat_tanpa_periksa(){
        $this->template->load('template','pembayaran/pembayaran_obat');
    }
    
    public function bayar_obat($id_transaksi){
        $this->form_validation->set_rules('total_transaksi', 'Total Transaksi', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        
        $data_transaksi = $this->Transaksi_model->get_by_id($id_transaksi); //Ini Row
        
        if(is_null($data_transaksi)){
            //Set session error
            $this->session->set_flashdata('message', 'Data pembayaran tidak ditemukan');
            $this->session->set_flashdata('message_type', 'danger');
            
            redirect(site_url('pembayaran/obat_tanpa_periksa'));
        } 
        if($data_transaksi->status_transaksi == 1){
            //Set session error
            $this->session->set_flashdata('message', 'Data pembayaran sudah dilakukan pembayaran, No Periksa ' . $data_transaksi->no_transaksi);
            $this->session->set_flashdata('message_type', 'danger');
            
            redirect(site_url('pembayaran/obat_tanpa_periksa'));
        } 
        
        if ($this->form_validation->run() == TRUE) {
            $data_trans = array(
                // 'atas_nama' => $this->input->post('atas_nama'),
                'status_transaksi' => 1,
                'dtm_upd' => date("Y-m-d H:i:s",  time())
            );
            
            $data_trans_d = array();
            if($this->input->post('subsidi_transaksi') != ''){
                $data_trans_d[] = array(
                    // 'id_transaksi' => $id_transaksi,
                    'no_transaksi' => $data_transaksi->no_transaksi,
                    'deskripsi' => 'Subsidi dari Kasir' ,
                    'amount_transaksi' => $this->input->post('subsidi_transaksi') != '' ? $this->input->post('subsidi_transaksi') : 0,
                    'dc' => 'c'
                );
            }
            $data_trans_d[] = array(
                // 'id_transaksi' => $id_transaksi,
                'no_transaksi' => $data_transaksi->no_transaksi,
                'deskripsi' => 'Pembayaran Biaya Medis',
                'amount_transaksi' => $this->input->post('total_pembayaran'),
                'dc' => 'c'
            );
            
            $this->Transaksi_model->update($id_transaksi, $data_trans);
            
            for($i = 0; $i < count($data_trans_d); $i++){
                $this->Transaksi_model->insert_d($data_trans_d[$i]);
            }
            
            // //Jika menggunakan metode asuransi
            // if($this->input->post('metode_pembayaran') == 1){
            //     $data_asuransi = array(
            //         'no_transaksi' => $data_transaksi->no_transaksi,
            //         'amount' => $this->input->post('total_pembayaran'),
            //     );
            //     $this->db->insert('tbl_rekap_asuransi', $data_asuransi);
            // }
            
            //Set session sukses
            $this->session->set_flashdata('message', 'Data pembayaran berhasil disimpan, No Periksa ' . $data_transaksi->no_transaksi);
            $this->session->set_flashdata('message_type', 'success');
            
            redirect(site_url('pembayaran/cetak_struk_jual/'.$data_transaksi->no_transaksi));
        } else {
            $this->data['id_transaksi'] = $data_transaksi->id_transaksi;
            $this->data['kode_transaksi'] = $data_transaksi->kode_transaksi;
            $this->data['klinik'] = $data_transaksi->id_klinik;
            $this->data['no_transaksi'] = $data_transaksi->no_transaksi;
            $this->data['tgl_transaksi'] = $data_transaksi->tgl_transaksi;
            $this->data['status_transaksi'] = $data_transaksi->status_transaksi;
            $this->data['total_transaksi'] = 0;
            $this->data['getDiskon']=$this->db->where('bulan', date('Y-m'))->get('tbl_diskon_trx')->row();
            
            $this->data['transaksi_d'] = $this->Transaksi_model->get_detail_by_h_id($data_transaksi->no_transaksi); //Ini array
            
            $this->data['transaksi_d_obat'] = $this->Transaksi_model->get_detail_obat_by_h_id($data_transaksi->no_transaksi); //Ini array
            
            if($this->input->post('total_transaksi')){
                //Set session error
                $this->session->set_flashdata('message', 'Terdapat error input, silahkan cek lagi');
                $this->session->set_flashdata('message_type', 'danger');
            }
            
        }
        $this->template->load('template','pembayaran/bayar_obat', $this->data);
    }
    
    public function json_asuransi($filter = null) {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json_asuransi($filter,$this->id_klinik);
    }
    
    public function _rules() 
    {
        $this->form_validation->set_rules('total_transaksi', 'Total Transaksi', 'trim|required');
        $this->form_validation->set_rules('atas_nama', 'Atas Nama', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    
    public function cetak_surat($id_transaksi){
        $id_transaksi = $id_transaksi;
        $data_transaksi = $this->Transaksi_model->get_by_id($id_transaksi);
        // if($data_transaksi->status_transaksi == 1){
        //     //Set session error
        //     $this->session->set_flashdata('message', 'Pembayaran sudah dilakukan');
        //     $this->session->set_flashdata('message_type', 'danger');
        //     redirect(site_url('pembayaran'));
        // }
        if(empty($_GET['tab'])){
            $data_periksa = $this->Periksa_model->get_by_id($data_transaksi->no_transaksi);
            $data_pasien = $this->Tbl_pasien_model->get_by_id($data_periksa->no_rekam_medis);
            $this->data['nama_pasien'] = $data_pasien->nama_lengkap;
            $tanggal = new DateTime($data_pasien->tanggal_lahir);

            // tanggal hari ini
            $today = new DateTime('today');
    
            // tahun
            $y = $today->diff($tanggal)->y;

            $this->data['umur'] = $y;
            $this->data['alamat'] = $data_pasien->alamat;
            $this->data['jk'] = '';
        }
        else{
            if($_GET['tab']=='sks'){
                $getPasien = $this->Tbl_sksehat_model->getDetail($data_transaksi->no_transaksi,'nama,umur,alamat,sk.jenis_kelamin');
                $this->data['nama_pasien'] = $getPasien['nama'];
                $this->data['umur'] = $getPasien['umur'];
                $this->data['alamat'] = $getPasien['alamat'];
                $this->data['jk'] = $getPasien['jenis_kelamin'];
            }
            else if($_GET['tab']=='rapid'){
                $this->db->select('nama,tgl_lahir,alamat_domisili,jenis_kelamin');
                $getPasien = $this->db->get_where('tbl_rapid_antigen',['no_sampel' => $data_transaksi->no_transaksi])->row_array();

                $this->data['nama_pasien'] = $getPasien['nama'];
                $tanggal = new DateTime($getPasien['tgl_lahir']);

                // tanggal hari ini
                $today = new DateTime('today');
        
                // tahun
                $y = $today->diff($tanggal)->y;
        
                $this->data['umur'] = $y;
                $this->data['alamat'] = $getPasien['alamat_domisili'];
                $this->data['jk'] = $getPasien['jenis_kelamin'];
            }
        }
        
        $this->data['id_transaksi'] = $data_transaksi->no_transaksi;
        $this->data['transaksi_d'] = $this->Transaksi_model->get_detail_by_h_id($data_transaksi->no_transaksi);

        $this->data['tgl_cetak'] = date("d M Y",  time());
        $this->data['nama_pegawai'] = 'Kasir';
        $this->load->view('pembayaran/cetak_surat', $this->data);
    }
    
    function get_wilayah($kode){
        $this->db->where('kode', $kode);
        $data = $this->db->get('tbl_wilayah')->row();
        return $data->nama;
    }
    
    public function detail(){
        $no_periksa = $_GET['id'];
        $data_periksa = $this->Periksa_model->get_by_id($no_periksa);
        if(is_null($data_periksa))
            redirect(site_url('periksamedis'));
            
        //Data Periksa
        $this->data['no_periksa'] = $data_periksa->no_periksa;
        $this->data['anamnesi'] = $data_periksa->anamnesi;
        $this->data['diagnosa'] = $data_periksa->diagnosa;
        $this->data['tindakan'] = $data_periksa->tindakan;
        // $this->data['nama_dokter'] = $data_periksa->id_dokter;
        $this->data['note_dokter'] = $data_periksa->note_dokter;
        $this->data['tgl_periksa'] = $data_periksa->dtm_crt;
        
        //Get Data Pasien
        $data_pasien = $this->Tbl_pasien_model->get_by_id($data_periksa->no_rekam_medis);
        //Data Pasien
        $this->data['no_rekam_medis'] = $data_pasien->no_rekam_medis;
        $this->data['no_id_pasien'] = $data_pasien->no_id_pasien;
        $this->data['nama_pasien'] = $data_pasien->nama_lengkap;
        $this->data['alamat'] = $data_pasien->alamat.', '.$data_pasien->kelurahan.', '.$data_pasien->kecamatan.', '.$data_pasien->kabupaten;
        
        //Get Data Periksa D Fisik
        $data_periksa_d_fisik = $this->Periksa_model->get_d_fisik_by_id($data_periksa->no_periksa);
        $this->data['periksa_d_fisik'] = $data_periksa_d_fisik;
        
        //Get Data Periksa D Alkes
        $data_periksa_d_alkes = $this->Periksa_model->get_d_alkes_by_id($data_periksa->no_periksa);
        $this->data['periksa_d_alkes'] = $data_periksa_d_alkes;
        
        //Get Data Periksa D Obat
        $data_periksa_d_obat = $this->Periksa_model->get_d_obat_tebus_by_id($data_periksa->no_periksa);
        $this->data['periksa_d_obat'] = $data_periksa_d_obat;
        
        //Get Data Dokter
        $data_dokter = $this->Tbl_dokter_model->get_by_id($data_periksa->id_dokter);
        $this->data['nama_dokter'] = $data_dokter->nama_dokter;
        
        $this->template->load('template','pembayaran/pembayaran_detail', $this->data);
    }
    
    public function asuransi_cetak($filter){
        try{
            $this->data['asuransi'] = $this->Transaksi_model->get_asuransi($filter);
            $this->load->view('pembayaran/asuransi_cetak', $this->data);
        } catch (Exception $e) {
            redirect('rekap_asuransi');
        }
    }
    public function cetak_struk_jual($no_transaksi){
        $data['transaksi']=$this->Transaksi_model->getDetailTrxObat($no_transaksi);
        $data['petugas']=$this->session->userdata('full_name');
        $data['getDiskon']=$this->db->where('bulan', date('Y-m'))->get('tbl_diskon_trx')->row();
        $this->load->view('pembayaran/cetak_struk', $data);
    }
}