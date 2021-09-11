<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Absensi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('hrms/Tbl_jabatan_model');
        $this->load->model('hrms/Hrms_model');
        $this->load->model('hrms/Tbl_pegawai_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        $this->id_klinik = $this->session->userdata('id_klinik');
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }

    public function index()
    {
        $this->template->load('template','hrms/absensi/absensi_list');
    } 

    public function month()
    {
        $date=date('Y-m');
        $id_pegawai=1;
        if (isset($_POST['id_pegawai'])) {
            $id_pegawai=$this->input->post('id_pegawai');
            $tahun=$this->input->post('tahun');
            $bulan=$this->input->post('bulan');
            $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        }else{
            $tahun = date('Y'); //Mengambil tahun saat ini
            $bulan = date('m'); //Mengambil bulan saat ini
            $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        }
        $data['pegawai_option'] = array();
        $data['pegawai_option'][''] = 'Pilih Pegawai';
        foreach ($this->Tbl_pegawai_model->get_all($this->id_klinik) as $pegawai){
            $data['pegawai_option'][$pegawai->id_pegawai] = $pegawai->nama_pegawai;
        }

        $data1=array();
        $absensi=array();
        $month='';
        if ($id_pegawai != 0) {
            $data1=array();
            for ($i=1; $i <= $jumlah_hari; $i++) { 
                $month=$tahun.'-'.$bulan.'-'.$i;
                // echo $bulan;
                $absensi_pegawai=$this->Hrms_model->get_absensi_pegawai_by_day($id_pegawai, $month);
                $row=array();
                $day=(strlen($i) == 1 ? '0'.$i : $i);
                $newMonth=(strlen($bulan) == 1 ? '0'.$bulan : $bulan);
                $row['tanggal']= $day.'-'.$newMonth.'-'.$tahun;
                $row['date']= $month;
                if ($absensi_pegawai != null) {
                    $row['id_pegawai']= $absensi_pegawai->id_pegawai;
                    $row['nama_pegawai']= $absensi_pegawai->nama_pegawai;
                    $row['jam_datang']= ($absensi_pegawai->jam_datang != null ? $absensi_pegawai->jam_datang : '');
                    $row['jam_pulang']= ($absensi_pegawai->jam_pulang != null ? $absensi_pegawai->jam_pulang : '');   
                }else{
                    $row['jam_datang']= '';
                    $row['jam_pulang']= '';   
                }
                $row['action']       = anchor(site_url('hrms/set_gaji/update/').$pegawai->id_pegawai,'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
                    ".anchor(site_url('hrms/set_gaji/delete/').$pegawai->id_pegawai,'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                $data1[]=$row;
            }
            $absensi=array('nama_pegawai'=>$pegawai->nama_pegawai, 'data'=>$data1);
        }
        $data['absensi']=$absensi;
        $data['jumlah_hari']=$jumlah_hari;
        $data['id_pegawai']=$id_pegawai;
        $data['tanggal']=$date;

        $this->template->load('template','hrms/absensi/absensi_list_month', $data);
    } 
    
    public function json() {
        $date=date('Y-m-d');
        if (isset($_POST['date'])) {
            $date=$_POST['date'];
        }
        $data1=array();
        foreach ($this->Tbl_pegawai_model->get_all($this->id_klinik) as $pegawai){
            $absensi_pegawai=$this->db->where('tanggal', $date)->where('id_pegawai', $pegawai->id_pegawai)->get('tbl_absensi_pegawai')->row();
            $row=array();
            $row['id_pegawai']= $pegawai->id_pegawai;
            $row['nama_pegawai']= $pegawai->nama_pegawai;
            $row['tanggal']= $date;
            if ($absensi_pegawai != null) {
                $row['jam_datang']= ($absensi_pegawai->jam_datang != null ? $absensi_pegawai->jam_datang : '');
                $row['jam_pulang']= ($absensi_pegawai->jam_pulang != null ? $absensi_pegawai->jam_pulang : '');   
            }else{
                $row['jam_datang']= '';
                $row['jam_pulang']= '';   
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
        $data = array(
            'button' => 'Create',
            'action' => site_url('hrms/jabatan/create_action'),
            'id_jabatan' => set_value('id_jabatan'),
            'nama_jabatan' => set_value('nama_jabatan'),
    );
        $this->template->load('template','hrms/absensi/tbl_jabatan_create', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
            'nama_jabatan' => $this->input->post('nama_jabatan',TRUE),
        );

            $this->Tbl_jabatan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('hrms/absensi'));
        }
    }
    
    public function update($id, $date) 
    {
        $row = $this->Hrms_model->get_absensi_by_id_pegawai($id, $date);
        // print_r($row);
        // exit();
        if ($row == null) {
            $this->db->insert('Tbl_absensi_pegawai',array('id_pegawai'=>$id, 'tanggal'=>$date));
            $row = $this->Hrms_model->get_absensi_by_id_pegawai($id, $date);
        }
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('hrms/absensi/update_action'),
                'id_absensi' => set_value('id_absensi', $row->id_absensi),
                'id_pegawai' => set_value('id_pegawai', $row->id_pegawai),
                'nama_pegawai' => set_value('nama_pegawai', $row->nama_pegawai),
                'tanggal' => set_value('tanggal', $row->tanggal),
                'jam_datang' => set_value('jam_datang', $row->jam_datang),
                'jam_pulang' => set_value('jam_pulang', $row->jam_pulang),
        );
            $this->template->load('template','hrms/absensi/absensi_update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hrms/absensi'));
        }
    }
   
    public function update_action() 
    {
        $data = array(
            'id_pegawai' => $this->input->post('id_pegawai',TRUE),
            'tanggal' => $this->input->post('tanggal',TRUE),
            'jam_datang' => $this->input->post('jam_datang',TRUE),
            'jam_pulang' => $this->input->post('jam_pulang',TRUE),
            'dtm_upd' => date("Y-m-d H:i:s",  time())
        );
        $where=array('id_absensi'=>$this->input->post('id_absensi', TRUE));
        $this->Hrms_model->update($where, $data, 'Tbl_absensi_pegawai');
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url('hrms/absensi'));
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_jabatan_model->get_by_id($id);

        if ($row) {
            $this->Tbl_jabatan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('hrms/absensi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hrms/absensi'));
        }
    }
    public function lembur(){
        $data = array(
            'button' => 'Create',
            'action' => site_url('hrms/absensi/save_lembur'),
        );
        $data['pegawai_option'] = array();
        $data['pegawai_option'][''] = 'Pilih Pegawai';
        foreach ($this->Tbl_pegawai_model->get_all($this->id_klinik) as $pegawai){
            $data['pegawai_option'][$pegawai->id_pegawai] = $pegawai->nama_pegawai;
        }
        $this->template->load('template','hrms/absensi/create_durasi_lembur', $data);
    }
    public function save_lembur(){
        $id=$this->input->post('id_pegawai');
        $date=$this->input->post('tanggal');
        $row = $this->Hrms_model->get_absensi_by_id_pegawai($id, $date);
        if ($row == null) {
            $this->db->insert('Tbl_absensi_pegawai',array('id_pegawai'=>$id, 'tanggal'=>$date));
            $row = $this->Hrms_model->get_absensi_by_id_pegawai($id, $date);

            $data = array(
                'durasi_lembur' => $this->input->post('durasi',TRUE),
                'dtm_upd' => date("Y-m-d H:i:s",  time())
            );
            $where=array('id_absensi'=>$row->id_absensi);
            $this->Hrms_model->update($where, $data, 'Tbl_absensi_pegawai');
            redirect(site_url('hrms/absensi'));
        }else{
            $data = array(
                'durasi_lembur' => $this->input->post('durasi',TRUE),
                'dtm_upd' => date("Y-m-d H:i:s",  time())
            );
            $where=array('id_absensi'=>$row->id_absensi);
            $this->Hrms_model->update($where, $data, 'Tbl_absensi_pegawai');
            redirect(site_url('hrms/absensi'));
        }
    }

    public function import_excel(){
        $this->template->load('template','hrms/absensi/import_excel');
    }
    
    public function upload(){
        $bulan=$this->input->post('bulan');
        $tahun=$this->input->post('tahun');
        $fileName = time().$_FILES['file']['name'];
         
        $config['upload_path'] = 'assets/import_excel/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
         
        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('file') )
        $this->upload->display_errors();
             
        $inputFileName = 'assets/import_excel/'.$fileName;
        
        // try {
        if (is_readable($inputFileName)) {
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        }else{
            $this->session->set_flashdata('message', 'File Tidak Bisa Terbaca');
            $this->session->set_flashdata('message_type', 'danger');
            redirect($_SERVER['HTTP_REFERER']);
        }
        // } catch(Exception $e) {
        //     die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        // }
 
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        
        $data_existing = array();
        $error_data = false;
        $error_desc = '';
        $jmlsukses = 0;
        $jmlgagal = 0;

        for ($row = 7; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
            $data=$this->db->where('nama_pegawai', $rowData[0][1])->get('tbl_pegawai')->row();
            $absen='';
            $day=0;
            for ($i=0; $i < count($rowData[0]); $i++) { 
                if($i >= 2){
                    $day++;
                    if($rowData[0][$i] != null){
                        $absensi=trim($rowData[0][$i]);
                        $absen=preg_split('/\r\n|\r|\n/', $absensi);
                    }else{
                        $absen=['', ''];
                    }

                    // $tanggal=$tahun.'-'.(strlen($bulan) == 1 ? '0'.$bulan : $bulan).'-'.(strlen($day) == 1 ? '0'.$day : $day);
                    $tanggal=$tahun.'-'.$bulan.'-'.$day;
                    $data_import=array(
                        'id_pegawai'        => $data->id_pegawai,
                        'jam_datang'        => $absen[0],
                        'jam_pulang'        => (count($absen) == 1 ? '' : $absen[1]),
                        'tanggal'           => $tanggal,
                    );
                    $cekabsensi=$this->db->where('tanggal', $tanggal)->where('id_pegawai', $data->id_pegawai)->get('Tbl_absensi_pegawai')->num_rows();
                    if ($cekabsensi == 0) {
                        $this->db->insert('Tbl_absensi_pegawai', $data_import);
                    }
                }
            }
        }
        //Hapus file import
        $this->load->helper("file");
        delete_files($config['upload_path']); 
        redirect(site_url('hrms/absensi'));
    }
}