<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_diagnosa_icd10_model extends CI_Model
{
    public $table = 'tbl_diagnosa_icd10';

    public function getAll()
    {
        $this->db->order_by('code','asc');
        return $this->db->get($this->table)->result();
    }
    public function icd10_terbanyak()
    {
        $this->datatables->select('code,diagnosa,count(p.id_diagnosa) ttl');
        $this->datatables->from('tbl_periksa_diagnosa p');
        $this->datatables->join('tbl_diagnosa_icd10 i','p.id_diagnosa = i.id_diagnosa');
        $this->db->group_by('p.id_diagnosa');
        $this->db->order_by('ttl','desc');
        return $this->datatables->generate();
    }
}
