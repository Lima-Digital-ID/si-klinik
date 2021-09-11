<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pabrik extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_pabrik_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','pabrik/tbl_pabrik_list');
    }
    
    public function json(){
        header('Content-Type: application/json');
        echo $this->Tbl_pabrik_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_pabrik_model->get_by_id($id);
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
    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('pabrik/create_action'),
            'kode_pabrik' => set_value('kode_pabrik'),
            'nama_pabrik' => set_value('nama_pabrik'),
            'alamat_pabrik' => set_value('jenis_kelamin'),
            'kota' => set_value('kota'),
            'telp' => set_value('telp'),
            'npwp' => set_value('npwp'),
    );
        $this->template->load('template','pabrik/tbl_pabrik_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        $kode_pabrik='PAB'.time();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'kode_pabrik' => $kode_pabrik,
                'nama_pabrik' => $this->input->post('nama_pabrik',TRUE),
                'alamat_pabrik' => $this->input->post('alamat_pabrik',TRUE),
                'kota' => $this->input->post('kota',TRUE),
                'telp' => $this->input->post('telp',TRUE),
                'npwp' => $this->input->post('npwp',TRUE),
        );

            $this->Tbl_pabrik_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('pabrik'));
        }
    }
    public function update($id) 
    {
        $row = $this->Tbl_pabrik_model->get_by_id($id);

        if ($row) {
    	    $this->data['action'] = site_url('pabrik/update_action');
            $this->data['button'] = 'Update';
    	    $this->data['kode_pabrik'] = set_value('kode_pabrik', $row->kode_pabrik);
			$this->data['nama_pabrik'] = set_value('nama_pabrik',$row->nama_pabrik);
			$this->data['alamat_pabrik'] = set_value('alamat_pabrik',$row->alamat_pabrik);
			$this->data['kota'] = set_value('kota',$row->kota);
			$this->data['telp'] = set_value('telp',$row->telp);
			$this->data['npwp'] = set_value('npwp',$row->npwp);
			
            $this->template->load('template','pabrik/tbl_pabrik_form', $this->data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pabrik'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_pabrik', TRUE));
        } else {
            $data = array(
		        // 'kode_pabrik'       => $this->input->post('kode_pabrik'),
				'nama_pabrik'		=> $this->input->post('nama_pabrik'),
				'alamat_pabrik'     => $this->input->post('alamat_pabrik'),
				'kota'              => $this->input->post('kota'),
				'telp'              => $this->input->post('telp'),
				'npwp'            	=> $this->input->post('npwp'),
                'dtm_upd'           => date("Y-m-d H:i:s",  time())
	        );

            $this->Tbl_pabrik_model->update($this->input->post('kode_pabrik', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pabrik'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_pabrik_model->get_by_id($id);

        if ($row) {
            $this->Tbl_pabrik_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pabrik'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pabrik'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('kode_pabrik', 'kode pabrik', 'trim');
    	$this->form_validation->set_rules('nama_pabrik', 'Nama Lengkap', 'trim|required');
    	$this->form_validation->set_rules('alamat_pabrik', 'Alamat Pabrik', 'trim|required');
    	$this->form_validation->set_rules('kota', 'kota', 'trim|required');
    	$this->form_validation->set_rules('telp', 'telp', 'trim|required');
    	$this->form_validation->set_rules('npwp', 'Kelurahan', 'trim|required');
	    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pasien.php */
/* Location: ./application/controllers/Pasien.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-03 15:02:10 */
/* http://harviacode.com */