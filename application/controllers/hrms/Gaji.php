<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gaji extends CI_Controller
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
    }

    public function index()
    {
        $this->template->load('template','hrms/absensi/absensi_list');
    }
    public function potongan()
    {
        $this->template->load('template','hrms/absensi/absensi_list');
    } 
    public function slip($id){
        $bulan=0;
        if ($this->input->post('bulan')) {
            $bulan=$this->input->post('tahun').'-'.$this->input->post('bulan');
        }elseif ($this->session->userdata('bulan')) {
            $bulan=$this->session->userdata('bulan');
        }else{
            $bulan=date('Y-m');
        }
        $data['absensi']=$this->Hrms_model->get_absensi_pegawai_by_month($id, $bulan);
        $data['gaji']=$this->Hrms_model->get_gaji_by_pegawai($id);
        $data['bulan']=$bulan;
        $potongan=$this->Hrms_model->get_potongan($id, $bulan);
        $data['potongan']=($potongan != null ? $potongan->potongan_bpjs : 0);
        $data['cicilan']=($potongan != null ? $potongan->cicilan : 0);
        $data['kasbon']=($potongan != null ? $potongan->kasbon : 0);
        $total_tepat_waktu=0;
        $durasi_lembur=$durasi_telat=0;
        foreach ($data['absensi'] as $key => $value) {
            $durasi_lembur+=$value->durasi_lembur;
            if ($value->jam_datang <= $value->jadwal_datang_shift) {
                $total_tepat_waktu+=1;
            }else{
                $jam_masuk=explode(':', $value->jam_datang);
                $jam_masuk_real=explode(":", $value->jam_datang);
                $telat=$jam_masuk_real[0]-$jam_masuk[0];
                $durasi_telat+=$telat;
                // $selisih=$jam_masuk_real->diff($jam_masuk);
                // $jam=$selisih->format('%h');
                // $menit=$selisih->format('%i');
                // if ($menit >= 0 && $menit <= 9) {
                //     $menit="0".$menit;
                // }
                // $hasil=$jam.":".$menit;
                // $hasil=number_format($hasil, 2);
                // print_r($hasil);
                // $jam_start = "07";
                // $menit_start = "10";
                // $jam_end = "16";
                // $menit_end = "15";
                  
                // $date_akhir  = new DateTime($jam_masuk[0].":".$jam_masuk[1]);
                // $date_awal = new DateTime("11:".$jam_masuk_real[1]);
                // $selisih = $date_akhir->diff($date_awal);

                // $jam = $selisih->format('%h');
                // $menit = $selisih->format('%i');
                 
                //  if($menit >= 0 && $menit <= 9){
                //    $menit = "0".$menit;
                //  }
                 
                // $hasil = $jam.".".$menit;
                // $hasil = number_format($hasil,2);
                // print_r($hasil);
            }
        }
        
        $data['tepat_waktu']=$total_tepat_waktu;
        $data['durasi_lembur']=$durasi_lembur;
        $data['durasi_telat']=$durasi_telat;
        $this->template->load('template','hrms/gaji/detail_slip_gaji_pegawai', $data);
    }
    public function inputPotongan(){
       $id_pegawai=$this->input->post('id_pegawai');
       $bulan=$this->input->post('bulan');
       $potongan = $this->input->post('potongan');
       $cicilan=$this->input->post('cicilan');
       $kasbon=$this->input->post('kasbon');
       // var_dump($_POST);
       // exit();
       $row=$this->db->where('id_pegawai', $id_pegawai)->where('bulan', $bulan)->get('tbl_potongan_gaji')->row();
       if (count($row) == 0) {
           $data=array(
                'id_pegawai'        => $this->input->post('id_pegawai'),
                'potongan_bpjs'     => $this->currency($potongan),
                'cicilan'           => $this->currency($cicilan),
                'kasbon'            => $this->currency($kasbon),
                'bulan'             => $this->input->post('bulan'),
           );
            $this->Hrms_model->insert_setting('tbl_potongan_gaji', $data);
       }else{
            $potongan = ($this->input->post('potongan') == '' ? $row->potongan_bpjs : $this->input->post('potongan'));
            $cicilan=($this->input->post('cicilan') == '' ? $row->cicilan : $this->input->post('cicilan'));
            $kasbon=($this->input->post('kasbon') == '' ? $row->kasbon : $this->input->post('kasbon'));
            $data=array(
                'potongan_bpjs'     => $this->currency($potongan),
                'cicilan'           => $this->currency($cicilan),
                'kasbon'            => $this->currency($kasbon),
           );
            $where=array('id_potongan' => $row->id_potongan);
            $update=$this->Hrms_model->update($where, $data, 'tbl_potongan_gaji');
       }
       $data = array(
            'bulan' => $bulan
        );
        $this->session->set_userdata($data);
       redirect('hrms/gaji/slip/'.$this->input->post('id_pegawai'));
    }
    public function cetak_slip(){
        $id=$this->input->post('id_pegawai');
        $bulan=0;
        if ($this->input->post('bulan')) {
            $bulan=$this->input->post('tahun').'-'.$this->input->post('bulan');
        }elseif ($this->session->userdata('bulan')) {
            $bulan=$this->session->userdata('bulan');
        }else{
            $bulan=date('Y-m');
        }
        $data['absensi']=$this->Hrms_model->get_absensi_pegawai_by_month($id, $bulan);
        $data['gaji']=$this->Hrms_model->get_gaji_by_pegawai($id);
        $data['bulan']=$bulan;
        $potongan=$this->Hrms_model->get_potongan($id, $bulan);
        $data['potongan']=($potongan != null ? $potongan->potongan_bpjs : 0);
        $data['cicilan']=($potongan != null ? $potongan->cicilan : 0);
        $data['kasbon']=($potongan != null ? $potongan->kasbon : 0);
        $total_tepat_waktu=0;
        $durasi_lembur=$durasi_telat=0;
        foreach ($data['absensi'] as $key => $value) {
            $durasi_lembur+=$value->durasi_lembur;
            if ($value->jam_datang <= $value->jadwal_datang_shift) {
                $total_tepat_waktu+=1;
            }else{
                $jam_masuk=explode(':', $value->jam_datang);
                $jam_masuk_real=explode(":", $value->jam_datang);
                $telat=$jam_masuk_real[0]-$jam_masuk[0];
                $durasi_telat+=$telat;
            }
        }
        
        $data['tepat_waktu']=$total_tepat_waktu;
        $data['durasi_lembur']=$durasi_lembur;
        $data['durasi_telat']=$durasi_telat;
        $this->load->view('hrms/gaji/cetak_slip_gaji', $data);
    }
    private function currency($val){
        $data=explode('.', $val);
        $new=implode('', $data);
        return $new;
    }
    
}