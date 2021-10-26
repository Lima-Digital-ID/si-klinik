<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pendaftaran_online_model extends CI_Model
{
  public $table = "tbl_pendaftaran_online";
  public $id = "id_pendaftaran";
  public $order = "DESC";

  function __construct()
  {
      parent::__construct();
  }

  // ambil semua data
  public function get_all()
  {
    $this->db->order_by($this->id, $this->order);
    return $this->db->get($this->table)->result();
  }
  // get data by id
  function get_by_id($id)
  {
      $this->db->where($this->id, $id);
      return $this->db->get($this->table)->row();
  }

  function insert($data)
  {
      $this->db->insert($this->table, $data);
  }

    // delete data
    function delete($id){
      $this->db->where($this->id, $id);
      $this->db->delete($this->table);
    }
  
  function json(){
    $this->datatables->select('po.id_pendaftaran, dr.nama_dokter, po.nama_lengkap,po.nik,po.tanggal_lahir,po.golongan_darah, po.status_menikah, po.pekerjaan, po.alamat, po.kabupaten, po.rt, po.rw, po.nama_orang_tua_atau_istri, po.nomer_telepon, po.tipe_periksa');
    $this->datatables->from('tbl_pendaftaran_online po');
    $this->datatables->join('tbl_dokter dr', 'po.id_dokter=dr.id_dokter');
    // $this->datatables->where('pd.is_periksa=0 OR pd.is_periksa=3');
    $this->datatables->add_column('action', anchor(site_url('pendaftaran/update_pendaftar_online/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
          ".anchor(site_url('pendaftaran/delete_pendaftar_online/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Apakah kamu yakin ?\')"'), 'id_pendaftaran');
    
    return $this->datatables->generate();
  }
}