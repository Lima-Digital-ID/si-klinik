<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Tbl_stok_adjustment_model extends CI_Model
{
    function get_all()
    {
        $this->datatables->select("kode,tanggal");
        $this->datatables->from("tbl_stok_adjustment");
        $this->datatables->add_column('action', anchor(site_url('dataobat/detail_stok_adjustment/$1'), '<i class="fa fa-eye" aria-hidden="true"></i>', 'class="btn btn-info btn-sm btn-detail"'), 'kode' );
        return $this->datatables->generate();
    }
    function get_by_kode($kode)
    {
        $this->db->select("d.*,b.nama_barang");
        $this->db->join("tbl_obat_alkes_bhp b",'d.kode_barang = b.kode_barang');
        return $this->db->get_where("tbl_stok_adjustment_detail d",["d.kode" => $kode])->result();
    }
}