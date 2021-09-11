<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Apoteker extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_apoteker_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','master_data/apoteker/tbl_apoteker_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_apoteker_model->json();
    }

  //   public function read($id) 
  //   {
  //       $row = $this->Tbl_apoteker_model->get_by_id($id);
  //       if ($row) {
  //           $data = array(
		// 'id_apoteker' => $row->id_apoteker,
		// 'nama_apoteker' => $row->nama_apoteker,
		// 'jenis_kelamin' => $row->jenis_kelamin,
		// 'tempat_lahir' => $row->tempat_lahir,
		// 'tanggal_lahir' => $row->tanggal_lahir,
		// 'id_agama' => $row->id_agama,
		// 'alamat' => $row->alamat,
		// 'telp' => $row->telp,
		// 'id_status_menikah' => $row->id_status_menikah,
		// 'id_spesialis' => $row->id_spesialis,
		// 'no_izin_praktek' => $row->no_izin_praktek,
		// 'golongan_darah' => $row->golongan_darah,
		// 'alumni' => $row->alumni,
	 //    );
  //           $this->template->load('template','apoteker/tbl_apoteker_read', $data);
  //       } else {
  //           $this->session->set_flashdata('message', 'Record Not Found');
  //           redirect(site_url('apoteker'));
  //       }
  //   }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('apoteker/create_action'),
    	    'id_apoteker' => set_value('id_apoteker'),
    	    'nama_apoteker' => set_value('nama_apoteker'),
            'email' => set_value('email'),
            'telp' => set_value('telp'),
            'alamat' => set_value('alamat'),
            'no_sik_sipa' => set_value('no_sik_sipa'),
            'no_stra' => set_value('no_stra'),
            'tanggal_mulai_tugas' => set_value('tanggal_mulai_tugas'),
	);
        $this->template->load('template','master_data/apoteker/tbl_apoteker_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
        'nama_apoteker' => $this->input->post('nama_apoteker',TRUE),
		'email' => $this->input->post('email',TRUE),
        'telp' => $this->input->post('telp',TRUE),
        'alamat' => $this->input->post('alamat',TRUE),
        'no_sik_sipa' => $this->input->post('no_sik_sipa',TRUE),
        'no_stra' => $this->input->post('no_stra',TRUE),
        'tanggal_mulai_tugas' => $this->input->post('tanggal_mulai_tugas',TRUE),
	    );

            $this->Tbl_apoteker_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('apoteker'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_apoteker_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('apoteker/update_action'),
                'id_apoteker' => set_value('id_apoteker', $row->id_apoteker),
                'nama_apoteker' => set_value('nama_apoteker', $row->nama_apoteker),
                'email' => set_value('email', $row->email),
                'telp' => set_value('telp', $row->telp),
                'alamat' => set_value('alamat', $row->alamat),
                'no_sik_sipa' => set_value('no_sik_sipa', $row->no_sik_sipa),
                'no_stra' => set_value('no_stra', $row->no_stra),
                'tanggal_mulai_tugas' => set_value('tanggal_mulai_tugas', $row->tanggal_mulai_tugas),
	    );
            $this->template->load('template','master_data/apoteker/tbl_apoteker_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('apoteker'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_apoteker', TRUE));
        } else {
            $data = array(
        		'nama_apoteker' => $this->input->post('nama_apoteker',TRUE),
                'email' => $this->input->post('email',TRUE),
                'telp' => $this->input->post('telp',TRUE),
                'alamat' => $this->input->post('alamat',TRUE),
                'no_sik_sipa' => $this->input->post('no_sik_sipa',TRUE),
                'no_stra' => $this->input->post('no_stra',TRUE),
                'tanggal_mulai_tugas' => $this->input->post('tanggal_mulai_tugas',TRUE),
                'dtm_upd' => date("Y-m-d H:i:s",  time())
	    );

            $this->Tbl_apoteker_model->update($this->input->post('id_apoteker', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('apoteker'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_apoteker_model->get_by_id($id);

        if ($row) {
            $this->Tbl_apoteker_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('apoteker'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('apoteker'));
        }
    }

    public function _rules() 
    {
        
    $this->form_validation->set_rules('id_apoteker', 'id apoteker', 'trim');
	$this->form_validation->set_rules('nama_apoteker', 'nama apoteker', 'trim|required');
    $this->form_validation->set_rules('email', 'email', 'trim|required');
    $this->form_validation->set_rules('telp', 'no hp', 'trim|required');
    $this->form_validation->set_rules('alamat', 'alamat tinggal', 'trim|required');
    $this->form_validation->set_rules('no_sik_sipa', 'no_sik_sipa', 'trim|required');
    $this->form_validation->set_rules('no_stra', 'no_stra', 'trim|required');
    $this->form_validation->set_rules('tanggal_mulai_tugas', 'tanggal mulai tugas', 'trim|required');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    
    

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_apoteker.xls";
        $judul = "tbl_apoteker";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama apoteker");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Kelamin");
	xlsWriteLabel($tablehead, $kolomhead++, "Tempat Lahir");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Lahir");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Agama");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat Tinggal");
	xlsWriteLabel($tablehead, $kolomhead++, "No Hp");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Status Menikah");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Spesialis");
	xlsWriteLabel($tablehead, $kolomhead++, "No Izin Praktek");
	xlsWriteLabel($tablehead, $kolomhead++, "Golongan Darah");
	xlsWriteLabel($tablehead, $kolomhead++, "Alumni");

	foreach ($this->Tbl_apoteker_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_apoteker);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_kelamin);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tempat_lahir);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_lahir);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_agama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->telp);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_status_menikah);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_spesialis);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_izin_praktek);
	    xlsWriteLabel($tablebody, $kolombody++, $data->golongan_darah);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alumni);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_apoteker.doc");

        $data = array(
            'tbl_apoteker_data' => $this->Tbl_apoteker_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('apoteker/tbl_apoteker_doc',$data);
    }
    
    function autocomplate(){
        autocomplate_json('tbl_apoteker', 'nama_apoteker');
    }

}

/* End of file apoteker.php */
/* Location: ./application/controllers/apoteker.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-11-27 18:45:56 */
/* http://harviacode.com */