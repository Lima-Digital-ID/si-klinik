<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jasa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
	    $this->load->library('datatables');
        $this->load->model('Jasa_model');
        $this->load->library('form_validation');        

    }
    public function index()
    {
        $this->template->load('template','jasa/list-jasa');
    }
    public function json() {
        header('Content-Type: application/json');
        echo $this->Jasa_model->json();
    }
    public function _rules() 
    {
        $this->form_validation->set_rules('item', 'Jasa', 'trim|required');

        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('jasa/create_action'),
            'id_tipe' => set_value('id_tipe'),
            'item' => set_value('item'),
            'harga' => set_value('harga'),
        );
        $this->template->load('template','jasa/form-jasa', $data);
    }
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'item' => $this->input->post('item',TRUE),
                'harga' => $this->input->post('harga',TRUE),
            );
            $this->Jasa_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('jasa'));
        }
    }

    public function edit($id)
    {
        $row = $this->Jasa_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('jasa/update'),
                'id_tipe' => set_value('id_tipe',$row->id_tipe),
                'item' => set_value('item',$row->item),
                'harga' => set_value('harga',$row->harga),
            );
            $this->template->load('template','jasa/form-jasa', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('spesialis'));
        }
    }
    public function update() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id_tipe', TRUE));
        } else {
            $data = array(
		    'item' => $this->input->post('item',TRUE),
		    'harga' => $this->input->post('harga',TRUE),
	    );
            $this->Jasa_model->update($this->input->post('id_tipe', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('jasa'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Jasa_model->get_by_id($id);

        if ($row) {
            $this->Jasa_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jasa'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jasa'));
        }
    }

    
}