<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Golonganbarang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_golongan_barang_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','golongan_barang/tbl_golongan_barang_list');
    }
    
    public function json(){
        header('Content-Type: application/json');
        echo $this->Tbl_golongan_barang_model->json();
    }

  //   public function read($id) 
  //   {
  //       $row = $this->Tbl_golongan_barang_model->get_by_id($id);
  //       if ($row) {
  //           $data = array(
		// 'no_rekamedis' => $row->no_rekamedis,
		// 'nama_pasien' => $row->nama_pasien,
		// 'jenis_kelamin' => $row->jenis_kelamin,
		// 'golongan_darah' => $row->golongan_darah,
		// 'tempat_lahir' => $row->tempat_lahir,
		// 'tanggal_lahir' => $row->tanggal_lahir,
		// 'nama_ibu' => $row->nama_ibu,
		// 'alamat' => $row->alamat,
		// 'id_agama' => $row->id_agama,
		// 'status_menikah' => $row->status_menikah,
		// 'no_hp' => $row->no_hp,
		// 'id_pekerjaan' => $row->id_pekerjaan,
	 //    );
  //           $this->template->load('template','pasien/tbl_pasien_read', $data);
  //       } else {
  //           $this->session->set_flashdata('message', 'Record Not Found');
  //           redirect(site_url('pasien'));
  //       }
  //   }
    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('golonganbarang/create_action'),
            'id_golongan_barang' => set_value('id_golongan_barang'),
            'nama_golongan_barang' => set_value('nama_golongan_barang'),
            'keterangan' => set_value('keterangan'),
    );
        $this->template->load('template','golongan_barang/tbl_golongan_barang_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        // $id_golongan_barang='GUD'.time();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                // 'id_golongan_barang' => $id_golongan_barang,
                'nama_golongan_barang' => $this->input->post('nama_golongan_barang',TRUE),
                'keterangan' => $this->input->post('keterangan',TRUE),
        );

            $this->Tbl_golongan_barang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('golonganbarang'));
        }
    }
    public function update($id) 
    {
        $row = $this->Tbl_golongan_barang_model->get_by_id($id);

        if ($row) {
    	    $this->data['action'] = site_url('golonganbarang/update_action');
            $this->data['button'] = 'Update';
    	    $this->data['id_golongan_barang'] = set_value('id_golongan_barang', $row->id_golongan_barang);
			$this->data['nama_golongan_barang'] = set_value('nama_golongan_barang',$row->nama_golongan_barang);
			$this->data['keterangan'] = set_value('keterangan',$row->keterangan);
			
            $this->template->load('template','golongan_barang/tbl_golongan_barang_form', $this->data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('golonganbarang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_golongan_barang', TRUE));
        } else {
            $data = array(
		        // 'id_golongan_barang'       => $this->input->post('id_golongan_barang'),
				'nama_golongan_barang'		=> $this->input->post('nama_golongan_barang'),
				'keterangan'              => $this->input->post('keterangan'),
                'dtm_upd'           => date("Y-m-d H:i:s")
	        );

            $this->Tbl_golongan_barang_model->update($this->input->post('id_golongan_barang', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('golonganbarang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_golongan_barang_model->get_by_id($id);

        if ($row) {
            $this->Tbl_golongan_barang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('golonganbarang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('golonganbarang'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('id_golongan_barang', 'id golongan_barang', 'trim');
    	$this->form_validation->set_rules('nama_golongan_barang', 'Nama Lengkap', 'trim|required');
    	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pasien.php */
/* Location: ./application/controllers/Pasien.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-03 15:02:10 */
/* http://harviacode.com */