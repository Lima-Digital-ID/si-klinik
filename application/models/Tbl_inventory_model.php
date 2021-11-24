<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Tbl_inventory_model extends CI_Model
{
    private $_table = 'tbl_inventory';

    function __construct()
    {
        parent::__construct();
    }

    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_adj()
    {
        // $this->db->select('*');
        // $this->db->from('tbl_inventory');
        // $this->db->where('inv_type','STOCK_ADJ');
        // return $this->db->get();
        $query = $this->db->get_where('tbl_inventory', array('inv_type' => 'STOCK_ADJ'));
        return $query;
    }

    function get_adj_detail($id)
    {
        // $this->db->select('*');
        // $this->db->from('tbl_inventory');
        // $this->db->where('inv_type','STOCK_ADJ');
        // return $this->db->get();
        $query = $this->db->get_where('tbl_inventory', array('id_inventory' => $id));
        return $query;
    }

    function json(){
        $this->datatables->select('id_inventory, kode_purchase');
        $this->datatables->from('tbl_inventory');
        $this->datatables->where('inv_type','STOCK_ADJ');
        $this->datatables->add_column('action', anchor('', '<i class="fa fa-eye" aria-hidden="true"></i>', 'class="btn btn-info btn-sm btn-detail"') );
        return $this->datatables->generate();
    }

    function json_detail(){
        $this->datatables->select('td.id_inventory_detail, td.id_inventory, tb.nama_barang, tg.nama_gudang, tl.lokasi, td.jumlah, td.harga, td.diskon, td.tgl_exp, td.notes');
        $this->datatables->from('tbl_inventory_detail td');
        $this->datatables->join('tbl_obat_alkes_bhp tb', 'tb.kode_barang=td.kode_barang');
        $this->datatables->join('tbl_gudang tg', 'tg.kode_gudang=td.kode_gudang');
        $this->datatables->join('tbl_lokasi_barang tl', 'tl.id_lokasi_barang=td.id_lokasi_barang');
        // $where = "td.id_inventory = RCP1637725555";
        $this->datatables->where('td.id_inventory', 'RCP1637725555');
        return $this->datatables->generate();
        // return $this->db->get()->result_array();

    }

    function json_detail_barang()
    {
        $this->datatables->select('kode_barang, ');
    }
}