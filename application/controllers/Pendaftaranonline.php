<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PendaftaranOnline extends CI_Controller {
  public $id_klinik;
  function __construct()
    {
      parent::__construct();
      // is_login();
      $this->load->model('Pendaftaran_model');
      $this->load->model('Pendaftaran_online_model');
		  $this->load->model('Master_sequence_model');
		  $this->load->model('Tbl_dokter_model');
		  $this->load->model('Tbl_pasien_model');
		  $this->load->model('User_model');
		  $this->load->model('Tbl_wilayah_model');
		  $this->load->library('form_validation');
		  $this->load->library('session');
		
		  // $this->id_klinik = $this->session->userdata('id_klinik');
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
    	$this->form_validation->set_rules('nik', 'NIK', 'trim|required');
    	$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
    	$this->form_validation->set_rules('golongan_darah', 'Golongan Darah', 'trim|required');
    	$this->form_validation->set_rules('status_menikah', 'Status Menikah', 'trim|required');
    	$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'trim|required');
    	$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
    	$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|required');
    	$this->form_validation->set_rules('rt', 'RT', 'trim|required');
    	$this->form_validation->set_rules('rw', 'RW', 'trim|required');
    	$this->form_validation->set_rules('nama_orang_tua_atau_istri', 'Nama Orantua atau Istri', 'trim|required');
    	$this->form_validation->set_rules('nomer_telepon', 'Nomor Telepon', 'trim|required');
		  $this->form_validation->set_rules('nama_dokter', 'Nama Dokter', 'trim|required');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    function index(){
      $this->load->view('pendaftaran/home_pendaftaran_online');
    }

    public function cekNik(){     
      $nik = $this->input->get('nik');
      $cek = $this->Pendaftaran_online_model->cekNikPendaftaran($nik);
      if(count($cek)==0){
        $nikdaftar = array(
          'nik'                        => $this->input->get('nik'),
          'nama_lengkap'               => '',
          'tanggal_lahir'              => '',
          'golongan_darah'             => '',
          'status_menikah'             => '',
          'pekerjaan'                  => '',
          'alamat'                     => '',
          'kabupaten'                  => '',
          'rt'                         => '',      
          'rw'                         => '',      
          'nama_orang_tua_atau_istri'  => '',
          'nomer_telepon'              => '',
        );
      } else{
        $row = $cek[0];
        $nikdaftar = array(
          'nik'                        => $row['nik'],
          'nama_lengkap'               => $row['nama_lengkap'],
          'tanggal_lahir'              => $row['tanggal_lahir'],
          'golongan_darah'             => $row['golongan_darah'],
          'status_menikah'             => $row['status_menikah'],
          'pekerjaan'                  => $row['pekerjaan'],
          'alamat'                     => $row['alamat'],
          'kabupaten'                  => $row['kabupaten'],
          'rt'                         => $row['rt'],      
          'rw'                         => $row['rw'],      
          'nama_orang_tua_atau_istri'  => $row['nama_orang_tua_atau_istri'],
          'nomer_telepon'              => $row['nomer_telepon'],
        );
      }
      $this->daftar($nikdaftar);
    }

    public function daftar($nikdaftar){
      $this->_rules();
      $recaptcha = $this->input->post('g-recaptcha-response');
      $response = $this->recaptcha->verifyResponse($recaptcha);	
      if ($this->form_validation->run() == TRUE && isset($response['failed']) || $this->form_validation->run() == TRUE &&  $response['success'] == TRUE) {
        $no_pendaftaran = $this->Master_sequence_model->set_code_by_master_seq_code("NOPENDAFTARAN");
        $data_pasien = array(
          'nama_lengkap'                   => $this->input->post('nama_lengkap'),
          'nik'                            => $this->input->post('nik'),
          'tanggal_lahir'                  => $this->input->post('tanggal_lahir'),
          'golongan_darah'                 => $this->input->post('golongan_darah'),
          'status_menikah'                 => $this->input->post('status_menikah'),
          'pekerjaan'       	             => $this->input->post('pekerjaan'),
          'alamat'      		               => $this->input->post('alamat'),
          'kabupaten' 		                 => $this->input->post('kabupaten'),
          'rt' 		                         => $this->input->post('rt'),
          'rw' 		                         => $this->input->post('rw'),
          'nama_orang_tua_atau_istri'      => $this->input->post('nama_orang_tua_atau_istri'),
          'nomer_telepon'                  => $this->input->post('nomer_telepon'),
          'id_dokter'                      => $this->input->post('nama_dokter'),
          'tipe_periksa'                   => $this->input->post('tipe_periksa'),
        );
        $this->Pendaftaran_online_model->insert($data_pasien);
        //Cek status dokter, jika kosong maka isi no_pendaftaran
        $dokter = $this->Tbl_dokter_model->get_by_id($this->input->post('nama_dokter'));
        if($dokter->no_pendaftaran == null || trim($dokter->no_pendaftaran) == '' ){
            $this->Tbl_dokter_model->update($this->input->post('nama_dokter'), array(
              'no_pendaftaran' => $no_pendaftaran,
              'dtm_upd' => date("Y-m-d H:i:s",  time())
            ));
      }
      //Set session sukses
      $this->session->set_flashdata('message', 'Pendaftaran sukses!');
      $this->session->set_flashdata('message_type', 'success');
      redirect(base_url()."pendaftaranonline");
      // $this->load->view('pendaftaran/pendaftaran_online');
      } else {	
        $this->data['message'] = $this->session->flashdata('message');
        $this->db->where('id_pendaftaran', set_value('id_pendaftaran'));
        $this->db->get('tbl_pendaftaran_online')->row();
        $this->data['captcha'] = $this->recaptcha->getWidget();
        $this->data['script_captcha'] = $this->recaptcha->getScriptTag();
        $this->data['dokter'] = $this->Tbl_dokter_model->get_all_jaga($this->id_klinik);
        //Set session error
        if($this->input->post('nik')){
          $this->session->set_flashdata('message', 'Terdapat error input, silahkan cek ulang');
          $this->session->set_flashdata('message_type', 'danger');
        }
        $this->data['data'] = $nikdaftar;
        $this->load->view('pendaftaran/pendaftaran_online', $this->data);

      }
  }    
}