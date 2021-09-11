<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_pegawai_model extends CI_Model
{

    public $table = 'tbl_pegawai';
    public $id = 'id_pegawai';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('tbl_pegawai.*, tbl_jabatan.nama_jabatan, tbl_pegawai.id_pegawai, coalesce(tbl_klinik.nama, "-") as nama_klinik, tbl_shift.*');
        $this->datatables->from('tbl_pegawai');
        $this->datatables->join('tbl_jabatan', 'tbl_jabatan.id_jabatan=tbl_pegawai.id_jabatan');
        $this->datatables->join('tbl_user','tbl_pegawai.id_pegawai=tbl_user.id_pegawai', 'left');
        $this->datatables->join('tbl_klinik','tbl_user.id_klinik=tbl_klinik.id_klinik','left');
        $this->datatables->join('tbl_shift','tbl_shift.id_shift=tbl_pegawai.id_shift','left');
        $this->datatables->add_column('action', anchor(site_url('hrms/pegawai/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-success btn-sm'))." 
                ".anchor(site_url('hrms/gaji/slip/$1'),'<i class="fa fa-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm'))."
                ".anchor(site_url('hrms/pegawai/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_pegawai');
        return $this->datatables->generate();
    }

    // get all
    function get_all($id_klinik)
    {
        $this->db->where('id_klinik', $id_klinik);
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }
    
    function get_all_jaga($id_klinik = null)
    {
        // $this->db->order_by($this->id, $this->order);
        $this->db->from('tbl_dokter');
        $this->db->join('tbl_user','tbl_dokter.id_dokter=tbl_user.id_dokter', 'left');
        $this->db->where('is_jaga', 1);
        if($id_klinik != null)
            $this->db->where('tbl_user.id_klinik', $id_klinik);
            
        return $this->db->get()->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    //get by no_pendaftaran
    function get_by_no_pendaftaran($id, $no_pendaftaran)
    {
        $this->db->where($this->id, $id);
        $this->db->where('no_pendaftaran', $no_pendaftaran);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_dokter', $q);
	$this->db->or_like('nama_dokter', $q);
	$this->db->or_like('jenis_kelamin', $q);
	$this->db->or_like('tempat_lahir', $q);
	$this->db->or_like('tanggal_lahir', $q);
	$this->db->or_like('id_agama', $q);
	$this->db->or_like('alamat_tinggal', $q);
	$this->db->or_like('no_hp', $q);
	$this->db->or_like('id_status_menikah', $q);
	$this->db->or_like('id_spesialis', $q);
	$this->db->or_like('no_izin_praktek', $q);
	$this->db->or_like('golongan_darah', $q);
	$this->db->or_like('alumni', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_dokter', $q);
	$this->db->or_like('nama_dokter', $q);
	$this->db->or_like('jenis_kelamin', $q);
	$this->db->or_like('tempat_lahir', $q);
	$this->db->or_like('tanggal_lahir', $q);
	$this->db->or_like('id_agama', $q);
	$this->db->or_like('alamat_tinggal', $q);
	$this->db->or_like('no_hp', $q);
	$this->db->or_like('id_status_menikah', $q);
	$this->db->or_like('id_spesialis', $q);
	$this->db->or_like('no_izin_praktek', $q);
	$this->db->or_like('golongan_darah', $q);
	$this->db->or_like('alumni', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Tbl_dokter_model.php */
/* Location: ./application/models/Tbl_dokter_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-11-27 18:45:56 */
/* http://harviacode.com */