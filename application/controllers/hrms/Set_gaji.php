<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Set_gaji extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('hrms/Tbl_ref_gaji_model');
        $this->load->model('hrms/Tbl_jabatan_model');
        $this->load->model('hrms/Hrms_model');
        $this->load->model('hrms/Tbl_pegawai_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        $this->id_klinik = $this->session->userdata('id_klinik');
    }

    public function index()
    {
        $this->template->load('template','hrms/setting_gaji/setting_gaji_list');
    } 
    
    public function json() {
        $data=$this->Hrms_model->json_setting_gaji($this->id_klinik);
        $data1=array();
        foreach ($data as $key => $value) {
            $row=array();
            $row['id_setting_gaji']= $value->id_setting_gaji;
            $row['nama_pegawai']= $value->nama_pegawai;
            $row['nama_jabatan']= $value->nama_jabatan;
            $row['gaji_pokok']= 'Rp. '.number_format($value->gaji_pokok, 0, '.', '.');
            $row['uang_kehadiran']  = 'Rp. '.number_format($value->uang_kehadiran, 0, '.', '.');
            $row['uang_makan']   = 'Rp. '.number_format($value->uang_makan, 0, '.', '.');
            $row['uang_transport']   = 'Rp. '.number_format($value->uang_transport, 0, '.', '.');
            $row['uang_lembur']   = 'Rp. '.number_format($value->uang_lembur, 0, '.', '.');
            $row['tunjangan']   = 'Rp. '.number_format($value->tunjangan, 0, '.', '.');
            $row['action']       = anchor(site_url('hrms/set_gaji/update/').$value->id_setting_gaji,'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
                ".anchor(site_url('hrms/set_gaji/delete/').$value->id_setting_gaji,'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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
            'action' => site_url('hrms/set_gaji/create_action'),
            'id_set_gaji' => set_value('id_set_gaji'),
            'id_pegawai' => set_value('id_pegawai'),
            'gaji_pokok' => set_value('gaji_pokok'),
            'uang_kehadiran' => set_value('uang_kehadiran'),
            'uang_makan' => set_value('uang_makan'),
            'uang_transport' => set_value('uang_transport'),
            'uang_lembur' => set_value('uang_lembur'),
            'potongan_telat' => set_value('potongan_telat'),
            'tunjangan' => set_value('tunjangan'),
    );
        $data['pegawai_option'] = array();
        $data['pegawai_option'][0] = 'Pilih Pegawai';
        foreach ($this->Tbl_pegawai_model->get_all($this->id_klinik) as $pegawai){
            $data['pegawai_option'][$pegawai->id_pegawai] = $pegawai->nama_pegawai;
        }
        $this->template->load('template','hrms/setting_gaji/setting_gaji_create', $data);
    }
    
    public function get_referensi($id){
        $pegawai=$this->Tbl_pegawai_model->get_by_id($id);
        $ref_gaji=$this->Tbl_ref_gaji_model->get_by_jabatan($pegawai->id_jabatan);
        header('Content-Type: application/json');
        echo json_encode($ref_gaji);
    }
    public function create_action() 
    {
        $gaji_pokok = $this->input->post('gaji_pokok',TRUE);
        $uang_kehadiran = ($this->input->post('check_uk') ? $this->input->post('uang_kehadiran',TRUE) : '');
        $uang_makan = ($this->input->post('check_um') ? $this->input->post('uang_makan',TRUE) : '');
        $uang_transport = ($this->input->post('check_ut') ? $this->input->post('uang_transport',TRUE) : '');
        $uang_lembur = $this->input->post('uang_lembur',TRUE);
        $potongan_telat = $this->input->post('potongan_telat',TRUE);
        $tunjangan = $this->input->post('tunjangan',TRUE);

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
            'id_pegawai' => $this->input->post('id_pegawai',TRUE),
            'gaji_pokok' => $this->currency($gaji_pokok),
            'uang_kehadiran' => $this->currency($uang_kehadiran),
            'uang_makan' => $this->currency($uang_makan),
            'uang_transport' => $this->currency($uang_transport),
            'uang_lembur' => $this->currency($uang_lembur),
            'potongan_telat' => $this->currency($potongan_telat),
            'tunjangan' => $this->currency($tunjangan),
        );
            $check=$this->db->where('id_pegawai', $this->input->post('id_pegawai'))->get('Tbl_setting_gaji')->num_rows();
            if ($check < 1) {
                $this->Hrms_model->insert_setting('Tbl_setting_gaji', $data);
                $this->session->set_flashdata('message', 'Create Record Success 2');
                redirect(site_url('hrms/set_gaji'));
            }else{
                $this->session->set_flashdata('message', 'Input gagal, data pegawai yang diinput telah ter record sebelumnya');
                redirect(site_url('hrms/set_gaji'));
            }
        }
    }

    public function update($id) 
    {
        $row = $this->Hrms_model->get_setting_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('hrms/set_gaji/update_action'),
                'id_set_gaji' => set_value('id_set_gaji', $row->id_setting_gaji),
                'id_pegawai' => set_value('id_pegawai', $row->id_pegawai),
                'gaji_pokok' => set_value('gaji_pokok', $row->gaji_pokok),
                'uang_kehadiran' => set_value('uang_kehadiran', $row->uang_kehadiran),
                'uang_makan' => set_value('uang_makan', $row->uang_makan),
                'uang_transport' => set_value('uang_transport', $row->uang_transport),
                'uang_lembur' => set_value('uang_lembur', $row->uang_lembur),
                'potongan_telat' => set_value('potongan_telat', $row->potongan_telat),
                'tunjangan' => set_value('tunjangan', $row->tunjangan),

        );
            $data['pegawai_option'] = array();
            $data['pegawai_option'][0] = 'Pilih Pegawai';
            foreach ($this->Tbl_pegawai_model->get_all($this->id_klinik) as $pegawai){
                $data['pegawai_option'][$pegawai->id_pegawai] = $pegawai->nama_pegawai;
            }
            $this->template->load('template','hrms/setting_gaji/setting_gaji_update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hrms/set_gaji'));
        }
    }
    
    public function update_action() 
    {
        $gaji_pokok = $this->input->post('gaji_pokok',TRUE);
        $uang_kehadiran = ($this->input->post('check_uk') ? $this->input->post('uang_kehadiran',TRUE) : '');
        $uang_makan = ($this->input->post('check_um') ? $this->input->post('uang_makan',TRUE) : '');
        $uang_transport = ($this->input->post('check_ut') ? $this->input->post('uang_transport',TRUE) : '');
        $uang_lembur = $this->input->post('uang_lembur',TRUE);
        $potongan_telat = $this->input->post('potongan_telat',TRUE);
        $tunjangan = $this->input->post('tunjangan',TRUE);
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_set_gaji', TRUE));
        } else {
            $data = array(
                'gaji_pokok' => $this->currency($gaji_pokok),
                'uang_kehadiran' => $this->currency($uang_kehadiran),
                'uang_makan' => $this->currency($uang_makan),
                'uang_transport' => $this->currency($uang_transport),
                'uang_lembur' => $this->currency($uang_lembur),
                'potongan_telat' => $this->currency($potongan_telat),
                'tunjangan' => $this->currency($tunjangan),
                'dtm_upd' => date("Y-m-d H:i:s",  time())
        );
            $where=array('id_setting_gaji'=>$this->input->post('id_set_gaji', TRUE));
            $this->Hrms_model->update($where, $data, 'Tbl_setting_gaji');
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('hrms/set_gaji'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Hrms_model->get_setting_by_id($id);

        if ($row) {
            $where=array('id_setting_gaji'=>$id);
            $this->Hrms_model->delete($where, 'Tbl_setting_gaji');
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('hrms/set_gaji'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hrms/set_gaji'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('id_pegawai', 'id set_gaji', 'trim');
        $this->form_validation->set_rules('gaji_pokok', 'gaji_pokok', 'trim|required');
        $this->form_validation->set_rules('uang_kehadiran', 'uang_kehadiran', 'trim');
        $this->form_validation->set_rules('uang_transport', 'uang_transport', 'trim');
        $this->form_validation->set_rules('uang_makan', 'uang_makan', 'trim');
        $this->form_validation->set_rules('uang_lembur', 'uang_lembur', 'trim');
        $this->form_validation->set_rules('tunjangan', 'tunjangan', 'trim');
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