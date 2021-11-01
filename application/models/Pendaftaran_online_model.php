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
  
    function json()
    {
      $this->datatables->select('po.id_pendaftaran, dr.nama_dokter, po.id_dokter, po.nama_lengkap,po.nik,po.tanggal_lahir,po.golongan_darah, po.status_menikah, po.pekerjaan, po.alamat, po.kabupaten, po.rt, po.rw, po.nama_orang_tua_atau_istri, po.nomer_telepon, (CASE po.tipe_periksa WHEN 1 THEN "Periksa Medis" WHEN 2 THEN "Imunisasi Anak" WHEN 3 THEN "Kontrol Kehamilan" WHEN 4 THEN "Periksa Gigi" WHEN 5 THEN "Periksa Jasa" WHEN 6 THEN "Periksa Lab" ELSE 0 END) as tipe_periksa');
      $this->datatables->from('tbl_pendaftaran_online po');
      $this->datatables->join('tbl_dokter dr', 'po.id_dokter=dr.id_dokter');
      // $this->datatables->where('pd.is_periksa=0 OR pd.is_periksa=3');
      // $this->datatables->add_column('action', anchor(site_url('pendaftaran/update_pendaftar_online/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
      //       ".anchor(site_url('pendaftaran/delete_pendaftar_online/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Apakah kamu yakin ?\')"'), 'id_pendaftaran');
      $this->datatables->add_column('action', anchor('', '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'class="btn btn-success btn-sm btn-detail"') . " 
            " . anchor(site_url('pendaftaran/delete_pendaftar_online/$1'), '<i class="fa fa-trash-o" aria-hidden="true"></i>', 'data-total="$1" data-id="$2" class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Apakah kamu yakin ?\')"'), 'id_pendaftaran');
  
      return $this->datatables->generate();
    }
  
    public function detail_pendaftar_online()
    {
      $this->db->select('dr.nama_dokter, po.id_dokter, po.nama_lengkap, po.nik, po.tanggal_lahir, po.golongan_darah, po.status_menikah, po.pekerjaan, po.alamat, po.kabupaten, po.rt, po.rw, po.nama_orang_tua_atau_istri, po.nomer_telepon, po.tipe_periksa');
      $this->db->from('tbl_pendaftaran_online po');
      $this->db->join('tbl_dokter dr', 'po.id_dokter = dr.id_dokter');
      // $this->db->where('po.id_pendaftaran', $id);
      return $this->db->get()->result();
    }

    public function cekKodePendaftaran(){
      $query = $this->db->query("SELECT MAX(id_pendaftaran) as id from tbl_pendaftaran_online");
      $hasil = $query->row();
      return $hasil->id;
    }

    public function cekNikPendaftaran(){
      $query = $this->db->query("SELECT nik FROM tbl_pasien WHERE  nik = '351108'");
      $hasil = $query->row();
      return $hasil->nik;
    }
}