<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tipe_lab extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
	    $this->load->library('datatables');
        $this->load->model('Tbl_tipe_lab_model');
        $this->load->library('form_validation');        
    }
    public function index()
    {
        $this->template->load('template','master_data/tipe_lab/tipe_lab_list');
    }
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_tipe_lab_model->json();
    }
    public function _rules() 
    {
        // $this->form_validation->set_rules('kode_tindakan', 'Kode Tindakan', 'trim|required');
        $this->form_validation->set_rules('item', 'Item', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tipe_lab/create_action'),
            'id_tipe' => set_value('id_tipe'),
            'item' => set_value('item'),
            'harga' => set_value('harga'),
            'nilai_normal' => set_value('nilai_normal'),
            'diet' => set_value('diet'),
        );
        $this->template->load('template','master_data/tipe_lab/tbl_tipe_lab_form', $data);
    }
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'item' => $this->input->post('item', TRUE),
                'harga' => $this->input->post('harga',TRUE),
                'nilai_normal' => $this->input->post('nilai_normal',TRUE),
                'diet' => $this->input->post('diet',TRUE),
            );
            $this->Tbl_tipe_lab_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('tipe_lab'));
        }
    }

    public function edit($id)
    {
        $row = $this->Tbl_tipe_lab_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tipe_lab/update'),
                'id_tipe' => set_value('id_tipe',$row->id_tipe),
                'item' => set_value('item',$row->item),
                'harga' => set_value('harga',$row->harga),
                'nilai_normal' => set_value('nilai_normal',$row->nilai_normal),
                'diet' => set_value('diet',$row->diet),
            );
            $this->template->load('template','master_data/tipe_lab/tbl_tipe_lab_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tipe_lab'));
        }
    }
    public function update() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id_tipe', TRUE));
        } else {
            $data = array(
                'item' => $this->input->post('item', TRUE),
                'harga' => $this->input->post('harga',TRUE),
                'nilai_normal' => $this->input->post('nilai_normal',TRUE),
                'diet' => $this->input->post('diet',TRUE),
            );
            $this->Tbl_tipe_lab_model->update($this->input->post('id_tipe', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tipe_lab'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_tipe_lab_model->get_by_id($id);

        if ($row) {
            $this->Tbl_tipe_lab_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tipe_lab'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tipe_lab'));
        }
    }

    
}