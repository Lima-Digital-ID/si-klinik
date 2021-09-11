<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pasien extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_pasien_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','pasien/tbl_pasien_list');
    }
    
    public function json(){
        header('Content-Type: application/json');
        echo $this->Tbl_pasien_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_pasien_model->get_by_id($id);
        if ($row) {
            $data = array(
		'no_rekamedis' => $row->no_rekamedis,
		'nama_pasien' => $row->nama_pasien,
		'jenis_kelamin' => $row->jenis_kelamin,
		'golongan_darah' => $row->golongan_darah,
		'tempat_lahir' => $row->tempat_lahir,
		'tanggal_lahir' => $row->tanggal_lahir,
		'nama_ibu' => $row->nama_ibu,
		'alamat' => $row->alamat,
		'id_agama' => $row->id_agama,
		'status_menikah' => $row->status_menikah,
		'no_hp' => $row->no_hp,
		'id_pekerjaan' => $row->id_pekerjaan,
	    );
            $this->template->load('template','pasien/tbl_pasien_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pasien'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_pasien_model->get_by_id($id);

        if ($row) {
    	    $this->data['action'] = site_url('pasien/update_action');
    	    $this->data['no_rekam_medis'] = set_value('no_rekam_medis', $row->no_rekam_medis);
			$this->data['no_id'] = set_value('no_id',$row->no_id_pasien);
			$this->data['nama_lengkap'] = set_value('nama_lengkap',$row->nama_lengkap);
			$this->data['golongan_darah'] = set_value('golongan_darah',$row->golongan_darah);
			$this->data['status_menikah'] = set_value('status_menikah',$row->status_menikah);
			$this->data['pekerjaan'] = set_value('pekerjaan',$row->pekerjaan);
			$this->data['alamat'] = set_value('alamat',$row->alamat);
			$this->data['kabupaten'] = set_value('kabupaten',$row->kabupaten);
			$this->data['kecamatan'] = set_value('kecamatan',$row->kecamatan);
			$this->data['kelurahan'] = set_value('kelurahan',$row->kelurahan);
			$this->data['nama_orangtua_atau_istri'] = set_value('nama_orangtua_atau_istri',$row->nama_orang_tua_atau_istri);
			$this->data['nomor_telepon'] = set_value('nomor_telepon',$row->nomer_telepon);
			
            $this->template->load('template','pasien/tbl_pasien_form', $this->data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pasien'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('no_rekam_medis', TRUE));
        } else {
            $data = array(
		        'no_rekam_medis'    => $this->input->post('no_rekam_medis'),
				'no_id_pasien'		=> $this->input->post('no_id'),
				'nama_lengkap'      => $this->input->post('nama_lengkap'),
				'golongan_darah'    => $this->input->post('golongan_darah'),
				'status_menikah'    => $this->input->post('status_menikah'),
				'pekerjaan'      	=> $this->input->post('pekerjaan'),
				'alamat'      		=> $this->input->post('alamat'),
				'kabupaten' 		=> $this->input->post('kabupaten'),
				'kecamatan' 		=> $this->input->post('kecamatan'),
				'kelurahan' 		=> $this->input->post('kelurahan'),
				'nama_orang_tua_atau_istri'      =>  $this->input->post('nama_orangtua_atau_istri'),
				'nomer_telepon'     =>  $this->input->post('nomor_telepon'),
                'dtm_upd' => date("Y-m-d H:i:s",  time())
	        );

            $this->Tbl_pasien_model->update($this->input->post('no_rekam_medis', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pasien'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_pasien_model->get_by_id($id);

        if ($row) {
            $this->Tbl_pasien_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pasien'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pasien'));
        }
    }

    public function _rules() 
    {
    $this->form_validation->set_rules('no_rekam_medis', 'No Rekam Medis', 'trim|required');
    	$this->form_validation->set_rules('no_id', 'No ID Pasien', 'trim|required');
    	$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
    	$this->form_validation->set_rules('golongan_darah', 'Golongan Darah', 'trim|required');
    	$this->form_validation->set_rules('status_menikah', 'Status Menikah', 'trim|required');
    	$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'trim|required');
    	$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
    	$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|required');
    	$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'trim|required');
    	$this->form_validation->set_rules('kelurahan', 'Kelurahan', 'trim|required');
    	$this->form_validation->set_rules('nama_orangtua_atau_istri', 'Nama Orantua atau Istri', 'trim|required');
    	$this->form_validation->set_rules('nomor_telepon', 'Nomor Telepon', 'trim|required');
	    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pasien.php */
/* Location: ./application/controllers/Pasien.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-03 15:02:10 */
/* http://harviacode.com */