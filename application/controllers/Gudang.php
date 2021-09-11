<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gudang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_gudang_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','gudang/tbl_gudang_list');
    }
    
    public function json(){
        header('Content-Type: application/json');
        echo $this->Tbl_gudang_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_gudang_model->get_by_id($id);
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
            'action' => site_url('gudang/create_action'),
            'kode_gudang' => set_value('kode_gudang'),
            'nama_gudang' => set_value('nama_gudang'),
            'alamat_gudang' => set_value('jenis_kelamin'),
            'kota' => set_value('kota'),
            'telp' => set_value('telp'),
    );
        $this->template->load('template','gudang/tbl_gudang_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        $kode_gudang='GUD'.time();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'kode_gudang' => $kode_gudang,
                'nama_gudang' => $this->input->post('nama_gudang',TRUE),
                'alamat_gudang' => $this->input->post('alamat_gudang',TRUE),
                'kota' => $this->input->post('kota',TRUE),
                'telp' => $this->input->post('telp',TRUE),
        );

            $this->Tbl_gudang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('gudang'));
        }
    }
    public function update($id) 
    {
        $row = $this->Tbl_gudang_model->get_by_id($id);

        if ($row) {
    	    $this->data['action'] = site_url('gudang/update_action');
            $this->data['button'] = 'Update';
    	    $this->data['kode_gudang'] = set_value('kode_gudang', $row->kode_gudang);
			$this->data['nama_gudang'] = set_value('nama_gudang',$row->nama_gudang);
			$this->data['alamat_gudang'] = set_value('alamat_gudang',$row->alamat_gudang);
			$this->data['kota'] = set_value('kota',$row->kota);
			$this->data['telp'] = set_value('telp',$row->telp);
			
            $this->template->load('template','gudang/tbl_gudang_form', $this->data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('gudang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_gudang', TRUE));
        } else {
            $data = array(
		        // 'kode_gudang'       => $this->input->post('kode_gudang'),
				'nama_gudang'		=> $this->input->post('nama_gudang'),
				'alamat_gudang'     => $this->input->post('alamat_gudang'),
				'kota'              => $this->input->post('kota'),
				'telp'              => $this->input->post('telp'),
                'dtm_upd'           => date("Y-m-d H:i:s",  time())
	        );
            // print_r($this->input->post('kode_gudang', TRUE));
            // exit();
            $this->Tbl_gudang_model->update($this->input->post('kode_gudang', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('gudang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_gudang_model->get_by_id($id);

        if ($row) {
            $this->Tbl_gudang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('gudang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('gudang'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('kode_gudang', 'kode gudang', 'trim');
    	$this->form_validation->set_rules('nama_gudang', 'Nama Lengkap', 'trim|required');
    	$this->form_validation->set_rules('alamat_gudang', 'Alamat gudang', 'trim|required');
    	$this->form_validation->set_rules('kota', 'kota', 'trim|required');
    	$this->form_validation->set_rules('telp', 'telp', 'trim|required');
	    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pasien.php */
/* Location: ./application/controllers/Pasien.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-03 15:02:10 */
/* http://harviacode.com */