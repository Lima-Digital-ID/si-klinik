<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi_obat_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all($table)
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($table)->result();
    }

    function get_list()
    {
        $this->db->select('kode_barang, nama_barang');
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($where, $table)
    {
        $this->db->where($where);
        return $this->db->get($table)->row();
    }
	
	function get_all_alkes($id_klinik = null)
    {
        $this->db->where('jenis_barang', '2'); //Get jenis barang = alat kesehatan
        if($id_klinik != null)
            $this->db->where('id_klinik', $id_klinik);
        
        return $this->db->get($this->table)->result();
    }
	
	function get_all_obat($id_klinik = null)
    {
        $this->db->where('jenis_barang', '1'); //Get jenis barang = obat
        if($id_klinik != null)
            $this->db->where('id_klinik', $id_klinik);
        
        return $this->db->get($this->table)->result();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('kode_barang', $q);
	$this->db->or_like('nama_barang', $q);
	$this->db->or_like('id_kategori_barang', $q);
	$this->db->or_like('id_satuan_barang', $q);
	$this->db->or_like('harga', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('tbl_obat_alkes_bhp.kode_barang', $q);
	$this->db->or_like('tbl_obat_alkes_bhp.nama_barang', $q);
	$this->db->or_like('tbl_obat_alkes_bhp.id_kategori_barang', $q);
	$this->db->or_like('tbl_obat_alkes_bhp.id_satuan_barang', $q);
	$this->db->or_like('tbl_obat_alkes_bhp.harga', $q);
        $this->db->join('tbl_kategori_barang','tbl_kategori_barang.id_kategori_barang=tbl_obat_alkes_bhp.id_kategori_barang');
        $this->db->join('tbl_satuan_barang','tbl_satuan_barang.id_satuan=tbl_obat_alkes_bhp.id_satuan_barang');
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($table, $data)
    {
        $insert=$this->db->insert($table, $data);
        if (!$insert) {
            return false;
        }
        return true;
    }

    // update data
    function update($id, $table, $data)
    {
        $this->db->where($id);
        $this->db->update($table, $data);
    }

    // delete data
    function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
    
    function json($id_klinik){
        $this->datatables->select('*, kode_purchase');
        $this->datatables->from('tbl_purchases');
        $this->datatables->join('tbl_apoteker','tbl_apoteker.id_apoteker=tbl_purchases.id_apoteker');
        $this->datatables->join('tbl_supplier','tbl_supplier.kode_supplier=tbl_purchases.kode_supplier');
        if ($id_klinik != null) {
            $this->datatables->where('tbl_purchases.id_klinik', $id_klinik);
        }
        // $this->datatables->add_column('action', anchor(site_url('transaksi_apotek/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
            // anchor(site_url('transaksi_apotek/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"')."
        $this->datatables->add_column('action', anchor('#','<i class="fa fa-eye" aria-hidden="true"></i>',"class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal' onClick='javasciprt: cekDetail(\"$1\")'")."
            ".anchor(site_url('transaksi_apotek/delete_po/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kode_purchase');
            
        return $this->datatables->generate();
    }

    function json_receipt($id_klinik){
        $this->db->select('*, kode_purchase');
        $this->db->from('tbl_purchases');
        $this->db->join('tbl_apoteker','tbl_apoteker.id_apoteker=tbl_purchases.id_apoteker');
        $this->db->join('tbl_supplier','tbl_supplier.kode_supplier=tbl_purchases.kode_supplier');
        if ($id_klinik != null) {
            $this->db->where('tbl_purchases.id_klinik', $id_klinik);
        }
        // $this->datatables->add_column('action', anchor(site_url('transaksi_apotek/receipt_order/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
        //         ".anchor(site_url('dataobat/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kode_purchase');
            
        return $this->db->get()->result();
    }
    function get_detail_po($id){
        $this->db->select('tbl_purchase_d.*, tb.nama_barang, tb.kode_barang, tsb.*, tp.kode_supplier');
        $this->db->from('tbl_purchase_d');
        $this->db->join('tbl_obat_alkes_bhp tb','tb.kode_barang=tbl_purchase_d.kode_barang');
        $this->db->join('tbl_satuan_barang tsb','tsb.id_satuan=tb.id_satuan_barang');
        $this->db->join('tbl_purchases tp','tp.kode_purchase=tbl_purchase_d.kode_purchase');
        $this->db->where('tbl_purchase_d.kode_purchase', $id);
        return $this->db->get()->result();
    }

    function get_detail_receipt($id){
        $this->db->select('tbl_purchase_d.*, tb.nama_barang, tb.kode_barang, tp.tanggal_po, t.id_inventory, tsb.*, ts.nama_supplier, tp.pengirim, ta.nama_apoteker');
        $this->db->from('tbl_purchase_d');
        $this->db->join('tbl_obat_alkes_bhp tb','tb.kode_barang=tbl_purchase_d.kode_barang');
        $this->db->join('tbl_satuan_barang tsb','tsb.id_satuan=tb.id_satuan_barang');
        $this->db->join('tbl_purchases tp','tp.kode_purchase=tbl_purchase_d.kode_purchase');
        $this->db->join('tbl_supplier ts','ts.kode_supplier=tp.kode_supplier');
        $this->db->join('tbl_inventory t','t.kode_purchase=tp.kode_purchase');
        $this->db->join('tbl_apoteker ta','ta.id_apoteker=tp.id_apoteker');
        $this->db->where('tbl_purchase_d.kode_purchase', $id);
        $this->db->like('inv_type', "RECEIPT_ORDER", 'both');
        return $this->db->get()->result();
    }

    function get_data_receipt($id){
        $this->db->select('tp.pengirim, tp.tanggal_po, tid.*, ta.nama_apoteker, ts.nama_supplier, tb.nama_barang, tb.kode_barang, tsb.keterangan, tg.nama_gudang, tl.lokasi');
        $this->db->from('tbl_inventory ti');
        $this->db->join('tbl_inventory_detail tid','tid.id_inventory=ti.id_inventory');
        $this->db->join('tbl_purchases tp','tp.kode_purchase=ti.kode_purchase');
        $this->db->join('tbl_obat_alkes_bhp tb','tb.kode_barang=tid.kode_barang');
        $this->db->join('tbl_satuan_barang tsb','tsb.id_satuan=tb.id_satuan_barang');
        $this->db->join('tbl_apoteker ta','ta.id_apoteker=tp.id_apoteker');
        $this->db->join('tbl_supplier ts','ts.kode_supplier=tp.kode_supplier');
        $this->db->join('tbl_gudang tg','tg.kode_gudang=tid.kode_gudang');
        $this->db->join('tbl_lokasi_barang tl','tl.id_lokasi_barang=tid.id_lokasi_barang');
        $this->db->where('ti.kode_purchase', $id);
        $this->db->like('ti.inv_type', "RECEIPT_ORDER", 'both');
        return $this->db->get()->result();
    }

    function json_detail_po($id){
        $this->db->select('tbl_purchase_d.*, tbl_obat_alkes_bhp.nama_barang');
        $this->db->from('tbl_purchase_d');
        $this->db->join('tbl_obat_alkes_bhp','tbl_obat_alkes_bhp.kode_barang=tbl_purchase_d.kode_barang');
        $this->db->where('tbl_purchase_d.kode_purchase', $id);
        return $this->db->get()->result_array();
    }

    function get_data_obat($id_klinik = null)
    {
        $this->db->select('tbl_obat_alkes_bhp.*, tbl_pabrik.nama_pabrik');
        $this->db->join('tbl_pabrik','tbl_obat_alkes_bhp.kode_pabrik=tbl_pabrik.kode_pabrik', 'left');
        $this->db->where('tbl_obat_alkes_bhp.jenis_barang', '1'); //Get jenis barang = obat
        if($id_klinik != null)
            $this->db->where('tbl_obat_alkes_bhp.id_klinik', $id_klinik);
        
        return $this->db->get($this->table)->result();
    }

    public function get_po($id){
        $this->db->select('kode_purchase');
        $this->db->from('tbl_inventory');
        $this->db->where('inv_type', 'RECEIPT_ORDER');
        if($id != null)
            $this->db->where('id_klinik', $id);
        
        return $this->db->get()->result();
    }
    public function get_retur($id){
        $this->db->select('ti.*, ti.id_inventory, ts.nama_supplier, tp.tanggal_po, ta.nama_apoteker');
        $this->db->from('tbl_inventory ti');
        $this->db->join('tbl_purchases tp', 'tp.kode_purchase=ti.kode_purchase');
        $this->db->join('tbl_supplier ts', 'ts.kode_supplier=tp.kode_supplier');
        $this->db->join('tbl_apoteker ta','ta.id_apoteker=tp.id_apoteker');
        $this->db->like('inv_type', "RETURN", 'both');
        if($id != null)
            $this->db->where('ti.id_klinik', $id);
        return $this->db->get()->result();
    }
    public function get_detail_retur($id){
        $this->db->select('ti.*, tid.*, tb.nama_barang, tsb.keterangan, tg.nama_gudang, tl.lokasi');
        $this->db->from('tbl_inventory ti');
        $this->db->join('tbl_inventory_detail tid','tid.id_inventory=ti.id_inventory');
        $this->db->join('tbl_obat_alkes_bhp tb','tb.kode_barang=tid.kode_barang');
        $this->db->join('tbl_satuan_barang tsb','tsb.id_satuan=tb.id_satuan_barang');
        $this->db->join('tbl_gudang tg','tg.kode_gudang=tid.kode_gudang');
        $this->db->join('tbl_lokasi_barang tl','tl.id_lokasi_barang=tid.id_lokasi_barang');
        $this->db->where('ti.id_inventory', $id);
        return $this->db->get()->result();
    }

}