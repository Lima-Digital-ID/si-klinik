<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_sksehat_model extends CI_Model
{

    public $table = 'tbl_sksehat';
    public $id = 'nomor';

    public function insert($val)
    {
        $this->db->insert($this->table,$val);
    }

    public function getLastNomor()
    {
        $this->db->select('nomor');
        $this->db->order_by('nomor','desc');
        $this->db->limit(1);
        return $this->db->get($this->table,['MONTH(tgl_cetak)' => date('m'),'YEAR(tgl_cetak)' => date('Y')])->result();
    }
    public function getDetail($nomor)
    {
        $this->db->select("sk.*,d.nama_dokter");
        $this->db->join("tbl_dokter d","sk.id_dokter = d.id_dokter");
        $this->db->where('sk.nomor',$nomor);
        return $this->db->get($this->table." sk")->result_array()[0];
    }
}