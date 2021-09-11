<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Absensi_pegawai extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('hrms/Tbl_ref_gaji_model');
        $this->load->model('hrms/Tbl_jabatan_model');
        $this->load->model('hrms/Hrms_model');
        $this->load->model('Tbl_pegawai_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        $this->id_klinik = $this->session->userdata('id_klinik');
    }

    public function index()
    {
        $this->template->load('template','hrms/absensi_pegawai/absensi_pegawai_list');
    } 
    
    // public function json() {
    //     header('Content-Type: application/json');
    //     echo json_encode($this->Hrms_model->json_setting_gaji($this->id_klinik));
    // }

    public function json() {
        $date=date('Y-m-d');
        if (isset($_POST['date'])) {
            $date=$_POST['date'];
        }
        $data1=array();
        foreach ($this->Tbl_pegawai_model->get_all($this->id_klinik) as $pegawai){
            $absensi_pegawai=$this->db->where('tanggal', $date)->where('id_pegawai', $pegawai->id_pegawai)->get('Tbl_absensi_pegawai')->row();
            $row=array();
            $row['id_pegawai']= $pegawai->id_pegawai;
            $row['nama_pegawai']= $pegawai->nama_pegawai;
            $row['tanggal']= $date;
            if ($absensi_pegawai != null) {
                $row['jam_datang']= ($absensi_pegawai->jam_datang != null ? $absensi_pegawai->jam_datang : '');
                $row['jam_pulang']= ($absensi_pegawai->jam_pulang != null ? $absensi_pegawai->jam_pulang : '');   
            }else{
                $row['jam_datang']= '-';
                $row['jam_pulang']= '-';   
            }
            $row['action']       = anchor(site_url('hrms/set_gaji/update/').$pegawai->id_pegawai,'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
                ".anchor(site_url('hrms/set_gaji/delete/').$pegawai->id_pegawai,'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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
        // $tahun = date('Y'); //Mengambil tahun saat ini
        // $bulan = date('m'); //Mengambil bulan saat ini
        // $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // echo "Jumlah hari pada bulan saat ini adalah <b>{$tanggal}</b>";
        $data = array(
            'button' => 'Create',
            'action' => site_url('hrms/absensi_pegawai/create_action'),
            'id_pegawai' => set_value('id_pegawai'),
            'gaji_pokok' => set_value('gaji_pokok'),
            'uang_kehadiran' => set_value('uang_kehadiran'),
            'uang_makan' => set_value('uang_makan'),
            'uang_transport' => set_value('uang_transport'),
            'tunjangan' => set_value('tunjangan'),
    );
        $data['pegawai_option'] = array();
        $data['pegawai_option'][''] = 'Pilih Pegawai';
        foreach ($this->Tbl_pegawai_model->get_all($this->id_klinik) as $pegawai){
            $data['pegawai_option'][$pegawai->id_pegawai] = $pegawai->nama_pegawai;
        }
        $this->template->load('template','hrms/absensi_pegawai/absensi_pegawai_create', $data);
    }
    
    public function get_referensi($id){
        $pegawai=$this->Tbl_pegawai_model->get_by_id($id);
        $ref_gaji=$this->Tbl_ref_gaji_model->get_by_jabatan($pegawai->id_jabatan);
        header('Content-Type: application/json');
        echo json_encode($ref_gaji);
    }

    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
            'id_pegawai' => $this->input->post('id_pegawai',TRUE),
            'gaji_pokok' => $this->input->post('gaji_pokok',TRUE),
            'uang_kehadiran' => $this->input->post('uang_kehadiran',TRUE),
            'uang_makan' => $this->input->post('uang_makan',TRUE),
            'uang_transport' => $this->input->post('uang_transport',TRUE),
            'tunjangan' => $this->input->post('tunjangan',TRUE),
        );
            $check=$this->db->where('id_pegawai', $this->input->post('id_pegawai'))->get('Tbl_absensi_pegawai')->num_rows();
            if ($check < 1) {
                $this->Hrms_model->insert_setting('Tbl_absensi_pegawai', $data);
                $this->session->set_flashdata('message', 'Create Record Success 2');
                redirect(site_url('hrms/absensi_pegawai'));
            }else{
                $this->session->set_flashdata('message', 'Input gagal, data pegawai yang diinput telah ter record sebelumnya');
                redirect(site_url('hrms/absensi_pegawai'));
            }
        }
    }
    
    public function update($id) 
    {
        $row = $this->absensi_pegawai_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('hrms/absensi_pegawai/update_action'),
                'id_absensi_pegawai' => set_value('id_absensi_pegawai', $row->id_absensi_pegawai),
                'id_jabatan' => set_value('id_jabatan', $row->id_jabatan),
                'gaji_pokok' => set_value('gaji_pokok', $row->gaji_pokok),
                'uang_kehadiran' => set_value('uang_kehadiran', $row->uang_kehadiran),
                'uang_makan' => set_value('uang_makan', $row->uang_makan),
                'uang_transport' => set_value('uang_transport', $row->uang_transport),

        );
            $data['jabatan_option'] = array();
            $data['jabatan_option'][''] = 'Pilih Jabatan';
            foreach ($this->Tbl_jabatan_model->get_all() as $jabatan){
                $data['jabatan_option'][$jabatan->id_jabatan] = $jabatan->nama_jabatan;
            }
            $this->template->load('template','hrms/absensi_pegawai/absensi_pegawai_create', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hrms/absensi_pegawai'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_absensi_pegawai', TRUE));
        } else {
            $data = array(
                'id_jabatan' => $this->input->post('id_jabatan',TRUE),
                'gaji_pokok' => $this->input->post('gaji_pokok',TRUE),
                'uang_kehadiran' => $this->input->post('uang_kehadiran',TRUE),
                'uang_makan' => $this->input->post('uang_makan',TRUE),
                'uang_transport' => $this->input->post('uang_transport',TRUE),
                'dtm_upd' => date("Y-m-d H:i:s",  time())
        );

            $this->absensi_pegawai_model->update($this->input->post('id_absensi_pegawai', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('hrms/absensi_pegawai'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->absensi_pegawai_model->get_by_id($id);

        if ($row) {
            $this->absensi_pegawai_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('hrms/absensi_pegawai'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hrms/absensi_pegawai'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('id_pegawai', 'id absensi_pegawai', 'trim');
        $this->form_validation->set_rules('gaji_pokok', 'gaji_pokok', 'trim|required');
        $this->form_validation->set_rules('uang_kehadiran', 'uang_kehadiran', 'trim|required');
        $this->form_validation->set_rules('uang_transport', 'uang_transport', 'trim|required');
        $this->form_validation->set_rules('uang_makan', 'uang_makan', 'trim|required');
        $this->form_validation->set_rules('tunjangan', 'tunjangan', 'trim|required');
    }
    
    

}

/* End of file Dokter.php */
/* Location: ./application/controllers/Dokter.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-11-27 18:45:56 */
/* http://harviacode.com */