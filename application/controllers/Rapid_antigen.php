<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rapid_antigen extends CI_Controller
{
    public $id_klinik;

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Ujung_Pandang');
        $this->load->model('Tbl_dokter_model');
		$this->load->model('Tbl_rapid_antigen_model');
		$this->load->model('Transaksi_model');
		$this->load->model('akuntansi/Transaksi_akuntansi_model');
        $this->load->library('datatables');
        $this->load->library('form_validation');
        $this->id_klinik = $this->session->userdata('id_klinik');

        if($this->uri->segment(2)!='preview'){
            is_login();
        }
    }
    public function index()
    {

        $post = $this->input->post();
        $this->form_validation->set_rules('nomor', 'Nomor', 'trim|required');
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

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        $data['array_bln'] = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $data['bln'] = $data['array_bln'][date('n')];
        $getKode = $this->Tbl_rapid_antigen_model->getKode();
        if(count($getKode)==0){
            $data['number'] = 1;
        }
        else{
            $pecah = explode('/', $getKode[0]->no_sampel);
            $data['number'] = (int)$pecah[0]+1;
        }
        $data['errorNomor'] = '';
        $errorCode = false;
        if(isset($_POST['nomor'])){
            $kode = $_POST['nomor']."/$data[bln]/COVID-19/KR/".date('Y');
            $cekNomor = $this->db->get_where('tbl_rapid_antigen',['no_sampel'=> $kode])->num_rows();

            if($cekNomor==1){
                $errorCode = true;
                $data['errorNomor'] = '<span class="text-danger"> Nomor Already Exists</span>';
            }
        }
        if ($this->form_validation->run()==true){
            if($errorCode==false){
                $post['no_sampel'] = $kode;
                $post['tgl_buat'] = date('Y-m-d');
                unset($post['nomor']);
                $this->Tbl_rapid_antigen_model->insert($post);
                
                $this->session->set_flashdata('success', 'Formulir Rapid Antigen Berhasil Dibuat.');
                redirect(base_url()."pendaftaran_rapid_antigen");
            }
            else{
                $this->template->load('template','rapid_antigen/formulir_rapid_antigen',$data);
            }
        }
        else{
            $this->template->load('template','rapid_antigen/formulir_rapid_antigen',$data);
       }
    }
    public function apiListPemeriksaanDokter()
    {
        header('Content-Type: application/json');

        echo $this->Tbl_rapid_antigen_model->listPemeriksaanDokter();
    }
    public function list_rapid_antigen()
    {
        $this->template->load('template','rapid_antigen/list_rapid_antigen_dokter');
    }
    public function periksa($id)
    {
        $cekPeriksa = $this->Tbl_rapid_antigen_model->cekPeriksa($id);

        if($cekPeriksa==1){
            redirect(base_url()."rapid_antigen");
        }

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
            $post['status'] = '1';
            $post['id_dokter'] = $this->session->userdata()['id_dokter'];
            $this->Tbl_rapid_antigen_model->update($post,$id);
            
            $getNama = $this->Tbl_rapid_antigen_model->detailRapid($id,'nama');
            //insert to transaksi
            //insert transaksi detail
            $tr = array(
                'kode_transaksi' => "RAPANTIGEN",
				'id_klinik' => $this->id_klinik,
                'no_transaksi' => $getNoSampel->no_sampel,
                'tgl_transaksi' => date('Y-m-d'),
                'status_transaksi' => 0,
                'atas_nama' => $getNama->nama,
            );
            $trDetail = array(
                [
                'no_transaksi' => $getNoSampel->no_sampel,
                'deskripsi' => 'Biaya Pemeriksaan',
                'amount_transaksi' => biayaSK('rapid_antigen'),
                'dc' => 'd']
            );
            $this->Transaksi_model->insert($tr,$trDetail);
            //insert akuntansi
            //insert detail akuntansi
            $trAkuntansi = array(
                'deskripsi' => 'Biaya Pemeriksaan '.$getNoSampel->no_sampel,
                'tanggal' => date('Y-m-d'),
            );

            $trAkuntansiDetail = array(
                [
                    'id_akun' => 62,
                    'jumlah' => biayaSK('rapid_antigen'),
                    'tipe' => 'KREDIT',
                    'keterangan' => 'akun'
                ],
                [
                    'id_akun' => 20,
                    'jumlah' => biayaSK('rapid_antigen'),
                    'tipe' => 'DEBIT',
                    'keterangan' => 'lawan'
                ],
            );
            $this->Transaksi_akuntansi_model->insertWithDetail($trAkuntansi,$trAkuntansiDetail);


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
        $this->db->select('id_rapid');
        $getId = $this->db->get_where('tbl_rapid_antigen',['no_sampel' => $_GET['sampel']])->row();
        $data['detail'] = $this->Tbl_rapid_antigen_model->detailRapid($getId->id_rapid);
        $this->load->view('rapid_antigen/print_rapid_antigen',$data);
    }
}
