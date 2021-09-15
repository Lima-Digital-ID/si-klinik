<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rapid_antigen extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Ujung_Pandang');
        $this->load->model('Tbl_dokter_model');
		$this->load->model('Tbl_rapid_antigen_model');
        $this->load->library('datatables');
        $this->load->library('form_validation');

        if($this->uri->segment(2)!='preview'){
            is_login();
        }
    }
    public function index()
    {

        $post = $this->input->post();
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'trim|required');
        $this->form_validation->set_rules('nik_or_passport', 'Nik / Passport', 'trim|required');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'trim|required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');
        $this->form_validation->set_rules('alamat_domisili', 'Alamat Domisili', 'trim|required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'trim|required');
        $this->form_validation->set_rules('alamat_bekerja', 'Alamat Bekerja', 'trim|required');
        $this->form_validation->set_rules('keluhan', 'Keluhan', 'trim|required');
        $this->form_validation->set_rules('komorbid', 'Komorbid', 'trim|required');
        $this->form_validation->set_rules('alasan', 'Alasan', 'trim|required');
        $this->form_validation->set_rules('riwayat_vaksin', 'Riwayat Vaksin', 'trim|required');
        if($this->input->post('riwayat_vaksin')=='Sudah'){
            $this->form_validation->set_rules('tgl_vaksin_1', 'Tanggal Vaksin', 'trim|required');
            $this->form_validation->set_rules('tgl_vaksin_2', 'Tanggal Vaksin', 'trim|required');
        }
        else{
            $post['tgl_vaksin_1'] = '0000-00-00';
            $post['tgl_vaksin_2'] = '0000-00-00';
        }
        if($this->input->post('riwayat_kontak')=='Ya'){
            $this->form_validation->set_rules('tgl_kontak', 'Tanggal Kontak', 'trim|required');
            $this->form_validation->set_rules('kontak_di', 'Kontak Di', 'trim|required');
        }
        else{
            $post['tgl_kontak'] = '0000-00-00';
            $post['kontak_di'] = '';
        }
        $this->form_validation->set_rules('riwayat_swab_rapid_sebelumnya', 'Riwayat Swab Rapid Sebelumnya', 'trim|required');
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run()==true){

            $getKode = $this->Tbl_rapid_antigen_model->getKode();
            if(count($getKode)==0){
                $number = 1;
            }
            else{
                $pecah = explode('/', $getKode[0]->no_sampel);
                $number = (int)$pecah[0]+1;
            }
            $array_bln = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
            $bln = $array_bln[date('n')];
            $kode = $number."/$bln/COVID-19/KR/".date('Y');
            $post['no_sampel'] = $kode;
            $this->Tbl_rapid_antigen_model->insert($post);

            $this->session->set_flashdata('success', 'Formulir Rapid Antigen Berhasil Dibuat. Pemeriksaan berlanjut ke Dokter yang dipilih');
            redirect(base_url()."pendaftaran_rapid_antigen");
        }
        else{
            $data['data_dokter'] = $this->Tbl_dokter_model->get_all();
            $this->template->load('template','rapid_antigen/formulir_rapid_antigen',$data);
       }
    }
    public function apiListPemeriksaanDokter()
    {
        header('Content-Type: application/json');

        echo $this->Tbl_rapid_antigen_model->listPemeriksaanDokter($this->session->userdata()['id_dokter']);
    }
    public function list_rapid_antigen()
    {
        $this->template->load('template','rapid_antigen/list_rapid_antigen_dokter');
    }
    public function periksa($id)
    {
        $this->form_validation->set_rules('parameter_pemeriksaan', 'Parameter Pemeriksaan', 'trim|required');
        $this->form_validation->set_rules('hasil', 'Hasil', 'trim|required');
        $this->form_validation->set_rules('nilai_rujukan', 'Nilai Rujukan', 'trim|required');
        $this->form_validation->set_rules('saran', 'Saran', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');


        if ($this->form_validation->run()==TRUE){
            $post = $_POST;
            $post['tgl_pemeriksaan'] = date('Y-m-d H:i:s');

            $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = 'assets/'; //string, the default is application/cache/
            $config['errorlog']     = 'assets/'; //string, the default is application/logs/
            $config['imagedir']     = 'assets/images/qr_code/'; //direktori penyimpanan qr code
            $config['quality']      = true; //boolean, the default is true
            $config['size']         = '1024'; //interger, the default is 1024
            $config['black']        = array(224,255,255); // array, default is array(255,255,255)
            $config['white']        = array(70,130,180); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);
            
            $getNoSampel = $this->Tbl_rapid_antigen_model->getNoSampel($id);
            $image_name = str_replace('/','-',$getNoSampel->no_sampel).'.png'; //buat name dari qr code sesuai dengan nim
     
            $params['data'] = base_url()."rapid_antigen/preview?sampel=".$getNoSampel->no_sampel; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            $post['qr_code'] = $image_name;
            $post['status'] = 1;
            $this->Tbl_rapid_antigen_model->update($post,$id);

            redirect(base_url()."rapid_antigen/print/$id");
        }
        else{
            $data['detail'] = $this->Tbl_rapid_antigen_model->detailRapid($id);
            $this->template->load('template','rapid_antigen/periksa_rapid_antigen',$data);
        }
        
    }
    public function print($id)
    {
        $data['detail'] = $this->Tbl_rapid_antigen_model->detailRapid($id);
        $this->load->view('rapid_antigen/print_rapid_antigen',$data);
    }
    public function preview()
    {
        $data['detail'] = $this->Tbl_rapid_antigen_model->detailRapid($_GET['sampel']);
        $this->load->view('rapid_antigen/print_rapid_antigen',$data);
    }
}
