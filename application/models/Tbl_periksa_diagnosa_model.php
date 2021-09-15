<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_periksa_diagnosa_model extends CI_Model
{
    public $table = 'tbl_periksa_diagnosa';

    public function insert($val)
    {
        $this->db->insert($this->table,$val);
    }
}