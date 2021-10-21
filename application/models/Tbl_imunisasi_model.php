<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_imunisasi_model extends CI_Model
{
    public $table = 'tbl_imunisasi';

    // get data by id
    function get_where($where)
    {
        return $this->db->get_where($this->table,$where)->result_array();
    }
}