<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_kartu_hutang_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    public function cekLunas($kode_purchase)
    {
        $this->db->select('coalesce(sum(nominal),0) ttlBayar');
        $bayar = $this->db->get_where('tbl_kartu_hutang',['kode_purchase' => $kode_purchase,'tipe' => '1'])->row();

        $this->db->select('nominal');
        $hutang = $this->db->get_where('tbl_kartu_hutang',['kode_purchase' => $kode_purchase,'tipe' => '0'])->row();

        if($bayar->ttlBayar==$hutang->nominal){
            return "Lunas";
        }
        else{
            return "Belum";
        }
    }

}