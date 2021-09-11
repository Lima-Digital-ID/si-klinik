<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_ref extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Master_reference_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $this->data['master_ref_code_opt'] = array();
    	$this->data['master_ref_code_opt'][''] = '--- Semua ---';
    	foreach ($this->Master_reference_model->get_all_group_by_mastercode() as $data){
            $this->data['master_ref_code_opt'][$data->master_ref_code] = $data->master_ref_code;
        }
        
        $this->data['master_ref_code'] = set_value('master_ref_code');
        $this->data['master_ref_code_json'] = $this->input->post('master_ref_code') != null ? $this->input->post('master_ref_code') : null;
        
        $this->template->load('template','master_ref/master_ref_list', $this->data);
    } 
    
    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('master_ref/create_action'),
            'id' => set_value('id'),
    	    'master_ref_code' => set_value('master_ref_code'),
    	    'master_ref_value' => set_value('master_ref_value'),
    	    'master_ref_name' => set_value('master_ref_name'),
    	    'master_ref_code_opt' => array()
    	);
    	
    	$data['master_ref_code_opt'][''] = '--- Pilih Master Ref Code ---';
    	foreach ($this->Master_reference_model->get_all_group_by_mastercode() as $datas){
            $data['master_ref_code_opt'][$datas->master_ref_code] = $datas->master_ref_code;
        }
        
        $this->template->load('template','master_ref/master_ref_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'master_ref_code' => strtoupper($this->input->post('master_ref_code',TRUE)),
                'master_ref_value' => $this->input->post('master_ref_value',TRUE),
                'master_ref_name' => $this->input->post('master_ref_name',TRUE),
    	    );

            $this->Master_reference_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('master_ref'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Master_reference_model->get_by_id($id);
        
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('master_ref/update_action'),
                'id' => set_value('id', $row->id),
        		'master_ref_code' => set_value('master_ref_code', $row->master_ref_code),
        	    'master_ref_value' => set_value('master_ref_value', $row->master_ref_value),
        	    'master_ref_name' => set_value('master_ref_name', $row->master_ref_name),
        	    'master_ref_code_opt' => array(),
        	);
        	
        	$data['master_ref_code_opt'][''] = '--- Pilih Master Ref Code ---';
        	foreach ($this->Master_reference_model->get_all_group_by_mastercode() as $datas){
                $data['master_ref_code_opt'][$datas->master_ref_code] = $datas->master_ref_code;
            }
        	
            $this->template->load('template','master_ref/master_ref_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_ref'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'master_ref_code' => strtoupper($this->input->post('master_ref_code',TRUE)),
                'master_ref_value' => $this->input->post('master_ref_value',TRUE),
                'master_ref_name' => $this->input->post('master_ref_name',TRUE),
                'dtm_upd' => date("Y-m-d H:i:s",  time())
    	    );

            $this->Master_reference_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('master_ref'));
        }
    }
    
    public function json($filter = null) {
        header('Content-Type: application/json');
        echo $this->Master_reference_model->json($filter);
    }

    public function delete($id) 
    {
        $row = $this->Master_reference_model->get_by_id($id);

        if ($row) {
            $this->Master_reference_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('master_ref'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_ref'));
        }
    }
    
    public function _rules() 
    {
        // $this->form_validation->set_rules('kode_dokter', 'kode dokter', 'trim|required');
    	$this->form_validation->set_rules('master_ref_code', 'Master Ref Code', 'trim|required');
    	$this->form_validation->set_rules('master_ref_value', 'Master Ref Value', 'trim|required');
    	$this->form_validation->set_rules('master_ref_name', 'Master Ref Name', 'trim|required');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
