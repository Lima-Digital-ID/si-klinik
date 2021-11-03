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
}
