<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ref_gaji extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('hrms/Tbl_ref_gaji_model');
        $this->load->model('hrms/Tbl_jabatan_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','hrms/master_ref_gaji/tbl_ref_gaji_list');
    } 
    
    public function json() {
        $data=$this->Tbl_ref_gaji_model->json();
        $data1=array();
        foreach ($data as $key => $value) {
            $row=array();
            $row['id_ref_gaji']= $value->id_ref_gaji;
            $row['nama_jabatan']= $value->nama_jabatan;
            $row['gaji_pokok']= 'Rp. '.number_format($value->gaji_pokok, 0, '.', '.');
            $row['uang_kehadiran']  = 'Rp. '.number_format($value->uang_kehadiran, 0, '.', '.');
            $row['uang_makan']   = 'Rp. '.number_format($value->uang_makan, 0, '.', '.');
            $row['uang_transport']   = 'Rp. '.number_format($value->uang_transport, 0, '.', '.');
            $row['uang_lembur']   = 'Rp. '.number_format($value->uang_lembur, 0, '.', '.');
            $row['action']       = anchor(site_url('hrms/ref_gaji/update/').$value->id_ref_gaji,'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
                ".anchor(site_url('hrms/ref_gaji/delete/').$value->id_ref_gaji,'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
            $data1[]=$row;
        }
        $output = array(
                        "draw" => 0,
                        "recordsTotal" => count($data1),
                        "recordsFiltered" => count($data1),
                        "data" => $data1,
                );
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('hrms/ref_gaji/create_action'),
            'id_ref_gaji' => set_value('id_ref_gaji'),
            'id_jabatan' => set_value('id_jabatan'),
            'gaji_pokok' => set_value('gaji_pokok'),
            'uang_kehadiran' => set_value('uang_kehadiran'),
            'uang_makan' => set_value('uang_makan'),
            'uang_transport' => set_value('uang_transport'),
            'uang_lembur' => set_value('uang_lembur'),
    );
        $data['jabatan_option'] = array();
        $data['jabatan_option'][''] = 'Pilih Jabatan';
        foreach ($this->Tbl_jabatan_model->get_all() as $jabatan){
            $data['jabatan_option'][$jabatan->id_jabatan] = $jabatan->nama_jabatan;
        }
        $this->template->load('template','hrms/master_ref_gaji/tbl_ref_gaji_create', $data);
    }
    
    public function create_action() 
    {
        $gaji_pokok = $this->input->post('gaji_pokok',TRUE);
        $uang_kehadiran = $this->input->post('uang_kehadiran',TRUE);
        $uang_makan = $this->input->post('uang_makan',TRUE);
        $uang_transport = $this->input->post('uang_transport',TRUE);
        $uang_lembur = $this->input->post('uang_lembur',TRUE);
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
            'id_jabatan' => $this->input->post('id_jabatan',TRUE),
            'gaji_pokok' => $this->currency($gaji_pokok),
            'uang_kehadiran' => $this->currency($uang_kehadiran),
            'uang_makan' => $this->currency($uang_makan),
            'uang_transport' => $this->currency($uang_transport),
            'uang_lembur' => $this->currency($uang_lembur),
        );
            $check=$this->db->where('id_jabatan', $this->input->post('id_jabatan'))->get('tbl_ref_gaji')->num_rows();
            if ($check < 1) {
                $this->Tbl_ref_gaji_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success 2');
                redirect(site_url('hrms/ref_gaji'));
            }else{
                $this->session->set_flashdata('message', 'Input gagal, Jabatan yang diinput telah ter record');
                redirect(site_url('hrms/ref_gaji'));
            }
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_ref_gaji_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('hrms/ref_gaji/update_action'),
                'id_ref_gaji' => set_value('id_ref_gaji', $row->id_ref_gaji),
                'id_jabatan' => set_value('id_jabatan', $row->id_jabatan),
                'gaji_pokok' => set_value('gaji_pokok', $row->gaji_pokok),
                'uang_kehadiran' => set_value('uang_kehadiran', $row->uang_kehadiran),
                'uang_makan' => set_value('uang_makan', $row->uang_makan),
                'uang_transport' => set_value('uang_transport', $row->uang_transport),
                'uang_lembur' => set_value('uang_transport', $row->uang_lembur),

        );
            $data['jabatan_option'] = array();
            $data['jabatan_option'][''] = 'Pilih Jabatan';
            foreach ($this->Tbl_jabatan_model->get_all() as $jabatan){
                $data['jabatan_option'][$jabatan->id_jabatan] = $jabatan->nama_jabatan;
            }
            $this->template->load('template','hrms/master_ref_gaji/tbl_ref_gaji_create', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hrms/ref_gaji'));
        }
    }
    
    public function update_action() 
    {
        $gaji_pokok = $this->input->post('gaji_pokok',TRUE);
        $uang_kehadiran = $this->input->post('uang_kehadiran',TRUE);
        $uang_makan = $this->input->post('uang_makan',TRUE);
        $uang_transport = $this->input->post('uang_transport',TRUE);
        $uang_lembur = $this->input->post('uang_lembur',TRUE);
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_ref_gaji', TRUE));
        } else {
            $data = array(
                'id_jabatan' => $this->input->post('id_jabatan',TRUE),
                'gaji_pokok' => $this->currency($gaji_pokok),
                'uang_kehadiran' => $this->currency($uang_kehadiran),
                'uang_makan' => $this->currency($uang_makan),
                'uang_transport' => $this->currency($uang_transport),
                'uang_lembur' => $this->currency($uang_lembur),
                'dtm_upd' => date("Y-m-d H:i:s",  time())
        );

            $this->Tbl_ref_gaji_model->update($this->input->post('id_ref_gaji', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('hrms/ref_gaji'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_ref_gaji_model->get_by_id($id);

        if ($row) {
            $this->Tbl_ref_gaji_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('hrms/ref_gaji'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hrms/ref_gaji'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('id_ref_gaji', 'id ref_gaji', 'trim');
        $this->form_validation->set_rules('id_jabatan', 'id_jabatan', 'trim|required');
        $this->form_validation->set_rules('gaji_pokok', 'gaji_pokok', 'trim|required');
        $this->form_validation->set_rules('uang_kehadiran', 'uang_kehadiran', 'trim|required');
        $this->form_validation->set_rules('uang_transport', 'uang_transport', 'trim|required');
        $this->form_validation->set_rules('uang_makan', 'uang_makan', 'trim|required');
        $this->form_validation->set_rules('uang_lembur', 'uang_lembur', 'trim|required');
    }
    
    private function currency($val){
        $data=explode('.', $val);
        $new=implode('', $data);
        return $new;
    }

}

/* End of file Dokter.php */
/* Location: ./application/controllers/Dokter.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-11-27 18:45:56 */
/* http://harviacode.com */