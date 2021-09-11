<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Akun extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('akuntansi/Tbl_akun_model');
        $this->load->model('akuntansi/Akuntansi_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','akuntansi/master_akun/tbl_akun_list');
    } 
    
    public function json() {
        $data1=array();
        foreach ($this->Tbl_akun_model->get_all() as $key => $value) {
            $main=$this->db->select('nama_akun')->where('id_akun', $value->id_main_akun)->get('tbl_akun')->row();
            $row=array();
            $row['id_akun']= $value->id_akun;
            $row['no_akun']= $value->no_akun;
            $row['nama_akun']= $value->nama_akun;
            $row['level']= $value->level;
            $row['main']= ($main != null ? $main->nama_akun : '');
            $row['action']       = anchor(site_url('hrms/set_gaji/update/').$value->id_akun,'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
                ".anchor(site_url('hrms/set_gaji/delete/').$value->id_akun,'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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

    public function getTipe($id, $level) {
        header('Content-Type: application/json');
        echo json_encode($this->Tbl_akun_model->getTipe($id, $level));
    }
    public function getParent($id){
        header('Content-Type: application/json');
        echo json_encode($this->db->where('id_akun', $id)->get('tbl_akun')->row());
    }
    public function getLevel($id) {
        header('Content-Type: application/json');
        echo json_encode($this->Tbl_akun_model->getLevel($id));
    }
    public function getNoAkun($id) {
        header('Content-Type: application/json');
        $data=$this->Tbl_akun_model->getNoAkun($id);
        $data2=$this->db->where('id_akun', $id)->get('tbl_akun')->row();
        $akun= array('no_akun'=>$data->no_akun,'id_main_akun'=>$data->id_main_akun, 'no_akun_main'=>$data2->no_akun);
        echo json_encode($akun);
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('akuntansi/akun/create_action'),
            'id_akun' => set_value('id_akun'),
            'nama_akun' => set_value('nama_akun'),
    );
        $data['parent_option']=array();
        $data['parent_option'][''] = 'Pilih Parent';
        $parent_option_js=array();
        foreach ($this->Tbl_akun_model->getParent() as $key => $value) {
            $data['parent_option'][$value->id_akun]=$value->nama_akun;
            $parent_option_js[]=array(
                'label'     => $value->id_akun,
                'value'     => $value->no_akun,
            );
        }
        $data['parent_option_js']=json_encode($parent_option_js);
        $this->template->load('template','akuntansi/master_akun/tbl_akun_create', $data);
    }
    
    public function create_action() 
    {
        $row=$this->db->where('id_akun', $this->input->post('id_parent'))->get('tbl_akun')->row();
        $id_main_akun=0;
        $level=$this->input->post('level');
        $nama_akun=$this->input->post('nama_akun');
        $no_akun=$this->input->post('no_akun');
        $id_parent=$turunan1=$turunan2=$turunan3=0;
        $id_parent=($this->input->post('id_parent') ? $this->input->post('id_parent') : '');
        $turunan1=($this->input->post('level2') ? $this->input->post('level2') : '');
        $turunan2=($this->input->post('level3') ? $this->input->post('level3') : '');

        if ($level == 1) {
            $id_main_akun=$this->input->post('id_parent');
        }else if ($level == 2) {
            $id_main_akun=$this->input->post('level2');
        }else if ($level == 3) {
            $id_main_akun=$this->input->post('level3');
        }
        $data=array(
            'no_akun'         => $no_akun,
            'nama_akun'       => $nama_akun,
            'level'           => $level,
            'id_main_akun'    => $id_main_akun,
            'sifat_debit'     => $row->sifat_debit,
            'sifat_kredit'    => $row->sifat_kredit,
        );
        $this->Tbl_akun_model->insert($data);
        $row=$this->db->select_max('id_akun')->get('tbl_akun')->row();
        $data_d=array(
            'id_akun'           => $row->id_akun,
            'id_parent'         => $id_parent,
            'turunan1'          => $turunan1,
            'turunan2'          => $turunan2,
            'turunan3'          => $turunan3,
        );
        $this->db->insert('tbl_akun_detail', $data_d);
        $this->session->set_flashdata('message', 'Create Record Success 2');
        redirect(site_url('akuntansi/akun'));
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_akun_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('akuntansi/akun/update_action'),
                'id_akun' => set_value('id_akun', $row->id_akun),
                'no_akun' => set_value('no_akun', $row->no_akun),
                'nama_akun' => set_value('nama_akun', $row->nama_akun),
        );
            $this->template->load('template','akuntansi/master_akun/tbl_akun_update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('akuntansi/akun'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_akun', TRUE));
        } else {
            $data = array(
                'nama_akun' => $this->input->post('nama_akun',TRUE),
                'dtm_upd' => date("Y-m-d H:i:s",  time())
        );

            $this->Tbl_akun_model->update($this->input->post('id_akun', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('akuntansi/akun'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_akun_model->get_by_id($id);

        if ($row) {
            $this->Tbl_akun_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('akuntansi/akun'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('akuntansi/akun'));
        }
    }
    public function coa(){
        $data['data']=$this->db->where('level', 0)->get('tbl_akun')->result();
        $this->template->load('template','akuntansi/master_akun/list_coa', $data);
    }
    public function buku_besar(){
        $this->template->load('template','akuntansi/buku_besar/list_akun');
    }
    public function listAkunJson() {
        header('Content-Type: application/json');
        echo $this->Akuntansi_model->getListAkun();
    }
    public function detailBukuBesar($id){
        $date=date('Y-m');
        $cekParent=$this->db->where('id_akun', $id)->get('tbl_akun_detail')->row();
        if ($cekParent->id_parent == 3) {
            $data['data_saldo']=$this->Akuntansi_model->getSaldoAkun($id, $date);
        }else{
            $data['data_saldo']=$this->Akuntansi_model->getSaldoAkun(1, $date);
        }
        $data['akun']=$this->db->where('id_akun', $id)->get('tbl_akun')->row();
        $data['data']=$this->Akuntansi_model->getdetailBukuBesar(date('Y-m'), $id);
        $this->template->load('template','akuntansi/buku_besar/detail_akun', $data);
    }
    public function tutup_buku(){
        $id_akun=$this->input->post('id_akun');
        $tanggal=$this->input->post('tanggal');
        $getDate=explode('-', $tanggal);
        $date=$getDate[0].'-'.$getDate[1];
        $row=$this->Akuntansi_model->cekBukuBesar($id_akun, $date);
        if ($row == 1) {
            $this->session->set_flashdata('message', 'Belum bisa Tutup Buku');
            $this->session->set_flashdata('message_type', 'danger');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $data=array(
                'id_akun'       => $id_akun,
                'tanggal'       => date('Y-m-d'),
                'jumlah_saldo'  => $this->input->post('saldo'),
            );
            $this->db->insert('tbl_saldo_akun', $data);
            redirect(site_url('akuntansi/akun/buku_besar'));
        }
    }

    public function saldo(){
        // $data['akun']=$this->db->get('tbl_saldo_akun')->result();
        $this->template->load('template','akuntansi/buku_besar/saldo_akun_list');
    }

    public function json_saldo(){
        $this->db->select("*");
        $this->db->from('tbl_saldo_akun');
        $this->db->join('tbl_akun', 'tbl_saldo_akun.id_akun=tbl_akun.id_akun');
        $this->db->where('is_updated', 0);
        $data=$this->db->get()->result();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function create_saldo(){
        $data = array(
            'button' => 'Create',
            'action' => site_url('akuntansi/akun/save_saldo'),
        );
        $data['akun_option']=array();
        $data['akun_option'][''] = 'Pilih Akun / No Akun';
        $akun_option_js=array();


        $dataLevel0=$this->db->where('level', 0)->where('no_akun', 1)->get('tbl_akun')->result();
        foreach ($dataLevel0 as $key => $value) {

            $id_akun=$no_akun=$nama_akun=0;
            $dataLevel1=$this->db->where('level', 1)->where('id_main_akun', $value->id_akun)->get('tbl_akun')->result();

            foreach ($dataLevel1 as $k => $v) {
                $id_akun=$v->id_akun;
                $no_akun=$v->no_akun;
                $nama_akun=$v->nama_akun;
                $dataLevel2=$this->db->where('level', 2)->where('id_main_akun', $v->id_akun)->get('tbl_akun')->result();

                foreach ($dataLevel2 as $k2 => $v2) {
                    $id_akun=$v2->id_akun;
                    $no_akun=$v2->no_akun;
                    $nama_akun=$v2->nama_akun;
                    $dataLevel3=$this->db->where('level', 3)->where('id_main_akun', $v2->id_akun)->get('tbl_akun')->result();
                    foreach ($dataLevel3 as $k3 => $v3) {
                        $id_akun=$v3->id_akun;
                        $no_akun=$v3->no_akun;
                        $nama_akun=$v3->nama_akun;
                        $data['akun_option'][$id_akun]=$no_akun. ' | '.$nama_akun;
                        $akun_option_js[]=array(
                            'label'     => $id_akun,
                            'value'     => $no_akun. ' | '.$nama_akun
                        );
                    }
                    $data['akun_option'][$id_akun]=$no_akun. ' | '.$nama_akun;
                    $akun_option_js[]=array(
                        'label'     => $id_akun,
                        'value'     => $no_akun. ' | '.$nama_akun
                    );
                }
                $data['akun_option'][$id_akun]=$no_akun. ' | '.$nama_akun;
                $akun_option_js[]=array(
                    'label'     => $id_akun,
                    'value'     => $no_akun. ' | '.$nama_akun
                );
            }
        }
        $data['akun_option_js']=json_encode($akun_option_js);
        // $akun_option=array();
        // $akun_option['']='Pilih Akun';
        // foreach ($this->Tbl_akun_model->get_all() as $key => $value) {
        //     if ($value->level != 0) {
        //         $akun_option[$value->id_akun]=$value->nama_akun;
        //     }
        // }
        // $data['akun_option']=$akun_option;
        $this->template->load('template','akuntansi/buku_besar/create_saldo', $data);
    }
    public function save_saldo(){
        $row=$this->db->where('id_akun', $this->input->post('akun'))->get('tbl_saldo_akun')->num_rows();
        if ($row < 1) {
            $data=array(
                'id_akun'   => $this->input->post('akun'),
                'jumlah_saldo'   => $this->input->post('jumlah'),
                'tanggal'   => $this->input->post('tgl'),
                'is_updated'   => 0,
                );
            $this->db->insert('tbl_saldo_akun', $data);
            $data=array(
                'id_akun'   => $this->input->post('akun'),
                'jumlah_saldo'   => $this->input->post('jumlah'),
                'tanggal'   => $this->input->post('tgl'),
                'is_updated'   => 1,
                );
            $this->db->insert('tbl_saldo_akun', $data);
            redirect(site_url('akuntansi/akun/saldo'));
        }else{
            $this->session->set_flashdata('message', 'Record Not Found');
            $this->session->set_flashdata('message_type', 'danger');
            redirect(site_url('akuntansi/akun/saldo'));
        }
    }
    private function cek_saldo_akun($id, $level){
        $this->db->select('tbl_akun.*, tbl_saldo_akun.jumlah_saldo');
        $this->db->from('tbl_akun');
        $this->db->join('tbl_saldo_akun', 'tbl_akun.id_akun=tbl_saldo_akun.id_akun');
        $this->db->where('tbl_akun.level', $level);
        $this->db->where('tbl_akun.id_main_akun', $id);
        return $this->db->get()->result();
    }
    public function jurnal_besar(){
        $data['data']=$this->db->where('level', 0)->get('tbl_akun')->result();
        $this->template->load('template','akuntansi/buku_besar/jurnal_besar', $data);
    }
    public function _rules() 
    {
        $this->form_validation->set_rules('id_akun', 'id akun', 'trim');
        $this->form_validation->set_rules('nama_akun', 'nama akun', 'trim|required');
    }
}

/* End of file Dokter.php */
/* Location: ./application/controllers/Dokter.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-11-27 18:45:56 */
/* http://harviacode.com */