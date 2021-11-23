<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Tbl_inventory_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function json(){
        $this->datatables->select('id_inventory, kode_purchase');
        $this->datatables->from('tbl_inventory');
        $this->datatables->where('inv_type','STOCK_ADJ');
        $this->datatables->add_column('action', anchor(site_url('dataobat/edit_stok_adjustment/$1'),'<i class="fa fa-eye" aria-hidden="true"></i>',"class='btn btn-info btn-sm'"));
        return $this->datatables->generate();
    }

    function json_detail($id){
        $this->datatables->select('td.id_inventory_detail, td.id_inventory, tb.nama_barang, td.jumlah');
        $this->datatables->from('tbl_inventory_detail td');
        $this->datatables->join('tbl_obat_alkes_bhp tb', 'tb.kode_barang=td.kode_barang');
        // $where = "td.id_inventory = '$id_inventory'";
        $this->db->where('td.id_inventory', $id);
        // return $this->datatables->generate();
        return $this->db->get()->result_array();

    }

    function json_detail_barang()
    {
        $this->datatables->select('kode_barang, ');
    }
}