<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tindakan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
	    $this->load->library('datatables');
        $this->load->model('Tbl_tindakan_model');
        $this->load->library('form_validation');        

    }
    public function index()
    {
        $this->template->load('template','master_data/tindakan/tbl_tindakan_list');
    }
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_tindakan_model->json();
    }
    public function _rules() 
    {
        // $this->form_validation->set_rules('kode_tindakan', 'Kode Tindakan', 'trim|required');
        $this->form_validation->set_rules('tindakan', 'Tindakan', 'trim|required');
        $this->form_validation->set_rules('biaya', 'Biaya', 'trim|required');
        $this->form_validation->set_rules('tipe', 'Tipe', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tindakan/create_action'),
            'kode_tindakan' => set_value('kode_tindakan'),
            'tindakan' => set_value('tindakan'),
            'biaya' => set_value('biaya'),
            'tipe' => set_value('tipe'),
        );
        $this->template->load('template','master_data/tindakan/tbl_tindakan_form', $data);
    }
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'kode_tindakan' => $this->input->post('kode_tindakan', TRUE),
                'tindakan' => $this->input->post('tindakan',TRUE),
                'biaya' => $this->input->post('biaya',TRUE),
                'tipe' => $this->input->post('tipe',TRUE),
            );
            $this->Tbl_tindakan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('tindakan'));
        }
    }

    public function edit($id)
    {
        $row = $this->Tbl_tindakan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tindakan/update'),
                'kode_tindakan' => set_value('kode_tindakan',$row->kode_tindakan),
                'tindakan' => set_value('tindakan',$row->tindakan),
                'biaya' => set_value('biaya',$row->biaya),
                'tipe' => set_value('tipe',$row->tipe),
            );
            $this->template->load('template','master_data/tindakan/tbl_tindakan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('spesialis'));
        }
    }
    public function update() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('kode_tindakan', TRUE));
        } else {
            $data = array(
                'tindakan' => $this->input->post('tindakan',TRUE),
                'biaya' => $this->input->post('biaya',TRUE),
                'tipe' => $this->input->post('tipe',TRUE),
            );
            $this->Tbl_tindakan_model->update($this->input->post('kode_tindakan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tindakan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_tindakan_model->get_by_id($id);

        if ($row) {
            $this->Tbl_tindakan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tindakan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tindakan'));
        }
    }

    
}