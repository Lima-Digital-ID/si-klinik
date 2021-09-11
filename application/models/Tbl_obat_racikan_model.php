<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_obat_racikan_model extends CI_Model
{

    public $table = 'tbl_obat_racikan';
    public $id = 'kode_obat_racikan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
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
	
	function get_all_alkes($id_klinik = null)
    {
        $this->db->where('jenis_obat_racikan', '2'); //Get jenis obat_racikan = alat kesehatan
        if($id_klinik != null)
            $this->db->where('id_klinik', $id_klinik);
        
        return $this->db->get($this->table)->result();
    }
	
	function get_all_obat($id_klinik = null)
    {
        $this->db->where('jenis_obat_racikan', '1'); //Get jenis obat_racikan = obat
        if($id_klinik != null)
            $this->db->where('id_klinik', $id_klinik);
        
        return $this->db->get($this->table)->result();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('kode_obat_racikan', $q);
	$this->db->or_like('nama_obat_racikan', $q);
	$this->db->or_like('id_kategori_obat_racikan', $q);
	$this->db->or_like('id_satuan_obat_racikan', $q);
	$this->db->or_like('harga', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('tbl_obat_racikan.kode_obat_racikan', $q);
	$this->db->or_like('tbl_obat_racikan.nama_obat_racikan', $q);
	$this->db->or_like('tbl_obat_racikan.id_kategori_obat_racikan', $q);
	$this->db->or_like('tbl_obat_racikan.id_satuan_obat_racikan', $q);
	$this->db->or_like('tbl_obat_racikan.harga', $q);
        $this->db->join('tbl_kategori_obat_racikan','tbl_kategori_obat_racikan.id_kategori_obat_racikan=tbl_obat_racikan.id_kategori_obat_racikan');
        $this->db->join('tbl_satuan_obat_racikan','tbl_satuan_obat_racikan.id_satuan=tbl_obat_racikan.id_satuan_obat_racikan');
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
    
    function json(){
        $this->datatables->select('*, kode_obat_racikan');
        $this->datatables->from('tbl_obat_racikan');
        $this->datatables->join('tbl_kategori_barang','tbl_kategori_barang.id_kategori_barang=tbl_obat_racikan.id_kategori_barang');
        $this->datatables->add_column('action', anchor(site_url('obat_racikan/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
                ".anchor(site_url('obat_racikan/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"')."
                ".anchor('#','<i class="fa fa-eye" aria-hidden="true"></i>',"class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal' onClick='javasciprt: cekDetail(\"$1\")'"), 'kode_obat_racikan');
            
        return $this->datatables->generate();
    }
    function json_detail_obat(){
        $this->datatables->select('to.kode_barang, to.nama_barang, tk.nama_kategori, tp.nama_pabrik, to.dosis, tor.*');
        $this->datatables->from('tbl_obat_racikan_child_obat torc');
        $this->datatables->join('tbl_obat_alkes_bhp to','to.kode_barang=torc.kode_barang');
        $this->datatables->join('tbl_kategori_barang tk','tk.id_kategori_barang=to.id_kategori_barang');
        $this->datatables->join('tbl_pabrik tp','tp.kode_pabrik=to.kode_pabrik', 'left');
        $this->datatables->join('tbl_obat_racikan tor','tor.kode_obat_racikan=torc.kode_obat_racikan');
        $this->datatables->add_column('action', anchor(site_url('obat_racikan/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
                ".anchor(site_url('obat_racikan/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"')."
                ".anchor('#','<i class="fa fa-eye" aria-hidden="true"></i>',"class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal' onClick='javasciprt: cekDetail(\"$1\")'"), 'kode_obat_racikan');
            
        return $this->datatables->generate();
    }
    function json_detail_jasa(){
        $this->datatables->select('tj.kode_jasa, tj.nama_jasa, tj.hna, tj.harga, tk.*');
        $this->datatables->from('tbl_obat_racikan_child_jasa');
        $this->datatables->join('tbl_jasa tj','tj.kode_jasa=tbl_obat_racikan_child_jasa.kode_jasa');
        $this->datatables->join('tbl_kategori_barang tk','tk.id_kategori_barang=tj.id_kategori_barang');
        $this->datatables->add_column('action', anchor(site_url('obat_racikan/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
                ".anchor(site_url('obat_racikan/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"')."
                ".anchor('#','<i class="fa fa-eye" aria-hidden="true"></i>',"class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal' onClick='javasciprt: cekDetail(\"$1\")'"), 'kode_obat_racikan');
            
        return $this->datatables->generate();
    }
    function insert_child($table, $data)
    {
        $this->db->insert($table, $data);
    }

}

/* End of file tbl_obat_racikan_model.php */
/* Location: ./application/models/tbl_obat_racikan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-09 11:24:01 */
/* http://harviacode.com */