<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_supplier_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','supplier/tbl_supplier_list');
    }
    
    public function json(){
        header('Content-Type: application/json');
        echo $this->Tbl_supplier_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_supplier_model->get_by_id($id);
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
            'action' => site_url('supplier/create_action'),
            'kode_supplier' => set_value('kode_supplier'),
            'nama_supplier' => set_value('nama_supplier'),
            'alamat_supplier' => set_value('jenis_kelamin'),
            'kota' => set_value('kota'),
            'telp' => set_value('telp'),
            'npwp' => set_value('npwp'),
            'no_rekening' => set_value('no_rekening'),
    );
        $this->template->load('template','supplier/tbl_supplier_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        $kode_supplier='SUP'.time();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'kode_supplier' => $kode_supplier,
                'nama_supplier' => $this->input->post('nama_supplier',TRUE),
                'alamat_supplier' => $this->input->post('alamat_supplier',TRUE),
                'kota' => $this->input->post('kota',TRUE),
                'telp' => $this->input->post('telp',TRUE),
                'npwp' => $this->input->post('npwp',TRUE),
                'no_rekening' => $this->input->post('no_rekening',TRUE),
        );

            $this->Tbl_supplier_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('supplier'));
        }
    }
    public function update($id) 
    {
        $row = $this->Tbl_supplier_model->get_by_id($id);

        if ($row) {
    	    $this->data['action'] = site_url('supplier/update_action');
            $this->data['button'] = 'Update';
    	    $this->data['kode_supplier'] = set_value('kode_supplier', $row->kode_supplier);
			$this->data['nama_supplier'] = set_value('nama_supplier',$row->nama_supplier);
			$this->data['alamat_supplier'] = set_value('alamat_supplier',$row->alamat_supplier);
			$this->data['kota'] = set_value('kota',$row->kota);
			$this->data['telp'] = set_value('telp',$row->telp);
			$this->data['npwp'] = set_value('npwp',$row->npwp);
            $this->data['no_rekening'] = set_value('no_rekening',$row->no_rekening);
			
            $this->template->load('template','supplier/tbl_supplier_form', $this->data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('supplier'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_supplier', TRUE));
        } else {
            $data = array(
		        // 'kode_supplier'       => $this->input->post('kode_supplier'),
				'nama_supplier'		=> $this->input->post('nama_supplier'),
				'alamat_supplier'     => $this->input->post('alamat_supplier'),
				'kota'              => $this->input->post('kota'),
				'telp'              => $this->input->post('telp'),
				'npwp'            	=> $this->input->post('npwp'),
                'no_rekening'       => $this->input->post('no_rekening'),
                'dtm_upd'           => date("Y-m-d H:i:s",  time())
	        );

            $this->Tbl_supplier_model->update($this->input->post('kode_supplier', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('supplier'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_supplier_model->get_by_id($id);

        if ($row) {
            $this->Tbl_supplier_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('supplier'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('supplier'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('kode_supplier', 'kode Supplier', 'trim');
    	$this->form_validation->set_rules('nama_supplier', 'Nama Lengkap', 'trim|required');
    	$this->form_validation->set_rules('alamat_supplier', 'Alamat Supplier', 'trim|required');
    	$this->form_validation->set_rules('kota', 'kota', 'trim|required');
    	$this->form_validation->set_rules('telp', 'telp', 'trim|required');
    	$this->form_validation->set_rules('npwp', 'npwp', 'trim|required');
        $this->form_validation->set_rules('no_rekening', 'no_rekening', 'trim|required');
	    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pasien.php */
/* Location: ./application/controllers/Pasien.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-03 15:02:10 */
/* http://harviacode.com */