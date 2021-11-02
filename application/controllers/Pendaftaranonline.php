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
        // $this->form_validation->set_rules('no_rekam_medis', 'No Rekam Medis', 'trim|required');
    	// $this->form_validation->set_rules('no_id', 'No ID Pasien', 'trim|required');
    	$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
    	$this->form_validation->set_rules('nik', 'NIK', 'trim|required');
    	$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
    // 	$this->form_validation->set_rules('golongan_darah', 'Golongan Darah', 'trim|required');
    	$this->form_validation->set_rules('status_menikah', 'Status Menikah', 'trim|required');
    	$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'trim|required');
    	$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
    	$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|required');
    	$this->form_validation->set_rules('rt', 'RT', 'trim|required');
    	$this->form_validation->set_rules('rw', 'RW', 'trim|required');
    	$this->form_validation->set_rules('nama_orangtua_atau_istri', 'Nama Orantua atau Istri', 'trim|required');
    	$this->form_validation->set_rules('nomor_telepon', 'Nomor Telepon', 'trim|required');
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
          'nik'                   => $this->input->get('nik'),
          'nama_lengkap'          => '',
          'tanggal_lahir'         => '',
          'golongan_darah'        => '',
          'status_menikah'        => '',
          'pekerjaan'             => '',
          'alamat'                => '',
          'kabupaten'             => '',
          'rt'                    => '',      
          'rw'                    => '',      
          'nama_orang_tua_atau_istri'  => '',
          'nomer_telepon'         => '',
        );
        // redirect(site_url('pendaftaranonline/pendaftaran/').$nik);
        // $this->load->view('pendaftaran/pendaftaran_online');
      } else{
        $row = $cek[0];
        // print_r($row);
        // echo $nik;
        // $row = $this->Pendaftaran_online_model->get_by_id($this->input->get('id'));
        //   if($row == )
        $nikdaftar = array(
          'nik'                   => $row['nik'],
          'nama_lengkap'          => $row['nama_lengkap'],
          'tanggal_lahir'         => $row['tanggal_lahir'],
          'golongan_darah'        => $row['golongan_darah'],
          'status_menikah'        => $row['status_menikah'],
          'pekerjaan'             => $row['pekerjaan'],
          'alamat'                => $row['alamat'],
          'kabupaten'             => $row['kabupaten'],
          'rt'                    => $row['rt'],      
          'rw'                    => $row['rw'],      
          'nama_orang_tua_atau_istri'  => $row['nama_orang_tua_atau_istri'],
          'nomer_telepon'         => $row['nomer_telepon'],
        );
        // $this->Pendaftaran_online_model->insert($nikdaftar);
        // redirect(site_url('pendaftaranonline/pendaftaran/').$nik);
      }
      $this->pendaftaran($nikdaftar);
    }

    public function pendaftaran($nikdaftar){
      $this->_rules();
      // $daridbpendaftaran = $this->Pendaftaran_online_model->cekKodePendaftaran();
      // $nourut = substr($daridbpendaftaran,2);
      // $kodependaftaran = $nourut + 1;
      $recaptcha = $this->input->post('g-recaptcha-response');
      $response = $this->recaptcha->verifyResponse($recaptcha);	
      if ($this->form_validation->run() == TRUE && isset($response['failed']) || $this->form_validation->run() == TRUE &&  $response['success'] == TRUE) {
      // if ($this->form_validation->run() == TRUE){
          $no_pendaftaran = $this->Master_sequence_model->set_code_by_master_seq_code("NOPENDAFTARAN");
          
    $data_pasien = array(
      // 'no_rekam_medis'    => $this->input->post('no_rekam_medis'),
      // 'no_id_pasien'		=> $kodependaftaran,
      'nama_lengkap'      => $this->input->post('nama_lengkap'),
      'nik'               => $this->input->post('nik'),
      'tanggal_lahir'     => $this->input->post('tanggal_lahir'),
      'golongan_darah'    => $this->input->post('golongan_darah'),
      'status_menikah'    => $this->input->post('status_menikah'),
      'pekerjaan'      	=> $this->input->post('pekerjaan'),
      'alamat'      		=> $this->input->post('alamat'),
      'kabupaten' 		=> $this->input->post('kabupaten'),
      'rt' 		=> $this->input->post('rt'),
      'rw' 		=> $this->input->post('rw'),
      'nama_orang_tua_atau_istri'      =>  $this->input->post('nama_orangtua_atau_istri'),
      'nomer_telepon'     =>  $this->input->post('nomor_telepon'),
      'id_dokter' => $this->input->post('nama_dokter'),
      // 'id_klinik' => $this->id_klinik,
      'tipe_periksa' => $this->input->post('tipe_periksa'),
    );
    
      // $data_pendaftaran = array(
      // 'no_pendaftaran' => $this->Master_sequence_model->set_code_by_master_seq_code("NOPENDAFTARAN", true),
      // 'no_rekam_medis' => $this->input->post('no_rekam_medis'),
      // 'id_dokter' => $this->input->post('nama_dokter'),
      // 'id_klinik' => $this->id_klinik,
      // 'tipe_periksa' => $this->input->post('tipe_periksa'),
      //   );

    $row = $this->Pendaftaran_online_model->get_by_id($this->input->post('id'));
    if($row == null)
    {
      $this->Pendaftaran_online_model->insert($data_pasien);
      $master_code = $this->Master_sequence_model->set_code_by_master_seq_code("NOREKAMMEDIS", true);
    } else {
        $this->Pendaftaran_online_model->update($row->id, $data_pasien);
    }
    // $this->Pendaftaran_model->insert($data_pendaftaran);
    
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
          
    redirect(site_url('pendaftaranonline'));
      } else {	
          $pasien_existing = null;
          // if($this->session->flashdata('id_pendaftaran') != null)
          //     $pasien_existing = $this->Pendaftaran_online_model->get_by_id($this->session->flashdata('id_pendaftaran'));
    
            $this->data['message'] = $this->session->flashdata('message');
            
            $this->db->where('id_pendaftaran', set_value('id_pendaftaran'));
            $this->db->get('tbl_pendaftaran_online')->row();
            // $dataPasien = $this->db->get('tbl_pendaftaran_online')->row();
            // $this->data['no_rekam_medis_default'] = $this->Master_sequence_model->set_code_by_master_seq_code("NOREKAMMEDIS");
            
            // $this->data['no_rekam_medis'] = $pasien_existing != null ? $pasien_existing->no_rekam_medis : ($dataPasien != null ? set_value('no_rekam_medis') : $this->data['no_rekam_medis_default']);
            // $this->data['no_id'] = $pasien_existing != null ? $pasien_existing->no_id_pasien : set_value('no_id');
            // $this->data['id_pendaftaran'] = $pasien_existing != null ? $pasien_existing->id_pendaftaran : set_value('id_pendaftaran');
            // $this->data['nama_lengkap'] = $pasien_existing != null ? $pasien_existing->nama_lengkap : set_value('nama_lengkap');
            // $this->data['nik'] = $pasien_existing != null ? $pasien_existing->nik : set_value('nik');
            // $this->data['tanggal_lahir'] = $pasien_existing != null ? $pasien_existing->tanggal_lahir : set_value('tanggal_lahir');
            // $this->data['golongan_darah'] = $pasien_existing != null ? $pasien_existing->golongan_darah : set_value('golongan_darah');
            // $this->data['status_menikah'] = $pasien_existing != null ? $pasien_existing->status_menikah : set_value('status_menikah');
            // $this->data['pekerjaan'] = $pasien_existing != null ? $pasien_existing->pekerjaan : set_value('pekerjaan');
            // $this->data['alamat'] = $pasien_existing != null ? $pasien_existing->alamat : set_value('alamat');
            // $this->data['kabupaten'] = $pasien_existing != null ? $pasien_existing->kabupaten : set_value('kabupaten');
            // $this->data['rt'] = $pasien_existing != null ? $pasien_existing->rt : set_value('rt');
            // $this->data['rw'] = $pasien_existing != null ? $pasien_existing->rw : set_value('rw');
            // $this->data['nama_orangtua_atau_istri'] = $pasien_existing != null ? $pasien_existing->nama_orang_tua_atau_istri : set_value('nama_orangtua_atau_istri');
            // $this->data['nomor_telepon'] = $pasien_existing != null ? $pasien_existing->nomer_telepon : set_value('nomor_telepon');
            // $this->data['nama_dokter'] = set_value('nama_dokter');	
            $this->data['captcha'] = $this->recaptcha->getWidget();
            $this->data['script_captcha'] = $this->recaptcha->getScriptTag();
            $this->data['dokter'] = $this->Tbl_dokter_model->get_all_jaga($this->id_klinik);
            if($this->input->post('nik')){
              $this->session->set_flashdata('message', 'Terdapat error input, silahkan cek ulang');
              $this->session->set_flashdata('message_type', 'danger');
            }
            $this->data['data'] = $nikdaftar;
    //Set session error
  }
      
      $this->load->view('pendaftaran/pendaftaran_online', $this->data);
  }
    
}